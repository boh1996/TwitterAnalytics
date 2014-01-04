<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {

	/**
	 * Contructor
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 * Shows the history template view
	 */
	public function history_view () {
		$this->lang->load("admin");

		if ( ! $this->user_control->check_security("admin_status") ) {
			redirect(base_url() . "sign_in");
		}

		$this->load->model("status_model");
		$history = $this->status_model->get_history();

		$this->load->view("templates/status_history_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"history" => ( $history !== false ) ? $history : array(),
		)));
	}

	/**
	 * Get active scrapers template view
	 */
	public function active_scrapers_view () {
		$this->lang->load("admin");

		if ( ! $this->user_control->check_security("admin_status") ) {
			redirect(base_url() . "sign_in");
		}

		$this->load->model("status_model");
		$active = $this->status_model->get_active_scrapers();

		$this->load->view("templates/status_active_scrapers_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"active" => ( $active !== false ) ? $active : array(),
		)));
	}

	/**
	 * Shows the scrapers part of the status viewn
	 */
	public function scrapers_view () {
		$this->lang->load("admin");

		if ( ! $this->user_control->check_security("admin_status") ) {
			redirect(base_url() . "sign_in");
		}

		$this->load->model("status_model");
		$scrapers = $this->status_model->get_scrapers();

		$this->load->view("templates/status_scrapers_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"scrapers" => ( $scrapers !== false ) ? $scrapers : array(),
		)));
	}

	/**
	 * Shows the errors template view
	 */
	public function errors_view () {
		$this->lang->load("admin");

		if ( ! $this->user_control->check_security("admin_status") ) {
			redirect(base_url() . "sign_in");
		}

		$this->load->model("status_model");
		$errors = $this->status_model->get_errors();

		$this->load->view("templates/status_errors_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"errors" => ( $errors !== false ) ? $errors : array(),
		)));
	}

	/**
	 * Shows the scraper status view
	 */
	public function status_view () {
		$this->lang->load("admin");

		if ( ! $this->user_control->check_security("admin_status") ) {
			redirect(base_url() . "sign_in");
		}

		$this->load->model("status_model");
		$errors = $this->status_model->get_errors();
		$history = $this->status_model->get_history();
		$scrapers = $this->status_model->get_scrapers();
		$active = $this->status_model->get_active_scrapers();

		$this->load->view("admin_status_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"errors" => ( $errors !== false ) ? $errors : array(),
			"history" => ( $history !== false ) ? $history : array(),
			"scrapers" => ( $scrapers !== false ) ? $scrapers : array(),
			"active" => ( $active !== false ) ? $active : array(),
		)));
	}

	/**
	 * Shows the scraper/system settings view
	 */
	public function settings_view () {
		$this->lang->load("common");
		$this->lang->load("admin");
		$this->load->model("settings_model");

		if ( ! $this->user_control->check_security("admin_settings") ) {
			redirect(base_url() . "sign_in");
		}

		$this->load->view("admin_settings_view", $this->user_control->ControllerInfo(array(
			"current_section" => "admin",
			"translations" => json_encode($this->lang->export()),
			"settings" => $this->settings_model->check_defaults("scraper",$this->settings_model->get_settings("scraper")),
		)));
	}

	/**
	 * Shows the admin twitter planel
	 */
	public function twitter_view () {
		$this->lang->load("common");
		$this->lang->load("admin");
		$this->load->model("settings_model");

		if ( ! $this->user_control->check_security("admin_twitter") ) {
			redirect(base_url() . "sign_in");
		}

		$this->load->view("admin_twitter", $this->user_control->ControllerInfo(array(
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
	 * Shows the list of words, that will block a tweet view
	 */
	public function blocked_strings_view () {
		$this->lang->load("admin");

		if ( ! $this->user_control->check_security("admin_topics") ) {
			redirect(base_url() . "sign_in");
		}

		$objects = $this->base_model->get_list("blocked_strings");

		$this->load->view("admin_blocked_strings_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"objects" => ( $objects !== false ) ? $objects : array()
		)));
	}

	/**
	 * Shows the view, where the string to remove is selected
	 */
	public function strings_to_remove_view () {
		$this->lang->load("admin");

		if ( ! $this->user_control->check_security("admin_topics") ) {
			redirect(base_url() . "sign_in");
		}

		$objects = $this->base_model->get_list("removed_strings");

		$this->load->view("admin_strings_to_remove_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"objects" => ( $objects !== false ) ? $objects : array()
		)));
	}

	/**
	 * Shows the URLs view
	 */
	public function urls_view () {
		$this->lang->load("admin");

		if ( ! $this->user_control->check_security("admin_topics") ) {
			redirect(base_url() . "sign_in");
		}

		$objects = $this->base_model->get_list("urls");

		$this->load->view("admin_urls_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"objects" => ( $objects !== false ) ? $objects : array()
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

		$topics = $this->base_model->get_list("topics");

		$this->load->view("admin_topics_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"topics" => ( $topics !== false ) ? $topics : array()
		)));
	}
}
?>