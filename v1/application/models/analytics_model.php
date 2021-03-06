<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage User Analytics Viewer
 * @license Microsoft Reference License
 * @extends Base_model
 * @version 1.0
 * @filesource
 */
class Analytics_model extends Base_model {
	public function __construct () {
		parent::__construct();
	}

	/**
	 * Returns an array of all the tweets connected to an alert string
	 * @param  integer $alert_string_id The alert string id
	 * @return array<Integer>
	 */
	public function get_alert_connection_tweets ( $alert_string_id ) {
		$tweets = $this->select("tweet_alert_strings", array(
			"alert_string_id" => $alert_string_id
		))->get();

		if ( $tweets === false ) return false;

		$list = array();

		foreach ( $tweets as $row ) {
			$list[] = $row->tweet_id;
		}

		return $list;
	}

	/**
	 * Retrieves the list of connected words that should be hidden.
	 * @param  boolean $only_id If only the id row should be returned
	 * @return array<Object>|array<Integer>
	 */
	public function get_hidden_connected_words ( $only_id = false ) {
		$query = $this->db->query('
			SELECT
			    value,
			    word_id
			FROM hidden_connected_words
			INNER JOIN (
			    SELECT
			        id as word_id,
			        word
			    FROM words
			) w ON w.word = hidden_connected_words.value COLLATE utf8_general_ci
		');

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			if ( $only_id === true ) {
				$list[] = intval($row->word_id);
			} else {
				$list[] = $row;
			}
		}

		return $list;
	}

	/**
	 * Selects the hidden words
	 * @param  boolean $only_id If only the ids should be in the list
	 * @return array<Object>|array<Integer>
	 */
	public function get_hidden_words ( $only_id = false ) {
		$query = $this->db->query('
			SELECT
			    value,
			    word_id
			FROM hidden_words
			INNER JOIN (
			    SELECT
			        id as word_id,
			        word
			    FROM words
			) w ON w.word = hidden_words.value COLLATE utf8_general_ci
		');

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			if ( $only_id === true ) {
				$list[] = intval($row->word_id);
			} else {
				$list[] = $row;
			}
		}

		return $list;
	}

	/**
	 *    FInds the words id b words
	 *
	 *    @param string $word The word
	 *
	 *    @return integer The word id
	 */
	public function get_word ( $word ) {
		$query = $this->db->select("id")->where(array(
			"word" => $word
		))->get("words");

		if ( ! $query->num_rows() ) return false;

		$row = $query->row();

		return $row->id;
	}

	/**
	 *    Fetches the alert value
	 *
	 *    @param integer $alert_id The alert string id
	 *
	 *    @return string
	 */
	public function get_alert_value ( $alert_id ) {
		$query = $this->db->select("value")->where(array(
			"id" => $alert_id
		))->get("alert_strings");

		if ( ! $query->num_rows() ) return false;

		$row = $query->row();

		return $row->value;
	}

	/**
	 * Selects the connected word, to an alert string
	 * @param  integer  $alert_id The alert string id
	 * @param  integer $limit    The max number of words, returned
	 * @param string $date $date query
	 * @param integer $max_time The max life time of tweets
	 * @return array<Object>
	 */
	public function get_alert_connection_words ( $alert_id, $limit = 3, $date = null, $max_time = null ) {
		$where = "";
		if ( ! is_null($date) && preg_match("/(?P<start>.*) - (?P<end>.*)/", $date, $matches) ) {
			$start_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["start"]));
			$end_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["end"]));
			if ( is_object($start_time) && is_object($end_time) ) {
				$where = ' AND tweet_words.created_at BETWEEN ' . $this->db->escape($start_time->getTimestamp()) . ' AND ' . $this->db->escape($end_time->getTimestamp());
			}
		} else if ( ! is_null($max_time) ) {
			$max = time() - $max_time;
			$where = ' AND tweet_words.created_at BETWEEN ' . $max . ' AND ' . time();
		}

		$limit = intval($limit);
		$alert_id = intval($alert_id);

		$alert_word_id = $this->get_word($this->get_alert_value($alert_id));

		$hidden = $this->get_hidden_connected_words(true);

		if ( $alert_word_id !== false ) {
			$hidden[] = $alert_word_id;
		}

		if ( $hidden !== false && count($hidden) > 0 ) {
			$hidden_string = " AND word_id NOT IN (" . implode(",",$hidden) . ")";
		} else {
			$hidden_string = "";
		}

		$query = $this->db->query('
			SELECT
			    COUNT(*) as word_count,
			    word,
			    word_id
			FROM tweet_words
			JOIN words ON words.id = tweet_words.word_id
			WHERE tweet_id IN (
			    SELECT tweet_id
			    FROM tweet_alert_strings
			    WHERE alert_string_id = ?
			)
			' . $hidden_string . '
			 ' . $where . '
			GROUP BY word_id
			ORDER BY word_count DESC
			LIMIT ?
		', array($alert_id, $limit));

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$row->word = ucfirst($row->word);
			$list[] = $row;
		}

		return $list;
	}

	/**
	 * Fetches top alert words
	 * @param  integer $limit The max number of rows to fetch
	 * @param  string $date  Date/time range string
	 * @param integer $max_time The max life time
	 * @return array
	 */
	public function fetch_alert_words ( $limit = 10, $date = nulll, $max_time = null ) {
		$this->load->model("settings_model");
		$where = "";
		if ( ! is_null($date) && preg_match("/(?P<start>.*) - (?P<end>.*)/", $date, $matches) ) {
			$start_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["start"]));
			$end_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["end"]));
			if ( is_object($start_time) && is_object($end_time) ) {
				$where = ' WHERE tweet_alert_strings.created_at BETWEEN ' . $this->db->escape($start_time->getTimestamp()) . ' AND ' . $this->db->escape($end_time->getTimestamp());
			}
		} else if ( ! is_null($max_time) ) {
			$max = time() - $max_time;
			$where = ' WHERE tweet_alert_strings.created_at BETWEEN ' . $max . ' AND ' . time();
		}

		$limit = intval($limit);
		$query = $this->db->query('
			SELECT
			    COUNT(*) as word_count,
			    alert_string_id as word_id,
			    alert_strings.value as word
			FROM tweet_alert_strings
			JOIN alert_strings ON alert_strings.id = tweet_alert_strings.alert_string_id
			' . $where . '
			GROUP BY alert_string_id
			ORDER BY word_count DESC
			LIMIT ?
		', array($limit));

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$row->word = ucfirst($row->word);
			$row->connected = $this->get_alert_connection_words($row->word_id, $this->settings_model->fetch_setting("setting_alert_connection_words_shown", 3, "alerts"), $date);
			$list[] = $row;
		}

		return $list;
	}

	/**
	 * Retrieves the limit select values
	 * @return array
	 */
	public function limits () {
		$this->config->load("defaults");
		$this->load->model("settings_model");
		$settings = $this->settings_model->check_defaults("analytics",$this->settings_model->get_settings("analytics"));

		$limits = $this->config->item("limit_values");

		if ( ! in_array($settings["setting_words_shown"]->value, $limits) ) {
			$limits["value"] = $settings["setting_words_shown"]->value;
		}

		return $limits;
	}

	/**
	 * Fetches the words for the alert box
	 * @param integer $word_limit The max number of words
	 * @param  integer $limit The number of words to show
	 * @param  integer  $date  The date range
	 * @param integer $max_time The max life time of the shown tweets if no date present
	 * @return array<Objec>
	 */
	public function fetch_alert_box ( $word_limit = 50, $limit = 3, $date = null, $max_time = null ) {
		$where = "";
		if ( ! is_null($date) && preg_match("/(?P<start>.*) - (?P<end>.*)/", $date, $matches) ) {
			$start_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["start"]));
			$end_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["end"]));
			if ( is_object($start_time) && is_object($end_time) ) {
				$where = ' WHERE tweet_words.created_at BETWEEN ' . $this->db->escape($start_time->getTimestamp()) . ' AND ' . $this->db->escape($end_time->getTimestamp());
			}
		} else if ( ! is_null($max_time) ) {
			$max = time() - $max_time;
			$where = ' WHERE tweet_words.created_at BETWEEN ' . $max . ' AND ' . time();
		}

		$hidden = $this->get_hidden_words(true);
		if ( $hidden !== false && count($hidden) > 0 ) {
			if ( $where == "" ) {
				$hidden_string = " WHERE word_id NOT IN (" . implode(",",$hidden) . ")";
			} else {
				$hidden_string = " AND word_id NOT IN (" . implode(",",$hidden) . ")";
			}
		} else {
			$hidden_string = "";
		}

		$limit = intval($limit);
		$word_limit = intval($word_limit);

		$query = $this->db->query('
			SELECT * FROM (
				SELECT * FROM (
				    SELECT
				        COUNT(*) as word_count,
				        word_id,
				        word,
				        "user_type_word" AS type
				    FROM tweet_words
				    JOIN words ON words.id = tweet_words.word_id
				    ' . $where . '
				    ' . $hidden_string . '
				    GROUP BY word_id
				    ORDER BY word_count DESC
	    			LIMIT ?
				) tweets
				UNION ALL
				SELECT * FROM (
				    SELECT
				        COUNT(*) as word_count,
				        alert_strings.id as word_id,
				        alert_strings.value as word,
				        "user_type_alert_string" as type
				    FROM tweet_alert_strings
				    JOIN alert_strings ON alert_strings.id = tweet_alert_strings.alert_string_id
				    ' . str_replace("tweet_words", "tweet_alert_strings", $where) . '
				    GROUP BY word_id
				    ORDER BY word_count DESC
	    			LIMIT ?
				) strings
				ORDER BY word_count DESC
				LIMIT ?
			) words
			WHERE type = "user_type_alert_string"
			ORDER BY word_count DESC
			LIMIT ?
		', array($word_limit, $word_limit, $word_limit, $limit));

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$row->word = ucfirst($row->word);
			$row->connected = $this->get_alert_connection_words($row->word_id, $this->settings_model->fetch_setting("setting_alert_connection_words_shown", 3, "alerts"), $date, $max_time);
			$list[] = $row;
		}

		return $list;
	}

	/**
	 *    Counts the number of tweets found in the range
	 *
	 *    @param string  $date     The date string
	 *    @param integer  $max_time Max time int
	 *
	 *    @return integer
	 */
	public function get_tweet_count ( $date = null, $max_time = null ) {
		$where = "";
		if ( ! is_null($date) && preg_match("/(?P<start>.*) - (?P<end>.*)/", $date, $matches) ) {
			$start_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["start"]));
			$end_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["end"]));
			if ( is_object($start_time) && is_object($end_time) ) {
				$where = ' WHERE tweets.created_at BETWEEN ' . $this->db->escape($start_time->getTimestamp()) . ' AND ' . $this->db->escape($end_time->getTimestamp());
			}
		} else if ( ! is_null($max_time) ) {
			$max = time() - intval($max_time);
			$where = ' WHERE tweets.created_at BETWEEN ' . $max . ' AND ' . time();
		}

		$query = $this->db->query("SELECT id FROM tweets" . $where );

		//echo $this->db->last_query();

		return ( $query->num_rows() !== false ) ? $query->num_rows() : 0;
	}

	/**
	 * Feches the list of top words, date
	 * @param  integer $limit Th number of words to fetch
	 * @param  string  $date  A date range, to fetch between
	 * @param integer $max_time The max lifetime of tweets if no date present
	 * @return array<Object>
	 */
	public function fetch_words ( $limit = 50, $date = null, $max_time = null ) {
		$where = "";
		if ( ! is_null($date) && preg_match("/(?P<start>.*) - (?P<end>.*)/", $date, $matches) ) {
			$start_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["start"]));
			$end_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["end"]));
			if ( is_object($start_time) && is_object($end_time) ) {
				$where = ' WHERE tweet_words.created_at BETWEEN ' . $this->db->escape($start_time->getTimestamp()) . ' AND ' . $this->db->escape($end_time->getTimestamp());
			}
		} else if ( ! is_null($max_time) ) {
			$max = time() - intval($max_time);
			$where = ' WHERE tweet_words.created_at BETWEEN ' . $max . ' AND ' . time();
		}

		$hidden = $this->get_hidden_words(true);
		if ( $hidden !== false && count($hidden) > 0 ) {
			$hidden_string = " AND word_id NOT IN (" . implode(",",$hidden) . ")";
		} else {
			$hidden_string = "";
		}

		$limit = intval($limit);

		$query = $this->db->query(
			'SELECT * FROM (
			    SELECT
			        COUNT(*) as word_count,
			        word_id,
			        word,
			        "user_type_word" AS type
			    FROM tweet_words
			    JOIN words ON words.id = tweet_words.word_id
			    ' . $where . '
			    ' . $hidden_string . '
			    GROUP BY word_id
			    ORDER BY word_count DESC
    			LIMIT ?
			) tweets
			UNION ALL
			SELECT * FROM (
			    SELECT
			        COUNT(*) as word_count,
			        alert_strings.id as word_id,
			        alert_strings.value as word,
			        "user_type_alert_string" as type
			    FROM tweet_alert_strings
			    JOIN alert_strings ON alert_strings.id = tweet_alert_strings.alert_string_id
			    ' . str_replace("tweet_words", "tweet_alert_strings", $where) . '
			    GROUP BY alert_string_id
			    ORDER BY word_count DESC
    			LIMIT ?
			) strings
			ORDER BY word_count DESC
			LIMIT ?
		', array($limit, $limit, $limit));

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$row->word = ucfirst($row->word);
			$list[] = $row;
		}

		return $list;
	}
}
?>