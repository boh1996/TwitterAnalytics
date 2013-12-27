<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {

	/**
	 * Shows the user analytics view
	 */
	public function index () {
		$this->lang->load("common");

		if ( ! $this->user_control->check_security("user_home") ) {
			redirect(base_url() . "sign_in");
		}

		$data = array(
			"current_section" => "user"
		);

		$this->load->view("user", $this->user_control->ControllerInfo($data));
	}
}
?>