<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage Scraper
 * @license Microsoft Reference License
 * @extends Base_model
 * @version 1.0
 * @filesource
 */
class Scrape_model extends Base_model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 * Creates an errror
	 * @param  string $error_string The error string
	 * @param  string $url          The url where the error occured
	 * @param  string $run_uuid     The run where the error occured
	 * @param  string $item_type    The fetched item type
	 * @param  integer $item_id      The fetched item it
	 */
	public function create_error ( $error_string, $url, $run_uuid, $item_type = NULL, $item_id = NULL ) {
		$this->db->insert("errors", array(
			"error_string" => $error_string,
			"url" => $url,
			"created_at" => time(),
			"run_uuid" => $run_uuid,
			"item_type" => $item_type,
			"item_id" => $item_id
		));
	}

	/**
	 * Creates a history item
	 * @param  integer $tweets_created The number of added tweets
	 * @param  string $scraper      The scraper that just finished
	 * @param integer $tweets_fetched The number of tweets loaded from twitter
	 * @param string $uuid The run uuid
	 * @param string $end_microtime The micro timestamp when the scraping ended
	 */
	public function create_history_item ( $tweets_created, $scraper, $tweets_fetched, $uuid, $end_microtime ) {
		$this->db->insert("history", array(
			"created_at" => time(),
			"tweets_created" => $tweets_created,
			"scraper" => $scraper,
			"tweets_fetched" => $tweets_fetched,
			"run_uuid" => $uuid,
			"end_microtime" => $end_microtime
		));
	}

	/**
	 * Generates a UUID id
	 * @return string
	 */
	public function gen_uuid() {
	    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
	        // 32 bits for "time_low"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

	        // 16 bits for "time_mid"
	        mt_rand( 0, 0xffff ),

	        // 16 bits for "time_hi_and_version",
	        // four most significant bits holds version number 4
	        mt_rand( 0, 0x0fff ) | 0x4000,

	        // 16 bits, 8 bits for "clk_seq_hi_res",
	        // 8 bits for "clk_seq_low",
	        // two most significant bits holds zero and one for variant DCE1.1
	        mt_rand( 0, 0x3fff ) | 0x8000,

	        // 48 bits for "node"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	    );
	}

	/**
	 * Inserts a row into the item statistics table
	 * @param  string $uuid           The scraper run uuid
	 * @param  string $type           The item type "topics" etc
	 * @param  integer $item_id        The item fetched "topic_id", "url_id" etc
	 * @param  integer $tweets_created The number of tweets inserted
	 * @param  integer $tweets_fetched The number of tweets fetched from twitter
	 * @param  float $microtime      The microtime where the scraping of the item started
	 * @param  integer $item_number    The current item number / ´scraper_runs´.item_count
	 * @param  string $url            The url where the items was fetched from
	 */
	public function insert_statistic ( $uuid, $type, $item_id, $tweets_created, $tweets_fetched, $microtime, $item_number, $url ) {
		$this->db->insert("scrape_statistics", array(
			"type" => $type,
			"item_id" => $item_id,
			"tweets_created" => $tweets_created,
			"tweets_fetched" => $tweets_fetched,
			"created_at" => time(),
			"microtime" => $microtime,
			"item_number" => $item_number,
			"url" => $url,
			"run_uuid" => $uuid
		));
	}

	/**
	 * Inserts a scraper run, used to find all started scrapers,
	 * use the "history" table to find all finished scrapers,
	 * and "scrape_statistics" to find info about the different items in the scraping
	 * @param  string $uuid       The scrape run uuid
	 * @param  string $type       The item type "topics" etc..
	 * @param  float $microtime  The microtime when the scraping started
	 * @param  integer $item_count The number of items to fetch
	 */
	public function insert_scraper_run ( $uuid, $type, $microtime, $item_count ) {
		$this->db->insert("scraper_runs", array(
			"type" => $type,
			"run_uuid" => $uuid,
			"start_microtime" => $microtime,
			"item_count" => $item_count,
			"created_at" => time()
		));
	}

	/**
	 *    Creates a record in the page_stats table for the page scraping
	 *
	 *    @param integer $page_id        The scraped page
	 *    @param integer $tweets_created Number of tweets created
	 *    @param integer $tweets_fetched Number of tweets fetched from twitter
	 *
	 */
	public function insert_page_stats ( $page_id, $tweets_created, $tweets_fetched ) {
		$this->db->insert("page_stats", array(
			"page_id" => $page_id,
			"tweets_created" => $tweets_created,
			"tweets_fetched" => $tweets_fetched,
			"created_at" => time()
		));
	}
}
?>