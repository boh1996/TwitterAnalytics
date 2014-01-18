<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Tweet extends CI_Migration {

	public function up ()  {
		# Tweets
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'tweet' => array(
				"type" => "TEXT"
			),
			"created_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"tweet_id" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"twitter_user_id" => array(
				"type" => "INT",
				"constraint" => 11
			),
			"username" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"user_title" => array(
				"type" => "VARCHAR",
				"constraint" => 255,
			),
			"tweet_source" => array(
				"type" => "TEXT"
			),
			"tweet_topic_id" => array(
				"type" => "INT",
				"constraint" => 11
			),
			"tweet_source_url_id" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"tweet_source_user_id" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"inserted_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			)
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('tweets', TRUE);

		# Tweet Media
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'url' => array(
				"type" => "TEXT"
			),
			"created_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"tweet_id" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			)
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('tweet_media', TRUE);

		# Tweet URLS
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'url' => array(
				"type" => "TEXT"
			),
			'tco_url' => array(
				"type" => "TEXT"
			),
			"created_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"tweet_id" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			'text' => array(
				"type" => "TEXT"
			),
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('tweet_urls', TRUE);

		# Tweet Hashtags
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'url' => array(
				"type" => "TEXT"
			),
			'hash_tag' => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"created_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"tweet_id" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			)
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('tweet_hashtags', TRUE);

		# Tweet mentions
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'name' => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"created_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"tweet_id" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			)
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('tweet_mentions', TRUE);

		# Tweet words
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'word_id' => array(
				"type" => "INT",
				"constraint" => 11,
			),
			"created_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"tweet_id" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"position" => array(
				"type" => "INT",
				"constraint" => 11,
			)
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('tweet_words', TRUE);
	}

	public function  down () {
		$this->dbforge->drop_table('tweets');
		$this->dbforge->drop_table('tweet_media');
		$this->dbforge->drop_table('tweet_urls');
		$this->dbforge->drop_table('tweet_hashtags');
		$this->dbforge->drop_table('tweet_mentions');
		$this->dbforge->drop_table('tweet_words');
	}
}