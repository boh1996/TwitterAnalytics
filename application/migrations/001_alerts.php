<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Alerts extends CI_Migration {

	public function up ()  {
		# Alert Strings #
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
			"created_at" => array(
				"type" => "VARCHAR".
				"constraint" => 45
			)
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('alert_strings', TRUE);

		# Tweet Alert Strings #
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'tweet_id' => array(
				"type" => "INT",
				"constraint" => 11
			),
			"alert_string_id" => array(
				"type" => "INT".
				"constraint" => 11
			),
			"created_at" => array(
				"type" => "VARCHAR".
				"constraint" => 45
			)
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('tweet_alert_strings', TRUE);
	}

	public function  down () {
		$this->dbforge->drop_table('alert_strings');
		$this->dbforge->drop_table('tweet_alert_strings');
	}
}