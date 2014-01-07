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
		"topics_get" => array("key" => false),
		"users_get" => array("key" => false),
		"urls_get" => array("key" => false)
	);

	/**
	 * Loads the neede dependencies
	 */
	public function __construct () {
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
	 * Scrapes all the requested topics
	 */
	public function topics_get () {
		$table = "topics";
		$scraper = "topics";
		$item_type = "topic";
		$meta_keys = array("tweet_topic_id" => "id");
		$feed_url = "https://twitter.com/search?q={{value}}&src=typd&f=realtime";
		$this->_scrape( $table, $scraper, $item_type, $meta_keys, $feed_url );
	}

	/**
	 * Demernine which page type the URL is, this wlll be used to determine which timeline JSON URL to use
	 * @param  string $url  The URL to test
	 * @param  array $data The data variable where to store request parameters
	 * @return string
	 */
	protected function _determine_page_type ( $url, &$data ) {
		$query_str = parse_url($url, PHP_URL_QUERY);
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
			preg_match("|https?://(www\.)?twitter\.com/(#!/)?@?(?P<name>[^/]*)|", $url, $matches);
			$data["user"] = $matches["name"];
			$page = "profile";
		}

		return $page;
	}

	/**
	 * Scraper function
	 * @param  string $table     The database table to fetch the list from using base_model->get_list
	 * @param  string $scraper   The scraper histor name
	 * @param  string $item_type The item type name
	 * @param  array  $meta_keys Data to add to the scraping functions meta parameter
	 * @param  string $feed_url  The feed url
	 * @param string $value_parameter The row where to find the url or parts of the url
	 */
	private function _scrape ( $table, $scraper, $item_type, $meta_keys = array(), $feed_url, $value_parameter = "value", $beforeRequestCallback = null ) {
		$start_global = microtime(true);

		$uuid = $this->scrape_model->gen_uuid();

		$objects = $this->base_model->get_list($table);

		// Insert global statistics
		$this->scrape_model->insert_scraper_run($uuid, $item_type, $start_global, count($objects));

		$tweets_created = 0;
		$tweets_fetched = 0;
		$tweets_blocked = 0;
		$item_number = 0;

		$blocked_strings = $this->base_model->get_list("blocked_strings");
		$alert_strings = $this->base_model->get_list("alert_strings");

		foreach ( $objects as $object ) {
			$item_start_time = microtime(true);
			$item_number = $item_number+1;

			$url = str_replace("{{" . $value_parameter ."}}", $object->{$value_parameter}, $feed_url);

			$type = $this->_determine_page_type($url, $data);

			if ( is_callable(array($this, $beforeRequestCallback)) ) {
				call_user_func_array(array($this, $beforeRequestCallback), array($object));
			}

			// Fetch the tweets
			try{
				$local_tweets = $this->scraper->scrapeTweets(array_merge($this->_create_meta($meta_keys, $object),array(
					"tweet_source_url" => $url
				)), $new_lastest_cursor, $object->latest_cursor, $type, $data, NULL, false, $this->tweet_model->maxTime() );
			} catch ( Exception $e ) {
				 $this->scrape_model->create_error($e->getMessage(), $url, $uuid, $item_type, $object->id );
			}

			if ( ! isset($local_tweets) || ! is_array($local_tweets) ) {
				$this->scrape_model->create_error("Scraping failed!", $url, $uuid, $item_type, $object->id );
				$this->response(array(
					"status" => false
				), 500);
			}

			$tweets_fetched = $tweets_fetched + count($local_tweets);
			$local_tweets_created = 0;
			$local_tweets_blocked = 0;

			// Loop through the tweets and add them
			foreach ( $local_tweets as $tweet ) {
				$tweet = $this->scrape_model->process_tweet($tweet, $alerts, $alert_strings);

				if ( ! $this->scrape_model->if_to_block_tweet($blocked_strings, $tweet["text"]) ) {

					if ( $this->tweet_model->create_tweet($tweet, $id, $error_type) ) {
						$local_tweets_created = $local_tweets_created + 1;

						// Alert Tweet Created

						if ( is_array($alerts) ) {
							foreach ( $alerts as $alert ) {
								$this->tweet_model->tweet_matched_alert($id, $alert);
							}
						}
					} else {
						if ( count(array_intersect($error_type, array("tweet_exists", "to_old"))) == 0 ) {
							$this->scrape_model->create_error(str_replace("{{tweet_id}}", $tweet["tweet_id"], $this->lang->line("error_inserting_tweet")), $url, $uuid, $item_type, $object->id );
						}
					}
				} else {
					$local_tweets_blocked = $local_tweets_blocked + 1;
				}
			}

			// Inserts local item analytics
			$this->scrape_model->insert_statistic($uuid, $item_type, $object->id, $local_tweets_created , count($local_tweets), $local_tweets_blocked, $item_start_time, $item_number, $url);

			$tweets_created = $tweets_created + $local_tweets_created;
			$tweets_blocked = $tweets_blocked + $local_tweets_blocked;

			// Set latest cursor
			$this->base_model->update_element($table, array("latest_cursor" => $new_lastest_cursor), array("id" => $object->id));
		}

		$microtime = microtime(true);

		// Inserts the row the "sets" the scraping as finished
		$this->scrape_model->create_history_item($tweets_created, $scraper, $tweets_fetched, $tweets_blocked, $uuid, $microtime );
	}

	/**
	 * Attaches the current users username and password to the scraper
	 * @param  object $object The user info db object
	 */
	protected function _attach_security ( $object ) {
		$this->load->model("settings_model");
		$this->scraper->username = $object->username;
		$this->scraper->password = $this->settings_model->decrypt_password($object->password);
	}

	/**
	 * Fetches all the avaiable followers tweets for each user
	 */
	public function users_get () {
		$table = "twitter_users";
		$scraper = "followers";
		$item_type = "follower";
		$meta_keys = array("tweet_source_user_id" => "id");
		$feed_url = "twitter.com";
		$this->_scrape( $table, $scraper, $item_type, $meta_keys, $feed_url, "username", "_attach_security" );
	}

	/**
	 * Fetches all the tweets found at the URLS described in the URLs list table
	 */
	public function urls_get () {
		$table = "urls";
		$scraper = "urls";
		$item_type = "url";
		$meta_keys = array("tweet_source_url_id" => "id");
		$feed_url = "{{value}}";
		$this->_scrape( $table, $scraper, $item_type, $meta_keys, $feed_url );
	}
}