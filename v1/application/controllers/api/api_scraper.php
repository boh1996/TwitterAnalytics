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
		"urls_get" => array("key" => false),
		"live_get" => array("key" => false)
	);

	/**
	 * Loads the neede dependencies
	 */
	public function __construct () {
		set_time_limit(0);
		ini_set('max_execution_time', 0);
		parent::__construct();
		$this->load->library("scraper");
		$this->load->library("live_scraper");
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
		try {
			$this->_scrape( $table, $scraper, $item_type, $meta_keys, $feed_url, "value", null, $scraper );
		} catch ( Exception $e ) {
			 $this->scrape_model->create_error($e->getMessage(), $url, $uuid, $item_type, 0 );
		}
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
			$url = preg_replace("/\&src=(.*)/", '', $url);
			$url = preg_replace("/\&f=(.*)/", '', $url);
			preg_match("|(https)?(://)?(www\.)?twitter\.com/search\?q=(?P<query>.*)|", $url, $matches);
			if ( isset($matches["query"]) ) {
				$data["q"] = $matches["query"];
			}
		} else {
			preg_match("|(https)?(://)?(www\.)?twitter\.com/(#!/)?@?(?P<name>[^/]*)|", $url, $matches);
			if ( isset($matches["name"]) ) {
				$data["user"] = $matches["name"];
				$page = "profile";
			}
		}

		return $page;
	}

	private function _scrape_live () {
		$tweets_created = 0;
		$tweets_fetched = 0;
		$tweets_blocked = 0;
		$table = "urls";
		$scraper = "live";
		$item_type = "live";;

		$uuid = $this->scrape_model->gen_uuid();

		if ( $this->get("uuid") !== false ) {
			$uuid = $this->get("uuid");
		}

		if ( $this->get("launch") == "true" ) {

			$start_global = microtime(true);

			$where = array("category" => "live");

			$objects = $this->base_model->get_list($table, $where);

			if ( ! is_array($objects) ) {
				$objects = array();
			}

			// Insert global statistics
			$this->scrape_model->insert_scraper_run($uuid, "live", $start_global, count($objects));
			$this->scrape_model->insert_statistic($uuid, "live", 0, 0 , 0, 0, $start_global, 0, $scraper);

			$number_per_run = 50;

			$amount = ceil(count($objects) / $number_per_run);

			for ( $i = 0; $i < $amount ; $i++) {
				$scraper_url = rtrim($this->config->item("base_url"), "/") . "/scrape/live?category=live";

				$scraper_url = $scraper_url . "?limit=" . $number_per_run . "&offset=" . $i * $number_per_run ."&uuid=" . $uuid;

				try {
					$s = curl_init($scraper_url);
					curl_setopt($s,CURLOPT_URL, $scraper_url);
					curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
					curl_setopt($s, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($s, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($s, CURLOPT_VERBOSE, 1);
					curl_setopt($s, CURLOPT_SSLVERSION, 3);

					$raw = curl_exec($s);

					$status = curl_getinfo($s,CURLINFO_HTTP_CODE);

					$response = json_decode($raw);

					if ( curl_errno($s) ) {
						$error_string = curl_error($s) . ":" . curl_errno($s) . ":" . $status;
						$this->scrape_model->create_error($error_string, $scraper_url, $uuid, $item_type, 0 );
					}

					curl_close($s);
				} catch ( Exception $e ) {
					$this->scrape_model->create_error($e->getMessage(), $scraper_url, $uuid, $item_type, 0 );
				}

				if ( $raw == "" ) {
					$this->scrape_model->create_error("Empty response, timeout occured!", $scraper_url, $uuid, $item_type, 0 );
				} else if ( is_object($response) && isset($response->result) ) {
					try{
						$response = $response->result;

						$tweets_created = $tweets_created + $response->tweets_created;
						$tweets_fetched = $tweets_fetched + $response->tweets_fetched;
						$tweets_blocked = $tweets_blocked + $response->tweets_blocked;
					} catch ( Exception $e ) {
						 $this->scrape_model->create_error($e->getMessage(), $url, $uuid, $item_type, 0 );
					}
				} else {
					$this->scrape_model->create_error("Scraping error:" . $raw, $scraper_url, $uuid, $item_type, 0 );
				}
			}

			$microtime = microtime(true);

			// Inserts the row the "sets" the scraping as finished
			$this->scrape_model->create_history_item($tweets_created, $scraper, $tweets_fetched, $tweets_blocked, $uuid, $microtime );
		} else if ( $this->get("limit") ) {
			$where = array("category" => "live");

			$objects = $this->base_model->get_list($table, $where, $this->get("limit"), $this->get("offset"));

			if ( ! is_array($objects) ) {
				$objects = array();
			}

			$item_number = $this->get("offset");

			$feed_url = urldecode($feed_url);

			if ( is_array($objects) ) {
				foreach ( $objects as $object ) {
					if ( is_object($object) ) {

						$item_start_time = microtime(true);
						$item_number = $item_number+1;

						try {
							$url = $object->value;
						} catch ( Exception $e ) {
							if ( is_object($object) ) {
								$this->scrape_model->create_error($e->getMessage(), $scraper, $uuid, $item_type, $object->id );
							} else {
								$this->scrape_model->create_error($e->getMessage(), $scraper, $uuid, $item_type, 0 );
							}
						}

						$type = $this->_determine_page_type($url, $data);

						if ( is_callable(array($this, $beforeRequestCallback)) ) {
							call_user_func_array(array($this, $beforeRequestCallback), array($object));
						}

						// Fetch the tweets
						try{
							$local_tweets = $this->live_scraper->scrapeTweets(array(), $new_lastest_cursor, $object->latest_cursor, $type, $data, NULL, false, $this->tweet_model->maxTime() );
						} catch ( Exception $e ) {
							 $this->scrape_model->create_error($e->getMessage(), $url, $uuid, $item_type, $object->id );
						}

						if ( ! isset($local_tweets) || ! is_array($local_tweets) ) {
							$this->scrape_model->create_error("Scraping failed! No tweets found!", $url, $uuid, $item_type, $object->id );
							$this->scrape_model->insert_statistic($uuid, $item_type, $object->id, 0 , 0, 0, $item_start_time, $item_number, $url);
							$this->response(array(
								"status" => false
							), 500);
						}

						$tweets_fetched = $tweets_fetched + count($local_tweets);
						$local_tweets_created = 0;
						$local_tweets_blocked = 0;

						try{
							// Loop through the tweets and add them
							foreach ( $local_tweets as $tweet ) {
								if ( $this->tweet_model->insert_live_tweet($tweet, $error_type) ) {
									$local_tweets_created = $local_tweets_created + 1;
								} else {
									if ( count(array_intersect($error_type, array("tweet_exists", "to_old"))) == 0 ) {
										$this->scrape_model->create_error(str_replace("{{tweet_id}}", $tweet["tweet_id"], $this->lang->line("error_inserting_tweet")), $url, $uuid, $item_type, $object->id );
									}
								}
							}
						} catch ( Exception $e ) {
							if ( is_object($object) ) {
								$this->scrape_model->create_error($e->getMessage(), $url, $uuid, $item_type, $object->id );
							} else {
								$this->scrape_model->create_error($e->getMessage(), $url, $uuid, $item_type, 0 );
							}
						}

						// Inserts local item analytics
						$this->scrape_model->insert_statistic($uuid, $item_type, $object->id, $local_tweets_created , count($local_tweets), $local_tweets_blocked, $item_start_time, $item_number, $url);

						$tweets_created = $tweets_created + $local_tweets_created;
						$tweets_blocked = $tweets_blocked + $local_tweets_blocked;

						// Set latest cursor
						if ( ! empty($new_lastest_cursor) ) {
							$this->base_model->update_element($table, array("latest_cursor" => $new_lastest_cursor), array("id" => $object->id));
						}
					} else {
						if ( is_object($object) ) {
							$this->scrape_model->create_error("Data object is not an object!", $url, $uuid, $item_type, $object->id );
						} else {
							$this->scrape_model->create_error("Data object is not an object!", $url, $uuid, $item_type, 0 );
						}
					}
				}
			}

			$this->response(array(
				"tweets_created" => $tweets_created,
				"tweets_fetched" => $tweets_fetched,
				"tweets_blocked" => $tweets_blocked
			), 200);
		} else {
			$this->scrape_model->create_error("Unkown scrape command!", $scraper, $uuid, $item_type, 0 );
			$this->scrape_model->create_history_item(0, $scraper, 0, 0, $uuid, microtime(true) );
		}
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
	private function _scrape ( $table, $scraper, $item_type, $meta_keys = array(), $feed_url, $value_parameter = "value", $beforeRequestCallback = null, $type ) {

		$tweets_created = 0;
		$tweets_fetched = 0;
		$tweets_blocked = 0;

		$uuid = $this->scrape_model->gen_uuid();

		if ( $this->get("uuid") !== false ) {
			$uuid = $this->get("uuid");
		}

		if ( $this->get("launch") == "true" ) {

			$start_global = microtime(true);

			$where = null;

			if ( $this->get("category") ) {
				$where = array("category" => $this->get("category"));
			}

			$objects = $this->base_model->get_list($table, $where);

			if ( ! is_array($objects) ) {
				$objects = array();
			}

			// Insert global statistics
			$this->scrape_model->insert_scraper_run($uuid, $item_type, $start_global, count($objects));
			$this->scrape_model->insert_statistic($uuid, $item_type, 0, 0 , 0, 0, $start_global, 0, $scraper);

			$number_per_run = 50;

			$amount = ceil(count($objects) / $number_per_run);

			for ( $i = 0; $i < $amount ; $i++) {
				$scraper_url = rtrim($this->config->item("base_url"), "/") . "/";

				switch ( $type ) {
					case 'followers':
						$scraper_url = $scraper_url . "scrape/users";
						break;

					case 'urls':
						$scraper_url = $scraper_url . "scrape/urls" . "/" . $this->get("category");
						break;

					case 'topics':
						$scraper_url = $scraper_url . "scrape/topics";
						break;
				}

				$scraper_url = $scraper_url . "?limit=" . $number_per_run . "&offset=" . $i * $number_per_run ."&uuid=" . $uuid;

				try {
					$s = curl_init($scraper_url);
					curl_setopt($s,CURLOPT_URL, $scraper_url);
					curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
					curl_setopt($s, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($s, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($s, CURLOPT_VERBOSE, 1);
					curl_setopt($s, CURLOPT_SSLVERSION, 3);

					$raw = curl_exec($s);

					$status = curl_getinfo($s,CURLINFO_HTTP_CODE);

					$response = json_decode($raw);

					if ( curl_errno($s) ) {
						$error_string = curl_error($s) . ":" . curl_errno($s) . ":" . $status;
						$this->scrape_model->create_error($error_string, $scraper_url, $uuid, $item_type, 0 );
					}

					curl_close($s);
				} catch ( Exception $e ) {
					$this->scrape_model->create_error($e->getMessage(), $scraper_url, $uuid, $item_type, 0 );
				}

				if ( $raw == "" ) {
					$this->scrape_model->create_error("Empty response, timeout occured!", $scraper_url, $uuid, $item_type, 0 );
				} else if ( is_object($response) && isset($response->result) ) {
					try{
						$response = $response->result;

						$tweets_created = $tweets_created + $response->tweets_created;
						$tweets_fetched = $tweets_fetched + $response->tweets_fetched;
						$tweets_blocked = $tweets_blocked + $response->tweets_blocked;
					} catch ( Exception $e ) {
						 $this->scrape_model->create_error($e->getMessage(), $url, $uuid, $item_type, 0 );
					}
				} else {
					$this->scrape_model->create_error("Scraping error:" . $raw, $scraper_url, $uuid, $item_type, 0 );
				}
			}

			$microtime = microtime(true);

			// Inserts the row the "sets" the scraping as finished
			$this->scrape_model->create_history_item($tweets_created, $scraper, $tweets_fetched, $tweets_blocked, $uuid, $microtime );
		} else if ( $this->get("limit") ) {
			$where = null;

			if ( $this->get("category") ) {
				$where = array("category" => $this->get("category"));
			}

			$objects = $this->base_model->get_list($table, $where, $this->get("limit"), $this->get("offset"));

			if ( ! is_array($objects) ) {
				$objects = array();
			}

			$item_number = $this->get("offset");

			$blocked_strings = $this->base_model->get_list("blocked_strings");
			$alert_strings = $this->base_model->get_list("alert_strings");

			$feed_url = urldecode($feed_url);

			$alerts = array();

			if ( is_array($objects) ) {
				foreach ( $objects as $object ) {
					if ( is_object($object) ) {

						$item_start_time = microtime(true);
						$item_number = $item_number+1;

						try {
							$url = str_replace("{{" . $value_parameter ."}}", $object->{$value_parameter}, $feed_url);
						} catch ( Exception $e ) {
							if ( is_object($object) ) {
								$this->scrape_model->create_error($e->getMessage(), $scraper, $uuid, $item_type, $object->id );
							} else {
								$this->scrape_model->create_error($e->getMessage(), $scraper, $uuid, $item_type, 0 );
							}
						}

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
							$this->scrape_model->create_error("Scraping failed! No tweets found!", $url, $uuid, $item_type, $object->id );
							$this->scrape_model->insert_statistic($uuid, $item_type, $object->id, 0 , 0, 0, $item_start_time, $item_number, $url);
							$this->response(array(
								"status" => false
							), 500);
						}

						$tweets_fetched = $tweets_fetched + count($local_tweets);
						$local_tweets_created = 0;
						$local_tweets_blocked = 0;

						try{
							// Loop through the tweets and add them
							foreach ( $local_tweets as $tweet ) {
								$alerts = array();
								$tweet = $this->scrape_model->process_tweet($tweet, $alerts, $alert_strings);

								if ( ! $this->scrape_model->if_to_block_tweet($blocked_strings, $tweet["text"]) ) {

									if ( $this->tweet_model->create_tweet($tweet, $id, $error_type) ) {
										$local_tweets_created = $local_tweets_created + 1;

										// Alert Tweet Created

										if ( is_array($alerts) ) {
											foreach ( $alerts as $alert ) {
												$this->tweet_model->tweet_matched_alert($id, $alert, $tweet["created_at"]);
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
						} catch ( Exception $e ) {
							if ( is_object($object) ) {
								$this->scrape_model->create_error($e->getMessage(), $url, $uuid, $item_type, $object->id );
							} else {
								$this->scrape_model->create_error($e->getMessage(), $url, $uuid, $item_type, 0 );
							}
						}

						// Inserts local item analytics
						$this->scrape_model->insert_statistic($uuid, $item_type, $object->id, $local_tweets_created , count($local_tweets), $local_tweets_blocked, $item_start_time, $item_number, $url);

						$tweets_created = $tweets_created + $local_tweets_created;
						$tweets_blocked = $tweets_blocked + $local_tweets_blocked;

						// Set latest cursor
						if ( ! empty($new_lastest_cursor) ) {
							$this->base_model->update_element($table, array("latest_cursor" => $new_lastest_cursor), array("id" => $object->id));
						}
					} else {
						if ( is_object($object) ) {
							$this->scrape_model->create_error("Data object is not an object!", $url, $uuid, $item_type, $object->id );
						} else {
							$this->scrape_model->create_error("Data object is not an object!", $url, $uuid, $item_type, 0 );
						}
					}
				}
			}

			$this->response(array(
				"tweets_created" => $tweets_created,
				"tweets_fetched" => $tweets_fetched,
				"tweets_blocked" => $tweets_blocked
			), 200);
		} else {
			$this->scrape_model->create_error("Unkown scrape command!", $scraper, $uuid, $item_type, 0 );
			$this->scrape_model->create_history_item(0, $scraper, 0, 0, $uuid, microtime(true) );
		}
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

	public function live_get () {
		$this->_scrape_live();
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
		try {
			$this->_scrape( $table, $scraper, $item_type, $meta_keys, $feed_url, "username", "_attach_security", $scraper );
		} catch ( Exception $e ) {
			 $this->scrape_model->create_error($e->getMessage(), $url, $uuid, $item_type, 0 );
		}
	}

	/**
	 * Fetches all the tweets found at the URLS described in the URLs list table
	 */
	public function urls_get () {
		$table = "urls";
		$scraper = "urls_" . $this->get("category");
		$item_type = "url_" . $this->get("category");
		$meta_keys = array("tweet_source_url_id" => "id");
		$feed_url = "{{value}}";
		try {
			$this->_scrape( $table, $scraper, $item_type, $meta_keys, $feed_url, "value", null, "urls" );
		} catch ( Exception $e ) {
			 $this->scrape_model->create_error($e->getMessage(), $url, $uuid, $item_type, 0 );
		}
	}
}