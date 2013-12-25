<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {

	public function index () {
		$this->lang->load("common");
		$this->lang->load("admin");

		if ( ! isset($_SESSION["signed_in"]) || ( isset($_SESSION["signed_in"]) && $_SESSION["signed_in"] == false ) ) {
			redirect(base_url());
		}
		$this->load->view("admin", $this->user_control->ControllerInfo());
	}
}
?>