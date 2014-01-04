<?php
class Analytics_model extends Base_model {
	public function __construct () {
		parent::__construct();
	}

	public function fetch_alert_words ( $words = NULL ) {

	}

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
		$query = $this->db->query('SELECT w.*, tw.tweets, tw.word_count, unique_tweets
			FROM words w
			 INNER JOIN (
			 	SELECT COUNT(word_id) AS word_count,
			 	GROUP_CONCAT(tweet_id) as tweets,
			 	word_id,
			 	COUNT(DISTINCT tweet_id) as unique_tweets
			 FROM tweet_words' . $where . ' GROUP BY word_id)
			 tw ON w.id = tw.word_id ORDER BY word_count DESC LIMIT ?
		', array($limit));

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