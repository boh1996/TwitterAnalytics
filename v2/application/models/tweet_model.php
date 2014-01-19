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
		if ( ! $exists && $accepted_time ) {
			$data = array(
				"created_at" => $tweet["created_at"],
				"tweet_id" => $tweet["tweet_id"],
				"username" => $tweet["screen_name"],
				"user_title" => $tweet["display_name"],
				"tweet_source_url" => $tweet["tweet_source_url"],
				"inserted_at" => time()
			);

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
	 * Inserts all the data and links it to the tweet
	 * @param  array $tweet       The tweet data
	 * @param  integer $tweet_db_id The tweet database id
	 */
	public function insert_tweet_data ( $tweet, $tweet_db_id ) {
		if ( count($tweet["words"]) ) {
			foreach ( $tweet["words"] as $word ) {
				$this->create_tweet_word($word, $tweet_db_id);
			}
		}
	}

	/**
	 * Creates a link between a word and a tweet
	 * @param  string $word     The word array
	 * @param  integer $tweet_id The parent tweet
	 */
	public function create_tweet_word ( $word, $tweet_id ) {
		if ( ! isset($GLOBALS["words"]) ) {
			$GLOBALS["words"] = array();
		}

		$word["word"] = strtolower($word["word"]);

		if ( ! isset($GLOBALS["words"][$word["word"]]) ) {
			$word_id = $this->create_word($word["word"]);
			$GLOBALS["words"][$word["word"]] = $word_id;
		} else {
			$word_id = $GLOBALS["words"][$word["word"]];
		}

		$this->db->insert("tweet_words", array(
			"created_at" => time(),
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
	public function create_word ( $word ) {
		$id = $this->get_id("words", array(
			"word" => $word
		));
		if ( $id === false ) {
			$this->db->insert("words", array(
				"word" => strtolower($word),
				"created_at" => time()
			));

			return $this->db->insert_id();
		} else {
			return $id;
		}
	}
}
?>