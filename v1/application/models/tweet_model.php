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
	 * @return boolean
	 */
	public function create_tweet ( $tweet, &$id, &$error_types ) {
		$exists = $this->exists("tweets", array("tweet_id" => $tweet["tweet_id"]));
		$accepted_time = ( $tweet["created_at"] > ( time() - $this->maxTime() ) ) ? true : false;
		if ( ! $exists && $accepted_time ) {
			$data = array(
				"tweet" => $tweet["text"],
				"created_at" => $tweet["created_at"],
				"tweet_id" => $tweet["tweet_id"],
				"twitter_user_id" => $tweet["user_id"],
				"username" => $tweet["screen_name"],
				"user_title" => $tweet["display_name"],
				"tweet_source_url" => $tweet["tweet_source_url"],
				"inserted_at" => time()
			);

			if ( isset($tweet["tweet_topic_id"]) ) {
				$data["tweet_topic_id"] = $tweet["tweet_topic_id"];
			} else if ( isset($tweet["tweet_source_url_id"]) ) {
				$data["tweet_source_url_id"] = $tweet["tweet_source_url_id"];
			} else if ( isset($tweet["tweet_source_user_id"]) ) {
				$data["tweet_source_user_id"] = $tweet["tweet_source_user_id"];
			}

			$this->db->insert("tweets", $data);

			$tweet_db_id = $this->db->insert_id();
			$id = $tweet_db_id;

			$this->insert_tweet_data( $tweet, $tweet_db_id );

			return true;
		} else {
			if ( $exists ) {
				$error_types[] = "tweet_exists";
			}
			if ( ! $accepted_time ) {
				$error_types[] = "to_old";
			}
			return false;
		}
	}

	/**
	 *    Inserts the live tweet statistics
	 *
	 *    @param array $tweet       The tweet array
	 *    @param &array $error_types Errors
	 *
	 *    @return boolean
	 */
	public function insert_live_tweet ( $tweet, &$error_types  ) {
		$exists = $this->exists("tweets", array("tweet_id" => $tweet["tweet_id"]));
		$accepted_time = ( $tweet["created_at"] > ( time() - $this->maxTime() ) ) ? true : false;
		if ( ! $exists && $accepted_time ) {
			$data = array(
				"created_at" => $tweet["created_at"],
				"tweet_id" => $tweet["tweet_id"],
			);
			$this->db->insert("live_tweets", $data);

			return true;
		} else {
			if ( $exists ) {
				$error_types[] = "tweet_exists";
			}
			if ( ! $accepted_time ) {
				$error_types[] = "to_old";
			}
			return false;
		}
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
	public function insert_tweet_data ( $tweet, $tweet_db_id ) {
		if ( count($tweet["words"]) ) {
			foreach ( $tweet["words"] as $word ) {
				$this->create_tweet_word($word, $tweet_db_id, $tweet["created_at"]);
			}
		}
	}

	/**
	 * Creates a media row assoc with the created tweet
	 * @param  array $media    The media array
	 * @param  integer $tweet_id The tweet id
	 */
	public function create_media ( $media, $tweet_id ) {
		$this->db->insert("tweet_media", array(
			"created_at" => time(),
			"url" => $media["media_url"],
			"tweet_id" => $tweet_id
		));

		return $this->db->insert_id();
	}

	/**
	 * Creates a url row, that links to the tweet
	 * @param  array $url      The URL data array
	 * @param  integer $tweet_id The parent tweet
	 */
	public function create_url ( $url, $tweet_id ) {
		$this->db->insert("tweet_urls", array(
			"created_at" => time(),
			"tweet_id" => $tweet_id,
			"url" => $url["url"],
			"tco_url" => $url["tco"],
			"text" => $url["text"]
		));

		return $this->db->insert_id();
	}

	/**
	 * Inserts a hashtag link between the text and a tweet id
	 * @param  array $hash_tag The hash-tag data object
	 * @param  integer $tweet_id The parent tweet id
	 */
	public function create_hashtag ( $hash_tag, $tweet_id ) {
		$this->db->insert("tweet_hashtags", array(
			"created_at" => time(),
			"hash_tag" => $hash_tag["hash_tag"],
			"url" => $hash_tag["url"],
			"tweet_id" => $tweet_id
		));

		return $this->db->insert_id();
	}

	/**
	 * Inserts a mention into db, and link it to the parent tweet
	 * @param  array $mention  The mention data object
	 * @param  integer $tweet_id The tweet_id
	 */
	public function create_mention ( $mention, $tweet_id ) {
		$this->db->insert("tweet_mentions", array(
			"created_at" => time(),
			"name" => $mention["screen_name"],
			"tweet_id" => $tweet_id
		));

		return $this->db->insert_id();
	}

	/**
	 * Creates a link between a word and a tweet
	 * @param  string $word     The word array
	 * @param  integer $tweet_id The parent tweet
	 */
	public function create_tweet_word ( $word, $tweet_id, $created_at ) {
		if ( ! isset($GLOBALS["words"]) ) {
			$GLOBALS["words"] = array();
		}

		$word["word"] = strtolower($word["word"]);

		if ( ! isset($GLOBALS["words"][$word["word"]]) ) {
			$word_id = $this->create_word($word["word"],$created_at);
			$GLOBALS["words"][$word["word"]] = $word_id;
		} else {
			$word_id = $GLOBALS["words"][$word["word"]];
		}

		$this->db->insert("tweet_words", array(
			"created_at" => $created_at,
			"tweet_id" => $tweet_id,
			"word_id" => $word_id,
			"position" => $word["position"]
		));

		return $this->db->insert_id();
	}

	/**
	 * Creates a word in thw words database, or returns the word id if the word exists
	 * @param  string $word The word to add
	 * @return integer The word id
	 */
	public function create_word ( $word, $created_at ) {
		$id = $this->get_id("words", array(
			"word" => $word
		));
		if ( $id === false ) {
			$this->db->insert("words", array(
				"word" => strtolower($word),
				"created_at" => $created_at
			));

			return $this->db->insert_id();
		} else {
			return $id;
		}
	}

	/**
	 * Inserts a row into the tweet_alert_strings table
	 * @param  integer $tweet_id        The tweet database id
	 * @param  integer $alert_string_id The alert string database id
	 */
	public function tweet_matched_alert ( $tweet_id, $alert_string_id, $created_at ) {
		$this->db->insert("tweet_alert_strings", array(
			"tweet_id" => $tweet_id,
			"alert_string_id" => $alert_string_id,
			"created_at" =>  $created_at
		));
	}
}
?>