<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {

	/**
	 * Shows the admin settings planel
	 * @return [type] [description]
	 */
	public function index () {
		$this->lang->load("common");
		$this->lang->load("admin");

		if ( ! isset($_SESSION["signed_in"]) || ( isset($_SESSION["signed_in"]) && $_SESSION["signed_in"] == false ) ) {
			redirect(base_url());
		}

		$this->load->view("admin", $this->user_control->ControllerInfo());
	}

	/**
	 * Shows the settings page for the alert words
	 */
	public function alerts_view () {
		$this->lang->load("common");
		$this->lang->load("admin");

		if ( ! isset($_SESSION["signed_in"]) || ( isset($_SESSION["signed_in"]) && $_SESSION["signed_in"] == false ) ) {
			redirect(base_url());
		}

		$this->load->view("admin_alert_words", $this->user_control->ControllerInfo());
	}
}
?>