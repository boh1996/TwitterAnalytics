<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {

	public function index () {
		$this->lang->load("common");

		if ( isset($_SESSION["signed_in"]) && $_SESSION["signed_in"] == true ) {
			$data["signed_in"] = true;
		} else {
			$data["signed_in"] = false;
		}
		$this->load->view("user", $this->user_control->ControllerInfo($data));
	}
}
?>