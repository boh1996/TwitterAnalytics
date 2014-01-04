<?php
class Analytics_model extends Base_model {
	public function __construct () {
		parent::__construct();
	}

	/**
	 * Fetches top alert words
	 * @param  integer $limit The max number of rows to fetch
	 * @param  string $date  Date/time range string
	 * @return array
	 */
	public function fetch_alert_words ( $limit = 10, $date = nulll ) {
		$where = "";
		if ( ! is_null($date) ) {
			preg_match("/(?P<start>.*) - (?P<end>.*)/", $date, $matches);
			$start = date_create($matches["start"]);
			$end = date_create($matches["end"]);
			if ( is_object($start) && is_object($end) ) {
				$where = ' WHERE created_at >=' . $this->db->escape($start->getTimestamp()) . ' AND created_at <= ' . $this->db->escape($end->getTimestamp());
			}
		}

		$limit = intval($limit);
		$query = $this->db->query('SELECT
    		ast.value as word,
    		twast.*
 		FROM alert_strings ast
	 	INNER JOIN(
	    SELECT COUNT(alert_string_id) AS word_count,
	    GROUP_CONCAT(tweet_id) as tweets,
	    alert_string_id,
	    COUNT(DISTINCT tweet_id) as unique_tweets
	    FROM tweet_alert_strings' . $where . ' GROUP BY alert_string_id)
		twast ON ast.id = twast.alert_string_id ORDER BY word_count DESC LIMIT ?
		', array($limit));

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$row->tweets = explode(",", $row->tweets);
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
		$settings = $this->settings_model->check_defaults("scraper",$this->settings_model->get_settings("scraper"));

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
	 * @return array<Objec>
	 */
	public function fetch_alert_box ( $word_limit = 50, $limit = 3, $date = null ) {
		$where = "";
		if ( ! is_null($date) ) {
			preg_match("/(?P<start>.*) - (?P<end>.*)/", $date, $matches);
			$start = date_create($matches["start"]);
			$end = date_create($matches["end"]);
			if ( is_object($start) && is_object($end) ) {
				$where = ' AND created_at >=' . $this->db->escape($start->getTimestamp()) . ' AND created_at <= ' . $this->db->escape($end->getTimestamp());
			}
		}

		$limit = intval($limit);
		$word_limit = intval($word_limit);
		$query = $this->db->query("SELECT * FROM (
				SELECT * FROM (
				    SELECT
				        w.word,
				        w.id as word_id,
				        tw.created_at,
				        tw.tweets,
				        tw.word_count,
				        tw.unique_tweets,
				        'user_type_word' AS type
				    FROM words w
				    INNER JOIN
				    (
				        SELECT COUNT(word_id) AS word_count,
				        GROUP_CONCAT(DISTINCT tweet_id ORDER BY tweet_id ASC) as tweets,
				        word_id,
				        created_at,
				        COUNT(DISTINCT tweet_id) as unique_tweets
				        FROM tweet_words
				        GROUP BY word_id
				    )tw
				    ON w.id = tw.word_id
				    UNION ALL
				    SELECT
				        ast.value as word,
				        ast.id as word_id,
				        twast.created_at,
				        twast.tweets,
				        twast.word_count,
				        twast.unique_tweets,
				        'user_type_alert_string' as type
				    FROM alert_strings ast
				    INNER JOIN
				    (
				        SELECT COUNT(alert_string_id) AS word_count,
				        GROUP_CONCAT(DISTINCT tweet_id ORDER BY tweet_id ASC) as tweets,
				        alert_string_id,
				        created_at,
				        COUNT(DISTINCT tweet_id) as unique_tweets
				        FROM tweet_alert_strings
				        GROUP BY alert_string_id
				    ) twast ON ast.id = twast.alert_string_id
				) words " . $where . " ORDER BY word_count DESC LIMIT ?
			) alerts WHERE type = 'user_type_alert_string'
			ORDER BY word_count DESC
			LIMIT ?"
		, array($word_limit, $limit));

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$row->tweets = explode(",", $row->tweets);
			$list[] = $row;
		}

		return $list;
	}

	/**
	 * Feches the list of top words, date
	 * @param  integer $limit Th number of words to fetch
	 * @param  string  $date  A date range, to fetch between
	 * @return array<Object>
	 */
	public function fetch_words ( $limit = 50, $date = null ) {
		$where = "";
		if ( ! is_null($date) ) {
			preg_match("/(?P<start>.*) - (?P<end>.*)/", $date, $matches);
			$start = date_create($matches["start"]);
			$end = date_create($matches["end"]);
			if ( is_object($start) && is_object($end) ) {
				$where = ' WHERE created_at >=' . $this->db->escape($start->getTimestamp()) . ' AND created_at <= ' . $this->db->escape($end->getTimestamp());
			}
		}

		$limit = intval($limit);
		$query = $this->db->query("SELECT * FROM (
			    SELECT
			        w.word,
			        w.id as word_id,
			        tw.created_at,
			        tw.tweets,
			        tw.word_count,
			        tw.unique_tweets,
			        'user_type_word' AS type
			    FROM words w
			    INNER JOIN
			    (
			        SELECT COUNT(word_id) AS word_count,
			        GROUP_CONCAT(DISTINCT tweet_id ORDER BY tweet_id ASC) as tweets,
			        word_id,
			        created_at,
			        COUNT(DISTINCT tweet_id) as unique_tweets
			        FROM tweet_words
			        GROUP BY word_id
			    )tw
			    ON w.id = tw.word_id
			    UNION ALL
			    SELECT
			        ast.value as word,
			        ast.id as word_id,
			        twast.created_at,
			        twast.tweets,
			        twast.word_count,
			        twast.unique_tweets,
			        'user_type_alert_string' as type
			    FROM alert_strings ast
			    INNER JOIN
			    (
			        SELECT COUNT(alert_string_id) AS word_count,
			        GROUP_CONCAT(DISTINCT tweet_id ORDER BY tweet_id ASC) as tweets,
			        alert_string_id,
			        created_at,
			        COUNT(DISTINCT tweet_id) as unique_tweets
			        FROM tweet_alert_strings
			        GROUP BY alert_string_id
			    ) twast ON ast.id = twast.alert_string_id
			) words
			" . $where . "
			ORDER BY word_count DESC
			LIMIT ?"
		, array($limit));

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$row->tweets = explode(",", $row->tweets);
			$list[] = $row;
		}

		return $list;
	}
}
?>