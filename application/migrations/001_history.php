<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Hisotry extends CI_Migration {

	public function up ()  {

	}

	public function  down () {
		$this->dbforge->drop_table('scrape_statistics');
		$this->dbforge->drop_table('history');
		$this->dbforge->drop_table('scraper_runs');
		$this->dbforge->drop_table('errors');
		$this->dbforge->drop_table('scrapers');
	}
}