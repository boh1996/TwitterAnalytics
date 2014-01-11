<?php
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
		));

		if ( $tweets === false ) return false;

		$list = array();

		foreach ( $tweets as $row ) {
			$list[] = $row->tweet_id;
		}

		return $list;
	}

	/**
	 * Selects the connected word, to an alert string
	 * @param  integer  $alert_id The alert string id
	 * @param  integer $limit    The max number of words, returned
	 * @param string $date $date query
	 * @return array<Object>
	 */
	public function get_alert_connection_words ( $alert_id, $limit = 3, $date = null ) {
		$where = "";
		if ( ! is_null($date) ) {
			preg_match("/(?P<start>.*) - (?P<end>.*)/", $date, $matches);
			$start_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["start"]));
			$end_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["end"]));
			if ( is_object($start_time) && is_object($end_time) ) {
				$where = ' AND created_at BETWEEN ' . $this->db->escape($start_time->getTimestamp()) . ' AND ' . $this->db->escape($end_time->getTimestamp());
			}
		}

		$limit = intval($limit);
		$alert_id = intval($alert_id);

		$query = $this->db->query('
			SELECT
			    COUNT(tw.word_id) AS word_count,
			    tw.word_id,
			    GROUP_CONCAT(DISTINCT tweet_id ORDER BY tweet_id DESC) as tweets,
			    word
			FROM tweet_words tw
			INNER JOIN (
			    SELECT
			        word,
			        id
			    FROM words
			) words_table ON words_table.id = tw.word_id
			WHERE tweet_id IN (
			    SELECT tweet_id
			    FROM tweet_alert_strings
			    WHERE alert_string_id = ?
			    ' . $where . '
			)
			GROUP BY word_id
			ORDER BY word_count DESC
			LIMIT ?
		', array($alert_id, $limit));

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$list[] = $row;
		}

		return $list;
	}

	/**
	 * Fetches top alert words
	 * @param  integer $limit The max number of rows to fetch
	 * @param  string $date  Date/time range string
	 * @return array
	 */
	public function fetch_alert_words ( $limit = 10, $date = nulll ) {
		$this->load->model("settings_model");
		$where = "";
		if ( ! is_null($date) ) {
			preg_match("/(?P<start>.*) - (?P<end>.*)/", $date, $matches);
			$start_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["start"]));
			$end_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["end"]));
			if ( is_object($start_time) && is_object($end_time) ) {
				$where = ' WHERE created_at BETWEEN ' . $this->db->escape($start_time->getTimestamp()) . ' AND ' . $this->db->escape($end_time->getTimestamp());
			}
		}

		$limit = intval($limit);
		$query = $this->db->query('SELECT
    		ast.value as word,
    		twast.*
	 		FROM alert_strings ast
		 	INNER JOIN(
			    SELECT 
			    	COUNT(alert_string_id) AS word_count,
			   		GROUP_CONCAT(tweet_id) as tweets,
			    	alert_string_id,
			    	COUNT(DISTINCT tweet_id) as unique_tweets
		    	FROM (
		    		SELECT *
		    		FROm tweet_alert_strings' . $where . '  ) wherestrings
		    	GROUP BY alert_string_id
		    )
			twast ON ast.id = twast.alert_string_id ORDER BY word_count DESC LIMIT ?
		', array($limit));

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$row->tweets = explode(",", $row->tweets);
			$row->connected = $this->get_alert_connection_words($row->alert_string_id, $this->settings_model->fetch_setting("setting_alert_connection_words_shown", 3, "alerts"), $date);
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
	 * @return array<Objec>
	 */
	public function fetch_alert_box ( $word_limit = 50, $limit = 3, $date = null ) {
		$where = "";
		if ( ! is_null($date) ) {
			preg_match("/(?P<start>.*) - (?P<end>.*)/", $date, $matches);
			$start_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["start"]));
			$end_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["end"]));
			if ( is_object($start_time) && is_object($end_time) ) {
				$where = ' WHERE created_at BETWEEN ' . $this->db->escape($start_time->getTimestamp()) . ' AND ' . $this->db->escape($end_time->getTimestamp());
			}
		}

		$limit = intval($limit);
		$word_limit = intval($word_limit);
		$query = $this->db->query("SELECT * FROM (
				SELECT * FROM (
				    SELECT
				        w.word,
				        w.id as word_id,
				        tw.created_at as created_at,
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
				        FROM (
		                    SELECT *
		                    FROM tweet_words
		                    " . $where . "
                		) where_tweet_words
				        GROUP BY word_id
				    )tw
				    ON w.id = tw.word_id
				    UNION ALL
				    SELECT
				        ast.value as word,
				        ast.id as word_id,
				        twast.created_at as created_at,
				        twast.tweets,
				        twast.word_count,
				        twast.unique_tweets,
				        'user_type_alert_string' as type
				    FROM alert_strings ast
				    INNER JOIN
				    (
				        SELECT 
                    COUNT(alert_string_id) AS word_count,
                    GROUP_CONCAT(DISTINCT tweet_id ORDER BY tweet_id ASC) as tweets,
                    alert_string_id,
                    created_at,
                    COUNT(DISTINCT tweet_id) as unique_tweets
				        FROM (
                    SELECT *
                    FROM tweet_alert_strings
                    " . $where . "
                ) where_alert_strings
				        GROUP BY alert_string_id
				    ) twast ON ast.id = twast.alert_string_id
				) words ORDER BY word_count DESC LIMIT ?
			) alerts WHERE type = 'user_type_alert_string'
			ORDER BY word_count DESC
			LIMIT ?"
		, array($word_limit, $limit));

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$row->tweets = explode(",", $row->tweets);
			$row->connected = $this->get_alert_connection_words($row->word_id, $this->settings_model->fetch_setting("setting_alert_connection_words_shown", 3, "alerts"), $date);
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
			$start_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["start"]));
			$end_time = DateTime::createFromFormat("d/m/Y H:i", trim($matches["end"]));
			if ( is_object($start_time) && is_object($end_time) ) {
				$where = ' WHERE created_at BETWEEN ' . $this->db->escape($start_time->getTimestamp()) . ' AND ' . $this->db->escape($end_time->getTimestamp());
			}
		}

		$limit = intval($limit);
		$query = $this->db->query("SELECT * FROM (
			SELECT
				word,
				word_id,
				created_at,
				tweets,
				unique_tweets,
				word_count,
				type
			 FROM (
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
				        FROM (
				        	SELECT *
				        	FROM tweet_words
				       		" . $where . "
				       	) wheretweets
				        GROUP BY word_id
				    ) tw
				    ON w.id = tw.word_id
				) where1
			    UNION ALL
			    SELECT * FROM (
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
				        FROM (
				        	SELECT *
				        	FROM tweet_alert_strings
				        	" . $where . "
				        ) wherestring
				        GROUP BY alert_string_id
				    ) twast ON ast.id = twast.alert_string_id
				) where2
				ORDER BY type
			) words GROUP BY word ) result
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