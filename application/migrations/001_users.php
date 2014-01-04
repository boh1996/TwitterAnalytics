<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Users extends CI_Migration {

	public function up ()  {
		# Twitter Users #
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
				"type" => "VARCHAR".
				"constraint" => 255
			),
			"created_at" => array(
				"type" => "VARCHAR".
				"constraint" => 45
			)
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('twitter_users', TRUE);
	}

	public function  down () {
		$this->dbforge->drop_table('twitter_users');
		$this->dbforge->drop_table('users');
		$this->dbforge->drop_table('api_tokens');
		$this->dbforge->drop_table('access_control');
	}
}