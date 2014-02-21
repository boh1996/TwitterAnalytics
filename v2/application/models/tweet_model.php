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
class Tweet_model extends Base_model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 * Creates a new item in the database, representing the tweet
	 * @param  array $tweet The tweet data array
	 * @param integer &$id The created database id
	 * @param array &$error_types error_type
	 * @param integer $page_id The current page id
	 * @return boolean
	 */
	public function create_tweet ( $tweet, &$id, &$error_types, $page_id ) {
		$exists = $this->exists("statistic_tweets", array("tweet_id" => $tweet["tweet_id"], "page_id" => $page_id));
		if ( ! $exists ) {
			$data = array(
				"created_at" => $tweet["created_at"],
				"tweet_id" => $tweet["tweet_id"],
				"username" => $tweet["screen_name"],
				"user_title" => $tweet["display_name"],
				"inserted_at" => time(),
				"page_id" => $page_id
			);

			$this->db->insert("statistic_tweets", $data);

			$tweet_db_id = $this->db->insert_id();
			$id = $tweet_db_id;

			$this->insert_tweet_data( $tweet, $tweet_db_id );

			return true;
		} else {
			if ( $exists ) {
				$error_types[] = "tweet_exists";
			}
			return false;
		}
	}

	/**
	 *    Inserts a link between a string and a tweet
	 *
	 *    @param integer $tweet_id  The tweet database id
	 *    @param integer $string_id The string database id
	 *
	 */
	public function insert_tweet_string ( $tweet_id, $string_id ) {
		$this->db->insert("statistic_tweet_strings", array(
			"created_at" => time(),
			"updated_at" => time(),
			"tweet_id" => $tweet_id,
			"statistic_tweet_string_id" => $string_id
		));
	}

	/**
	 *    Links a row, to a page
	 *
	 *    @param integer $tweet_id The Twitter Tweet id
	 *    @param integer $page_id  The page id
	 *
	 */
	public function link_page_and_tweet ( $tweet_id, $page_id ) {
		$row = $this->select("statistic_tweets", array(
			"tweet_id" => $tweet_id
		));

		if ( $row === false ) return false;

		$this->db->insert("page_tweets", array(
			"tweet_id" => $row->id,
			"page_id" => $page_id
		));
	}

	/**
     * The oldest tweets to store
     * @return integer
     */
	public function maxTime () {
		$this->load->model("settings_model");
		$data = $this->settings_model->check_defaults("scraper",$this->settings_model->get_settings("scraper"));
		return $data["setting_max_lifetime"]->value;
    }


	/**
	 * Inserts all the data and links it to the tweet
	 * @param  array $tweet       The tweet data
	 * @param  integer $tweet_db_id The tweet database id
	 */
	public function insert_tweet_data ( $tweet, $tweet_db_id ) {}

	/**
	 *    Retrieves exact match data
	 *
	 *    @param integer $page_id The page to retrieve settings for
	 *
	 *    @return boolean
	 */
	public function get_exact_match ( $page_id ) {
		$query = $this->db->where(array(
			"id" => $page_id
		))->get("statistic_pages");

		if ( ! $query->num_rows() ) return false;

		$row = $query->row();

		return $row->exact_match;
	}

	/**
	 *    Loops through the list of strings, and inserts a link,
	 *    if one of them are found in the tweet
	 *
	 *    @param array $tweet   The tweet data array
	 *    @param array $strings An array of strings in the format array([0] => value, [1] => id)
	 *    @param integer $page_id The page that the tweet is added to
	 *
	 */
	public function search_for_strings ( $tweet, $strings, $page_id ) {
		$regex_charset = "\w@+\\/#%\~_$";

		foreach ( $strings as $string ) {
			$value = strtolower($string[0]);
			$id = $string[1];
			$category = $string[2];
			$exact_match =  $this->get_exact_match($page_id);

			if ( $exact_match == "1" ) {
				$exact_match = true;
			} else if ( $exact_match == "0" ) {
				$exact_match = false;
			} else if ( $exact_match == "" ) {
				$exact_match = false;
			} else if ( $exact_match == "true" ) {
				$exact_match = true;
			} else if ( $exact_match == "false" ) {
				$exact_match = false;
			}

			$text = strtolower($tweet["text"]);

			if ( $exact_match ) {
				if ( preg_match_all("/(?<![" . $regex_charset . "])" .  $value . "(?![" . $regex_charset . "])/",$text, $matches) > 0 ) {
					for ( $i = 0;  $i <= count($matches[0]) - 1 ;  $i++) {
						$this->insert_tweet_string($tweet["id"], $id);
					}
				}
			} else {
				if ( preg_match_all("/" . $value . "/" ,$text, $matches) > 0 ) {
					for ( $i = 0;  $i <= count($matches[0]) - 1 ;  $i++) {
						$this->insert_tweet_string($tweet["id"], $id);
					}
				}
			}
		}
	}
}
?>