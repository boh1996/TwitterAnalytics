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
	 *
	 *    @return array<Object>
	 */
	public function tweets_ranges ( $ranges, $page_id = null ) {
		$list = array();

		foreach ( $ranges as $index => $value ) {
			$min = $value[0];
			$max = $value[1];

			$query_string = 'SELECT
				    GROUP_CONCAT(created_at) as created,
				    COUNT(id) as tweet_count,
				    GROUP_CONCAT(DISTINCT id) as tweets,
				    GROUP_CONCAT(category, "@|", category_tweet_count SEPARATOR "@;" ) as categories
				FROM statistic_tweets
				LEFT JOIN (
				    SELECT
				        tweet_id,
				        statistic_tweet_string_id,
				        category,
				        COUNT(id) as category_tweet_count
				    FROM statistic_tweet_strings
				    GROUP BY category
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
			$categories = explode("@;", $row->categories);

			$row->categories = array();

			$this->load->model("settings_model");

			$largest = 0;
			$row->color = $this->settings_model->fetch_setting("setting_default_zero_color", "#D1E0E0" , "viewer");
			$row->category = "NONE";

			foreach ( $categories as $value ) {
				$value = explode("@|", $value);
				if ( is_array($value) && count($value) > 1 ) {
					$count = $value[1];
					$cat = $value[0];
					$row->categories[$cat] = $count;

					if ( $count > $largest ) {
						$largest = $count;
						$row->category = $cat;
						$row->color = $this->settings_model->config_array_find("categories", "categories", $cat, "color");
					}
				}
			}

			$list[] = $row;
		}

		return $list;
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