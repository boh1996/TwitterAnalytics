<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Scraper extends CI_Migration {

	public function up ()  {
		# Blocked Strings
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'value' => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"created_at" => array(
				"type" => "VARCHAR".
				"constraint" => 45
			),
			"updated_at" => array(
				"type" => "VARCHAR".
				"constraint" => 45
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('blocked_strings');

		# Removed strings
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'value' => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"created_at" => array(
				"type" => "VARCHAR".
				"constraint" => 45
			),
			"updated_at" => array(
				"type" => "VARCHAR".
				"constraint" => 45
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('removed_strings');

		# URLS
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'value' => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"created_at" => array(
				"type" => "VARCHAR".
				"constraint" => 45
			),
			"updated_at" => array(
				"type" => "VARCHAR".
				"constraint" => 45
			),
			"latest_cursor" => array(
				"type" => "VARCHAR".
				"constraint" => 255
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('urls');

		# Topics
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'value' => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"created_at" => array(
				"type" => "VARCHAR".
				"constraint" => 45
			),
			"updated_at" => array(
				"type" => "VARCHAR".
				"constraint" => 45
			),
			"latest_cursor" => array(
				"type" => "VARCHAR".
				"constraint" => 255
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('topics');
	}

	public function  down () {
		$this->dbforge->drop_table('blocked_strings');
		$this->dbforge->drop_table('removed_strings');
		$this->dbforge->drop_table('urls');
		$this->dbforge->drop_table('topics');
	}
}