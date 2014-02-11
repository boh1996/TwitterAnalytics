<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage Page Data Model
 * @license Microsoft Reference License
 * @version 1.0
 * @filesource
 * @uses Base_model Uses the base model to do simple operations
 */
class Statistic_model extends Base_model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 *    Returns the count of the tweets and timestamps of the tweets from a timerange
	 *
	 *    @param integer $max The max time
	 *    @param integer $min The minimum time
	 *    @param integer $page_id An optional page id
	 *
	 *    @return Object
	 */
	public function tweets_from_interval ( $max, $min, $page_id = null ) {

		$query_string = 'SELECT
			    GROUP_CONCAT(created_at),
			    COUNT(DISTINCT tweet_id)
			FROM statistic_tweets
			WHERE created_at BETWEEN ? AND ?
		';

		if ( ! is_null($page_id) ) {
				$query_string .= ' AND id IN(
					SELECT tweet_id
					FROM page_tweets
					WHERE page_id = ' . $page_id . '
				)';
			}

		$this->db->query($query_string , array($min, $max));

		if ( ! $query->num_rows ) return false;

		return $query->row();
	}

	/**
	 *    Finds twwets in assigned ranges
	 *
	 *    @param array<int => arrayy(min, max)> $ranges A list of ranges
	 *    @param integer $page_id An optional page id
	 *    @param array &$labels A container for the category labels
	 *    @param integer &$avg The avarage tweet count
	 *
	 *    @return array<Object>
	 */
	public function tweets_ranges ( $ranges, $page_id = null, &$labels, &$avg ) {
		$list = array();

		$sum = 0;

		foreach ( $ranges as $index => $value ) {
			$min = $value[0];
			$max = $value[1];

			$query_string = 'SELECT
				    GROUP_CONCAT(created_at) as created,
				    COUNT(id) as tweet_count,
				    GROUP_CONCAT(DISTINCT id) as tweets,
				    GROUP_CONCAT(string_category, "@|", category_tweet_count SEPARATOR "@;" ) as categories,
				    string_category
				FROM statistic_tweets
				LEFT JOIN (
				    SELECT
				        tweet_id,
				        statistic_tweet_string_id,
				        COUNT(id) as category_tweet_count,
				        string_category
				    FROM statistic_tweet_strings
				    LEFT JOIN (
				    	SELECT
				    		category as string_category,
				    		id as string_id
				    	FROM statistic_strings
				    ) category_strings ON category_strings.string_id = statistic_tweet_strings.statistic_tweet_string_id
				    GROUP BY string_category
				) strings ON strings.tweet_id = statistic_tweets.id
				WHERE created_at BETWEEN ? AND ?
			';

			if ( ! is_null($page_id) ) {
				$query_string .= ' AND id IN(
					SELECT tweet_id
					FROM page_tweets
					WHERE page_id = ' . $page_id . '
				)';
			}

			$query = $this->db->query($query_string , array($min, $max));

			$row = $query->row();
			$row->created = explode(",", $row->created);
			$row->tweets = explode(",", $row->tweets);
			$row->strings = $this->top_strings(null, 10, $page_id, $min, $max);
			$categories = explode("@;", $row->categories);

			$row->categories = array();

			$this->load->model("settings_model");

			$largest = 0;
			$row->min = gmdate("d-m\TH:i", $min);
			$row->max = gmdate("d-m-\TH:i", $max);

			$labels[] = $row->min . " - " . $row->max;
			$row->color = $this->settings_model->fetch_setting("setting_default_zero_color", "#D1E0E0" , "viewer");
			$row->category = "NONE";

			$category_settings = $this->settings_model->get_categories();

			if ( empty($categories[0]) and count($row->strings) > 0 ) {
				unset($categories[0]);
				if ( isset($row->strings["categories"]) && is_array($row->strings["categories"]) ) {
					foreach ( $row->strings["categories"] as $category ) {
						$categories[$category["category"]->key] = array(1 => $category["count"], 0 => $category["category"]->key);
	 				}
 				}
			}

			foreach ( $categories as $key => $value ) {
				if ( ! is_array($value) ) {
					$value = explode("@|", $value);
				}

				if ( is_array($value) && count($value) > 1 ) {
					$count = $value[1];
					$cat = $value[0];
					$row->categories[] = array("count" => $count, "name" => $cat, "category" => $category_settings[$cat]);

					if ( $largest == 0 ) {
						$largest = $count;
						$row->category = $category_settings[$cat];
						$row->color = $this->settings_model->config_array_find("categories", "categories", $cat, "color");
					} else if ( $count > $largest ) {
						$largest = $count;
						$row->category = $category_settings[$cat];
						$row->color = $this->settings_model->config_array_find("categories", "categories", $cat, "color");
					}
				}
			}

			$list[$min] = $row;
			$sum = $sum + $row->tweet_count;
		}
		sort($list);

		$last = null;
		$last_key = null;

		foreach ( $list as $key => $object ) {
			if ( ! is_null($last) ) {
				if ( $last != 0 && $object->tweet_count != 0 ) {
					$list[$last_key]->change_next = floor(( ( $last - $object->tweet_count ) / ( ( $last + $object->tweet_count ) / 2 ) ) * 100);
				}
			}

			$last = $object->tweet_count;
			$last_key = $key;
		}

		$avg = $sum / count($list);

		return $list;
	}

	/**
	 *    The top scoring strings in the selected range
	 *
	 *    @param integer  $time_back The time to walk back in time to fetch strings for
	 *    @param integer $limit     The max number of strings
	 *    @param integer $page_id The page to fetch for
	 *    @param integer $start The starting time
	 *    @param integer $end Ending time
	 *
	 *    @return array
	 */
	public function top_strings ( $time_back = null, $limit = 10, $page_id, $start = null, $end = null ) {
		if ( is_null($end) ) {
			$end = time();
		}

		if ( is_null($start) ) {
			$start = $end - $time_back;
		}

		$min = $start;
		$max = $end;
		$query = $this->db->query('
			SELECT
			    COUNT(*) AS string_count,
			    statistic_tweet_string_id,
			    value,
			    category
			FROM statistic_tweet_strings
			INNER JOIN (
			    SELECT
			        value,
			        id as  string_id,
			        category
			    FROM statistic_strings
			) strings on strings.string_id = statistic_tweet_string_id
			WHERE tweet_id IN (
			    SELECT id
			    FROM statistic_tweets
			    WHERE created_at BETWEEN ? AND ? AND id IN ( SELECT tweet_id FROM page_tweets WHERE page_id = ? )
			)
			GROUP BY statistic_tweet_string_id
			ORDER BY string_count DESC
			LIMIT ' . intval($limit) . '
		', array($min, $max, $page_id));

		if ( ! $query->num_rows() ) return false;

		$categories = array();
		$list = array();

		$this->load->model("settings_model");
		$category_settings = $this->settings_model->get_categories();

		foreach ( $query->result() as $row ) {
			$row->category_settings = $category_settings[$row->category];
			$list[] = $row;

			if ( isset($categories[$row->category]) ) {
				$categories[$row->category]["count"] = $categories[$row->category]["count"] + $row->string_count;
			} else {
				$categories[$row->category] = array("count" => $row->string_count, "category" => $category_settings[$row->category]);
			}
		}

		return array(
			"strings" => $list,
			"categories" => $categories
		);
	}

	/**
	 *    Returns the categories with the number of strings from a given timeframe
	 *
	 *    @param integer  $time_back The minimum time for the interval
	 *    @param integer  $page_id   The page to fetch data from
	 *    @param integer $max The max time for the interval
	 *
	 *    @return array
	 */
	public function cateogories_sum ( $min, $page_id, $max ) {

		$query = $this->db->query('
			SELECT
			    COUNT(*) AS string_count,
			    category
			FROM statistic_tweet_strings
			INNER JOIN (
			    SELECT
			        id as  string_id,
			        category
			    FROM statistic_strings
			) strings on strings.string_id = statistic_tweet_string_id
			WHERE tweet_id IN (
			    SELECT id
			    FROM statistic_tweets
			    WHERE created_at BETWEEN ? AND ? AND id IN ( SELECT tweet_id FROM page_tweets WHERE page_id = ? )
			)
			GROUP BY statistic_tweet_string_id
		', array($min, $max, $page_id));

		if ( ! $query->num_rows() ) return false;

		$categories = array();

		foreach ( $query->result() as $row ) {
			if ( isset($categories[$row->category]) ) {
				$categories[$row->category]["count"] = $categories[$row->category]["count"] + $row->string_count;
			} else {
				$categories[$row->category] = array("count" => $row->string_count);
			}
		}

		return $categories;
	}

	/**
	 *    Creates and array containing $count ranges with with $amount distance between min and max
	 *
	 *    @param integer $amount The amount between min and max
	 *    @param integer $count  The number of ranges
	 *    @param integer $start The starting point
	 *    @param array @names A list of optional names for the ranges
	 *
	 *    @return array<array<Integer>> [0] is min and [1] is max
	 */
	public function create_time_ranges ( $amount, $count, $start, $names = array() ) {
		$ranges = array();
		$last = $start;
		for ( $i= 0; $i < $count ; $i++ ) {
			$max = $last;
			$min = $last - $amount + 1;
			$last = $last - $amount;
			$name = $i + 1;

			if ( isset($names[$i]) ) {
				$name = $names[$i];
			}

			$ranges[$name] = array($min, $max);
		}

		return $ranges;
	}

	/**
	 *    Fetches the sum of tweets for a number of ranges
	 *
	 *    @param array<name => Array(min, max)> $ranges The ranges
	 *    @param integer $page_id An optional page id
	 *
	 *    @return Array
	 */
	public function tweets_in_ranges_sum ( $ranges, $page_id = null ) {
		$query_string = "SELECT ";

		foreach ( $ranges as $name => $value ) {
			if ( is_integer($name) ) {
				$name = $value[0] . "-" . $value[1];
			}

			$query_string .= $this->_range_string($value[0], $value[1], $name);
		}

		$query_string = rtrim($query_string, ",");

		$query_string .= " FROM statistic_tweets";

		if ( ! is_null($page_id) ) {
			$query_string .= ' WHERE id IN(
				SELECT tweet_id
				FROM page_tweets
				WHERE page_id = ' . $page_id . '
			)';
		}

		$query = $this->db->query($query_string);

		if ( ! $query->result() ) return false;

		$list = array();

		$row = $query->row();

		foreach ( $row as $key => $value ) {
			$list[$key] = $value;
		}

		return $list;
	}

	/**
	 *    Returns a MySQL range string
	 *
	 *    @param integer $min Minimum integer
	 *    @param integer $max Maximum integer
	 *    @param string $name The interval name
	 *
	 *    @return string
	 */
	protected function _range_string ( $min, $max, $name ) {
		return 'SUM(CASE WHEN created_at BETWEEN ' . $min . ' AND ' . $max . ' THEN 1 ELSE 0 END) AS `' . $name . '`,';
	}
}