<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {

	/**
	 * Shows the admin settings planel
	 */
	public function index () {
		$this->lang->load("common");
		$this->lang->load("admin");

		if ( ! $this->user_control->check_security("admin_home") ) {
			redirect(base_url() . "sign_in");
		}

		$this->load->view("admin", $this->user_control->ControllerInfo());
	}

	/**
	 * Shows the settings page for the alert words
	 */
	public function alerts_view () {
		$this->lang->load("common");
		$this->lang->load("admin");

		if ( ! $this->user_control->check_security("admin_alerts") ) {
			redirect(base_url() . "sign_in");
		}

		$this->load->view("admin_alert_words", $this->user_control->ControllerInfo());
	}

	/**
	 * Shows the access control management page
	 */
	public function access_control_view () {
		$this->lang->load("admin");
		$this->load->model("access_model");

		if ( ! $this->user_control->check_security("admin_access_control") ) {
			redirect(base_url() . "sign_in");
		}

		$this->load->view("admin_access_control", $this->user_control->ControllerInfo(array(
			"pages" => $this->access_model->get_pages(),
			"translations" => json_encode($this->lang->export())
		)));
	}
}
?>