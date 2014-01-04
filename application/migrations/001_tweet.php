<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Tweet extends CI_Migration {

	public function up ()  {

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