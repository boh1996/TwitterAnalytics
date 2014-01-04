<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Scraper extends CI_Migration {

	public function up ()  {
		$this->dbforge->create_table('blocked_strings');
		$this->dbforge->create_table('removed_strings');
		$this->dbforge->create_table('urls');
		$this->dbforge->create_table('topics');
	}

	public function  down () {
		$this->dbforge->drop_table('blocked_strings');
		$this->dbforge->drop_table('removed_strings');
		$this->dbforge->drop_table('urls');
		$this->dbforge->drop_table('topics');
	}
}