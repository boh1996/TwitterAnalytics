<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage Control Panel
 * @license Microsoft Reference License
 * @version 1.0
 * @filesource
 */
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
		if ( ! $this->user_control->check_security("admin_status") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("admin");

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
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
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
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
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
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
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
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
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
		if ( ! $this->user_control->check_security("admin_settings") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("common");
		$this->lang->load("admin");
		$this->load->model("settings_model");

		$this->load->view("admin_settings_view", $this->user_control->ControllerInfo(array(
			"current_section" => "admin",
			"translations" => json_encode($this->lang->export()),
			"scraper_settings" => $this->settings_model->check_defaults("scraper",$this->settings_model->get_settings("scraper")),
		)));
	}

	/**
	 * Shows the access control management page
	 */
	public function access_control_view () {
		if ( ! $this->user_control->check_security("admin_access_control") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("admin");
		$this->load->model("access_model");

		$this->load->view("admin_access_control_view", $this->user_control->ControllerInfo(array(
			"pages" => $this->access_model->get_pages(),
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin"
		)));
	}

	/**
	 * Shows the URLs view
	 */
	public function urls_view () {
		if ( ! $this->user_control->check_security("admin_topics") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("admin");

		$objects = $this->base_model->get_list("urls");

		$this->load->view("admin_urls_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"objects" => ( $objects !== false ) ? $objects : array()
		)));
	}

	/**
	 *    Shows the pages view
	 *
	 */
	public function pages_view () {
		if ( ! $this->user_control->check_security("admin_pages") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("admin");
		$this->load->model("words_model");
		$objects = $this->words_model->get_pages_info();

		$this->load->view("admin_pages_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"objects" => ( $objects !== false ) ? $objects : array()
		)));
	}

	/**
	 *    Shows the admin pages template view, used for AJAX refresh
	 *
	 */
	public function pages_template_view () {
		if ( ! $this->user_control->check_security("admin_pages") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("admin");
		$this->load->model("words_model");
		$objects = $this->words_model->get_pages_info();

		$this->load->view("templates/admin_pages_template_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"objects" => ( $objects !== false ) ? $objects : array()
		)));
	}

	/**
	 *    Shows the intervals settings view
	 *
	 */
	public function intervals_view () {
		if ( ! $this->user_control->check_security("admin_intervals") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("admin");
		$this->load->model("settings_model");
		$objects = $this->settings_model->get_intervals();

		$this->load->view("admin_intervals_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"objects" => ( $objects !== false ) ? $objects : array()
		)));
	}
}
?>