<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Hisotry extends CI_Migration {

	public function up ()  {
		# Scrape Statistics
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'item_id' => array(
				"type" => "INT",
				"constraint" => 11
			),
			'item_number' => array(
				"type" => "INT",
				"constraint" => 11
			),
			"created_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"run_uuid" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"url" => array(
				"type" => "TEXT",
			),
			"microtime" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			'tweets_fetched' => array(
				"type" => "INT",
				"constraint" => 11
			),
			'tweets_created' => array(
				"type" => "INT",
				"constraint" => 11
			),
			'tweets_blocked' => array(
				"type" => "INT",
				"constraint" => 11
			),
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('scrape_statistics', TRUE);

		# History
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			"created_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"scraper" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"run_uuid" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"end_microtime" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			'tweets_fetched' => array(
				"type" => "INT",
				"constraint" => 11
			),
			'tweets_created' => array(
				"type" => "INT",
				"constraint" => 11
			),
			'tweets_blocked' => array(
				"type" => "INT",
				"constraint" => 11
			),
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('history', TRUE);

		# Sraper runs
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'type' => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"created_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"start_microtime" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"run_uuid" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			'item_count' => array(
				"type" => "INT",
				"constraint" => 11
			),
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('scraper_runs', TRUE);

		# Errors
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'url' => array(
				"type" => "TEXT",
			),
			'error_string' => array(
				"type" => "TEXT",
			),
			"created_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"run_uuid" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"item_type" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			'item_id' => array(
				"type" => "INT",
				"constraint" => 11
			),
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('errors', TRUE);

		# Scrapers
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'language_key' => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"key" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"url" => array(
				"type" => "TEXT",
			)
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('scrapers', TRUE);
	}

	public function  down () {
		$this->dbforge->drop_table('scrape_statistics');
		$this->dbforge->drop_table('history');
		$this->dbforge->drop_table('scraper_runs');
		$this->dbforge->drop_table('errors');
		$this->dbforge->drop_table('scrapers');
	}
}