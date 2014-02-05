<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/api/T_API_Controller.php');

/**
 *
 * The Scraper Controller/Endpoint
 *
 * @uses 			API Controller
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Bo Thomsen
 * @version 		1.0
 */
class API_Scraper extends T_API_Controller {

	/**
	 * Methods settings
	 * @var array
	 */
	protected $methods = array(
		"pages_get" => array("key" => false)
	);

	/**
	 * Loads the neede dependencies
	 */
	public function __construct () {
		set_time_limit(999999999999);
		ini_set('max_execution_time', 999999999999);
		parent::__construct();
		$this->load->library("scraper");
		$this->load->library("urls");
		$this->load->model("scrape_model");
		$this->load->model("tweet_model");
	}

	/**
	 * Creates the scraper meta information
	 * @param  array $keys   The meta keys db_key => object_property
	 * @param  object $object The database row, for the scrape info
	 * @return array
	 */
	protected function _create_meta ( $keys, $object ) {
		$meta = array();

		foreach ( $keys as $key => $object_key ) {
			if ( isset($object->{$object_key}) ) {
				$meta[$key] = $object->{$object_key};
			}
		}

		return $meta;
	}

	/**
	 * Demernine which page type the URL is, this wlll be used to determine which timeline JSON URL to use
	 * @param  string $url  The URL to test
	 * @param  array $data The data variable where to store request parameters
	 * @return string
	 */
	protected function _determine_page_type ( $url, &$data ) {
		$url = trim($url);
		$query_str = parse_url($url, PHP_URL_QUERY);
		$page = false;
		parse_str($query_str, $data);
		if ( $url == "twitter.com" ) {
			$page = "timeline";
		} else if ( strpos($url, "search?q=") !== false && strpos($url, "&src=tren") !== false ) {
			$page = "trends";
		} else if ( strpos($url, "i/discover") !== false ) {
			$page = "discover";
		} else  if ( strpos($url, "search?q=") !== false ) {
			$page = "search";
		} else {
			preg_match("|(https)?(://)?(www\.)?twitter\.com/(#!/)?@?(?P<name>[^/]*)|", $url, $matches);
			if ( isset($matches["name"]) ) {
				$data["user"] = $matches["name"];
				$page = "profile";
			}
		}

		return $page;
	}

	/**
	 * Scraper function
	 * @param string $table Database table
	 * @param  string $scraper   The scraper history name
	 * @param  string $item_type The item type name
	 * @param  string $url  The URL object
	 * @param string @$uuid A container for the current run UUID
	 * @param array @info Returned statistic info
	 */
	private function _scrape ( $table, $scraper, $item_type, $url, &$uuid, &$info ) {
		$start_global = microtime(true);

		$uuid = $this->scrape_model->gen_uuid();

		// Insert global statistics
		$this->scrape_model->insert_scraper_run($uuid, $item_type, $start_global, 1);

		$tweets_created = 0;
		$tweets_fetched = 0;
		$item_number = 0;
		$tweets = array();

		$item_start_time = microtime(true);
		$item_number = $item_number+1;

		$type = $this->_determine_page_type($url->url, $data);

		if ( $type == false ) {
			return false;
		}

		// Fetch the tweets
		try{
			$local_tweets = $this->scraper->scrapeTweets(array(), $new_lastest_cursor, $url->latest_cursor, $type, $data, NULL, false, $this->tweet_model->maxTime() );
		} catch ( Exception $e ) {
			 $this->scrape_model->create_error($e->getMessage(), $url, $uuid, $item_type, $url->id );
		}

		if ( ! isset($local_tweets) || ! is_array($local_tweets) ) {
			$this->scrape_model->create_error("Scraping failed!", $url->url, $uuid, $item_type, $url->id );
			$this->response(array(
				"status" => false
			), 500);
		}

		$tweets_fetched = $tweets_fetched + count($local_tweets);
		$local_tweets_created = 0;

		// Loop through the tweets and add them
		foreach ( $local_tweets as $tweet ) {
			if ( ! $this->tweet_model->create_tweet($tweet, $id, $error_type) ) {
				if ( count(array_intersect($error_type, array("tweet_exists", "to_old"))) == 0 ) {
					$this->scrape_model->create_error(str_replace("{{tweet_id}}", $tweet["tweet_id"], $this->lang->line("error_inserting_tweet")), $url, $uuid, $item_type, $url->id );
				}
			} else {
				$tweet["id"] = $id;
				$tweet["source_url"] = $url->url;
				$tweets[] = $tweet;
			}
		}

		// Inserts local item analytics
		$this->scrape_model->insert_statistic($uuid, $item_type, $url->id, $local_tweets_created , count($local_tweets), $item_start_time, $item_number, $url->url);

		$tweets_created = $tweets_created + $local_tweets_created;

		// Set latest cursor
		if ( ! empty($new_lastest_cursor) ) {
			$this->base_model->update_element($table, array("latest_cursor" => $new_lastest_cursor), array("id" => $url->id));
		}

		$microtime = microtime(true);

		// Inserts the row the "sets" the scraping as finished
		$this->scrape_model->create_history_item($tweets_created, $scraper, $tweets_fetched, $uuid, $microtime );

		$info = array(
			"scraper" => $scraper,
			"tweets_fetched" => $tweets_fetched,
			"microtime" => $microtime,
			"tweets_created" => $tweets_created,
			"item_start_time" => $item_start_time
		);

		return $tweets;
	}

	public function pages_get () {
		$scraper = "pages";
		$item_type = "url";
		$urls = $this->base_model->get_list("statistic_urls");

		if ( $urls === false ) return false;

		$this->load->model("words_model");

		$strings = $this->words_model->get_strings_grouped_in_pages();

		$pages = array();

		foreach ( $urls as $url ) {
			if ( $url->url != "" ) {
				if ( ! isset($pages[$url->statistic_page_id]) ) {
					$pages[$url->statistic_page_id] = array("urls" => array(), "tweets_created" => 0, "tweets_fetched" => 0);
				}

				$pages[$url->statistic_page_id]["urls"][] = $url->url;

				$local_tweets = $this->_scrape( "statistic_urls", $scraper, $item_type, $url, $uuid, $info );

				if ( $local_tweets !== false ) {
					$pages[$url->statistic_page_id]["tweets_fetched"] = $pages[$url->statistic_page_id]["tweets_fetched"] + $info["tweets_fetched"];
					$pages[$url->statistic_page_id]["tweets_created"] + $pages[$url->statistic_page_id]["tweets_created"] + $info["tweets_created"];

					foreach ( $local_tweets as $tweet ) {
						$this->tweet_model->search_for_strings($tweet, $strings[$url->statistic_page_id]->strings);
						$this->tweet_model->link_page_and_tweet($tweet["tweet_id"], $url->statistic_page_id);

					}
				}
			}
		}

		// Insert page stats
		foreach ( $pages as $page_id => $info ) {
			$this->scrape_model->insert_page_stats($page_id, $info["tweets_created"], $info["tweets_fetched"]);
		}
	}
}