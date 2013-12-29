<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {

	/**
	 * Contructor
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 * Shows the admin settings planel
	 */
	public function index () {
		$this->lang->load("common");
		$this->lang->load("admin");
		$this->load->model("settings_model");

		if ( ! $this->user_control->check_security("admin_home") ) {
			redirect(base_url() . "sign_in");
		}

		$this->load->view("admin_settings", $this->user_control->ControllerInfo(array(
			"current_section" => "admin",
			"accounts" => $this->settings_model->get_twitter_users(),
			"translations" => json_encode($this->lang->export()),
		)));
	}

	/**
	 * Shows the settings page for the alert words
	 */
	public function alerts_view () {
		$this->lang->load("common");
		$this->lang->load("admin");
		$this->load->model("settings_model");
		$this->load->model("alert_model");

		if ( ! $this->user_control->check_security("admin_alerts") ) {
			redirect(base_url() . "sign_in");
		}

		$alerts = $this->alert_model->get_list("alert_strings");

		$this->load->view("admin_alerts", $this->user_control->ControllerInfo(array(
			"current_section" => "admin",
			"translations" => json_encode($this->lang->export()),
			"settings" => $this->settings_model->check_defaults("alerts",$this->settings_model->get_settings("alerts")),
			"alerts" => ( $alerts !== false ) ? $alerts : array()
		)));
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
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin"
		)));
	}

	/**
	 * Shows the topics admin view
	 */
	public function topics_view () {
		$this->lang->load("admin");

		if ( ! $this->user_control->check_security("admin_topics") ) {
			redirect(base_url() . "sign_in");
		}

		$this->load->view("admin_topics_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin"
		)));
	}
}
?>