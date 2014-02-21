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
	 * @param integer $tweets_blocked The number of tweets blocked
	 * @param string $uuid The run uuid
	 * @param string $end_microtime The micro timestamp when the scraping ended
	 */
	public function create_history_item ( $tweets_created, $scraper, $tweets_fetched, $tweets_blocked, $uuid, $end_microtime ) {
		$this->db->insert("history", array(
			"created_at" => time(),
			"tweets_created" => $tweets_created,
			"tweets_blocked" => $tweets_blocked,
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
	 * @param integer $tweets_blocked The number of tweets blocked
	 * @param  float $microtime      The microtime where the scraping of the item started
	 * @param  integer $item_number    The current item number / ´scraper_runs´.item_count
	 * @param  string $url            The url where the items was fetched from
	 */
	public function insert_statistic ( $uuid, $type, $item_id, $tweets_created, $tweets_fetched, $tweets_blocked, $microtime, $item_number, $url ) {
		$this->db->insert("scrape_statistics", array(
			"type" => $type,
			"item_id" => $item_id,
			"tweets_created" => $tweets_created,
			"tweets_fetched" => $tweets_fetched,
			"tweets_blocked" => $tweets_blocked,
			"created_at" => time(),
			"microtime" => $microtime,
			"item_number" => $item_number,
			"url" => $url,
			"run_uuid" => $uuid
		));
	}

	/**
	 * Returns the extra word characters
	 * @return string
	 */
	public function word_charlist () {
		$this->load->model("settings_model");
		$data = $this->settings_model->check_defaults("scraper",$this->settings_model->get_settings("scraper"));
		return $data["settings_word_charset"]->value;
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
	 * Loops through the list of unwanted strings an remove them
	 * @param  string $text The tweet text
	 * @return string
	 */
	public function remove_unwanted_strings ( $text ) {
		$strings = $this->get_list("removed_strings");

		if ( $strings !== false && is_array($strings) ) {

			foreach ( $strings as $string ) {
				$text = str_replace($string->value, "", $text);
			}

		}

		return $text;
	}

	/**
	 * If a tweet contains, one of the alert strings
	 * @param  string $text          The tweet text
	 * @param  array $alert_strings Array of the alert string rows
	 * @return boolean|array                If array, create an alert
	 */
	public function if_to_alert ( $text, $alert_strings ) {
		$regex_charset = "\w@+\\/#%\~_$";

		$this->load->model("settings_model");
		$exact_match = $this->settings_model->fetch_setting("setting_alert_exact_match", true, "alerts");

		if ( $exact_match == "1" ) {
			$exact_match = true;
		} else if ( $exact_match == "0" ) {
			$exact_match = false;
		} else if ( $exact_match == "" ) {
			$exact_match = false;
		}

		$alerts = array();

		$text = strtolower($text);

		if ( ! is_array($alert_strings) ) {
			return false;
		}

		foreach ( $alert_strings as $string ) {
			$value = strtolower($string->value);
			if ( $exact_match == true ) {
				//if ( preg_match_all("~\b" . $value . "\b~",$text, $matches) > 0 ) {
				if ( preg_match_all("/(?<![" . $regex_charset . "])" .  $value . "(?![" . $regex_charset . "])/",$text, $matches) > 0 ) {
					for ( $i = 0;  $i <= count($matches[0]) - 1 ;  $i++) {
						$alerts[] = $string->id;
					}
				}
			} else {
				if ( preg_match_all('/' . $value . '/' ,$text, $matches) > 0 ) {
					for ( $i = 0;  $i <= count($matches[0]) - 1 ;  $i++) {
						$alerts[] = $string->id;
					}
				}
			}
		}

		if ( count($alerts) > 0 ) {
			return $alerts;
		}

		return false;
	}

	/**
	 *    Matches words using regular expression
	 *
	 *    @param string $text Tweet text
	 *
	 *    @return array
	 */
	public function match_words_regex ( $text ) {
		$words = array();
		if ( preg_match_all("/(\w+)/",strtolower($text), $matches) > 0 ) {
			for ( $i = 0;  $i <= count($matches[0]) - 1 ;  $i++) {
				$words[] = $matches[0][$i];
			}
		}

		return $words;
	}

	/**
	 * Remoevs URLs from the strings and process the tweet to find the tweet word
	 * @param  array $tweet The tweet data array
	 * @param array &$alert Special alert data
	 * @param array $alert_strings The strings to alert for
	 * @return array
	 */
	public function process_tweet ( $tweet, &$alert, $alert_strings ) {
		$processing = strtolower($this->remove_unwanted_strings($tweet["text"]));

		$words_list = str_word_count(preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $processing), 1 , $this->word_charlist() );
		$words = array();

		$alert_data = $this->if_to_alert($processing, $alert_strings);

		if ( is_array($alert_data) ) {
			$alert = $alert_data;
		}

		foreach ( $words_list as $position => $word ) {
			$words[] = array(
				"position" => $position,
				"word" => $word
			);
		}

		$tweet["words"] = $words;

		return $tweet;
	}

	/**
	 * If the string has to be blocked for insertion
	 * @param  array $blocked_strings The array containing the not wanted strings
	 * @param  string $text            The tweet text
	 * @return boolean                  If true, block the tweet
	 */
	public function if_to_block_tweet ( $blocked_strings, $text ) {
		if ( is_array($blocked_strings) ) {
			foreach ( $blocked_strings as $string ) {
				if ( strpos($text, $string->value) !== false ) {
					return true;
				}
			}
		}

		return false;
	}
}
?>