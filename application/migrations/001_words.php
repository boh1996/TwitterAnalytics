<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_Words extends CI_Migration {

	public function up ()  {
		# Words #
		$this->dbforge->add_field(array(
			'id' => array(
				"type" => "INT",
				"constraint" => 11,
				"auto_increment" => TRUE
			),
			'word' => array(
				"type" => "VARCHAR",
				"constraint" => 255
			),
			"created_at" => array(
				"type" => "VARCHAR".
				"constraint" => 45
			)
		));
		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('words', TRUE);

		$this->db->query("ADD UNIQUE INDEX `word_UNIQUE` (`word` ASC) ;");
	}

	public function  down () {
		$this->dbforge->drop_table('words');
	}
}