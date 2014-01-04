<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {

	public function index () {
		$this->load->dbforge();

		$this->dbforge->create_database('twitter_analytics')
	}
}
?>