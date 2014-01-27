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
	 *
	 *    @return Object
	 */
	public function tweets_from_interval ( $max, $min ) {
		$this->db->query('SELECT
			    GROUP_CONCAT(created_at),
			    COUNT(DISTINCT tweet_id)
			FROM statistic_tweets
			WHERE created_at BETWEEN ? AND ?
		', array($min, $max));

		if ( ! $query->num_rows ) return false;

		return $query->row();
	}

	public function tweets_in_ranges ( $ranges ) {

	}

	/**
	 *    Returns a MySQL range string
	 *
	 *    @param integer $min Minimum integer
	 *    @param integer $max Maximum integer
	 *
	 *    @return string
	 */
	protected function _range_string ( $min, $max ) {
		return 'SUM(CASE WHEN created_at BETWEEN ' . $mib . ' AND ' . $max . ' THEN 1 ELSE 0 END) AS `' . $min . '-' . $max . '`';
	}
}