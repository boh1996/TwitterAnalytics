<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Users extends CI_Migration {

	public function up ()  {
		# Users
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'username' => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"password" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"user_token" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"hashing_iterations" => array(
				"type" => "INT",
				"constraint" => 11
			)
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('users', TRUE);

		# API Tokens
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'token' => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"created_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"ip_address" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"is_private_key" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			'user_id' => array(
				"type" => "INT",
				"constraint" => 11,
			)
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('api_tokens', TRUE);

		# Access control
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'page' => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"mode" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			)
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('access_control', TRUE);

		# Settings
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'key' => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"section" => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"created_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"updated_at" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
			"type" => array(
				"type" => "VARCHAR",
				"constraint" => 45
			),
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('settings', TRUE);
	}

	public function  down () {
		$this->dbforge->drop_table('users');
		$this->dbforge->drop_table('api_tokens');
		$this->dbforge->drop_table('access_control');
		$this->dbforge->drop_table('settings');
	}
}