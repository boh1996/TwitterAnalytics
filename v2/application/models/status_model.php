<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage Control Panel
 * @license Microsoft Reference License
 * @extends Base_model
 * @version 1.0
 * @filesource
 */
class Status_model extends Base_model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 * Returns a list of the newest errors
	 * @param  integer $limit The number of errors to return
	 * @return array<Object>
	 */
	public function get_errors ( $limit = 10 ) {
		$query = $this->db->limit($limit)->order_by("created_at", "DESC")->get("errors");

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$list[] = $row;
		}

		return $list;
	}

	/**
	 * Gets the list of running scrapers
	 */
	public function get_active_scrapers () {
		$query = $this->db->query('SELECT runs.*, stats.*
			FROM scraper_runs runs
			INNER JOIN ( SELECT MAX(item_number) as max_item_number,
			    SUM(created_at) AS last_insert,
			    SUM(tweets_created) as stats_tweet_created,
			    SUM(tweets_fetched) as stats_tweet_fetched,
			    run_uuid,
			    scrape_statistics.type as stats_type,
			    item_id
			FROM scrape_statistics GROUP BY run_uuid) stats ON runs.run_uuid = stats.run_uuid
			WHERE runs.run_uuid NOT IN (SELECT history.run_uuid FROM `history`)'
		);

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$list[] = $row;
		}

		return $list;
	}

	/**
	 * Returns the finished scrapers
	 * @param  integer $limit The number of scrapers to return
	 * @return array<Object>
	 */
	public function get_history ( $limit = 10 ) {
		$this->db->limit($limit);
		$this->db->select("
			errors.created_at as error_created_at,
			history.created_at,
			history.tweets_created,
			history.tweets_fetched,
			history.run_uuid,
			errors.run_uuid,
			history.scraper,
			errors.error_string,
			scraper_runs.item_count
		");
		$this->db->order_by("history.created_at", "DESC");
		$this->db->join("errors", "history.run_uuid = errors.run_uuid", "left");
		$this->db->join("scraper_runs", "history.run_uuid = scraper_runs.run_uuid", "left");
		$query = $this->db->get("history");

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$list[] = $row;
		}

		return $list;
	}

	/**
	 * Fetches the list of available scrapers
	 * @return array
	 */
	public function get_scrapers () {
		return $this->base_model->get_list("scrapers");
	}
}