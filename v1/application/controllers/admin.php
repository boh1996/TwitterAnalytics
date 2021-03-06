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
			"analytics_settings" => $this->settings_model->check_defaults("analytics",$this->settings_model->get_settings("analytics")),
		)));
	}

	/**
	 * Shows the admin twitter planel
	 */
	public function twitter_view () {
		if ( ! $this->user_control->check_security("admin_twitter") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("common");
		$this->lang->load("admin");
		$this->load->model("settings_model");

		$this->load->view("admin_twitter_view", $this->user_control->ControllerInfo(array(
			"current_section" => "admin",
			"accounts" => $this->settings_model->get_twitter_users(),
			"translations" => json_encode($this->lang->export()),
		)));
	}

	/**
	 * Shows the settings page for the alert words
	 */
	public function alerts_view () {
		if ( ! $this->user_control->check_security("admin_alerts") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("common");
		$this->lang->load("admin");
		$this->load->model("settings_model");
		$this->load->model("alert_model");

		$alerts = $this->alert_model->get_list("alert_strings");
		$hidden_words = $this->alert_model->get_list("hidden_connected_words");

		$this->load->view("admin_alerts_view", $this->user_control->ControllerInfo(array(
			"current_section" => "admin",
			"translations" => json_encode($this->lang->export()),
			"settings" => $this->settings_model->check_defaults("alerts",$this->settings_model->get_settings("alerts")),
			"alerts" => ( $alerts !== false ) ? $alerts : array(),
			"hidden_words" => ( $hidden_words !== false ) ? $hidden_words : array(),
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
	 * Shows the list of words, that will block a tweet view
	 */
	public function blocked_strings_view () {
		if ( ! $this->user_control->check_security("admin_topics") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("admin");

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
		if ( ! $this->user_control->check_security("admin_topics") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("admin");

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
		if ( ! $this->user_control->check_security("admin_topics") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("admin");

		$cat1 = $this->base_model->get_list("urls", array("category" => 1));
		$cat2 = $this->base_model->get_list("urls", array("category" => 2));
		$cat3 = $this->base_model->get_list("urls", array("category" => 3));
		$cat4 = $this->base_model->get_list("urls", array("category" => 4));
		$cat5 = $this->base_model->get_list("urls", array("category" => 5));
		$live = $this->base_model->get_list("urls", array("category" => "live"));

		$this->load->view("admin_urls_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"cat1" => ( $cat1 !== false ) ? $cat1 : array(),
			"cat2" => ( $cat2 !== false ) ? $cat2 : array(),
			"cat3" => ( $cat3 !== false ) ? $cat3 : array(),
			"cat4" => ( $cat4 !== false ) ? $cat4 : array(),
			"cat5" => ( $cat5 !== false ) ? $cat5 : array(),
			"live" => ( $live !== false ) ? $live : array(),
		)));
	}

	/**
	 * Shows the topics admin view
	 */
	public function topics_view () {
		if ( ! $this->user_control->check_security("admin_topics") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("admin");

		$topics = $this->base_model->get_list("topics");

		$this->load->view("admin_topics_view", $this->user_control->ControllerInfo(array(
			"translations" => json_encode($this->lang->export()),
			"current_section" => "admin",
			"topics" => ( $topics !== false ) ? $topics : array()
		)));
	}

	/**
	 * Shows the template for the alerts settings page
	 */
	public function alerts_settings_template_view () {
		if ( ! $this->user_control->check_security("admin_alerts") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("common");
		$this->lang->load("admin");
		$this->load->model("settings_model");

		$this->load->view("templates/admin_alerts_settings_view", $this->user_control->ControllerInfo(array(
			"current_section" => "admin",
			"translations" => json_encode($this->lang->export()),
			"settings" => $this->settings_model->check_defaults("alerts",$this->settings_model->get_settings("alerts")),
		)));
	}

	/**
	 * Shows the template for the hidden connected words page
	 */
	public function alerts_hidden_connected_words_template_view () {
		if ( ! $this->user_control->check_security("admin_alerts") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("common");
		$this->lang->load("admin");
		$this->load->model("alert_model");

		$hidden_words = $this->alert_model->get_list("hidden_connected_words");

		$this->load->view("templates/admin_alerts_connected_words_view", $this->user_control->ControllerInfo(array(
			"current_section" => "admin",
			"translations" => json_encode($this->lang->export()),
			"hidden_words" => ( $hidden_words !== false ) ? $hidden_words : array(),
		)));
	}

	/**
	 * Shows the template for the alert strings view
	 */
	public function alerts_strings_template_view () {
		if ( ! $this->user_control->check_security("admin_alerts") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("common");
		$this->lang->load("admin");
		$this->load->model("alert_model");

		$alerts = $this->alert_model->get_list("alert_strings");

		$this->load->view("templates/admin_alets_strings_view", $this->user_control->ControllerInfo(array(
			"current_section" => "admin",
			"translations" => json_encode($this->lang->export()),
			"alerts" => ( $alerts !== false ) ? $alerts : array(),
		)));
	}

	/**
	 * Shows the hidden words form template view
	 */
	public function hidden_words_template_view () {
		if ( ! $this->user_control->check_security("admin_hidden_words") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("common");
		$this->lang->load("admin");

		$objects = $this->base_model->get_list("hidden_words");

		$this->load->view("templates/admin_hidden_words_list_view", $this->user_control->ControllerInfo(array(
			"current_section" => "admin",
			"translations" => json_encode($this->lang->export()),
			"objects" => ( $objects !== false ) ? $objects : array(),
		)));
	}

	/**
	 * Shows the hidden words page
	 */
	public function hidden_words_view () {
		if ( ! $this->user_control->check_security("admin_hidden_words") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
			die();
		}

		$this->lang->load("common");
		$this->lang->load("admin");

		$objects = $this->base_model->get_list("hidden_words");

		$this->load->view("admin_hidden_words_view", $this->user_control->ControllerInfo(array(
			"current_section" => "admin",
			"translations" => json_encode($this->lang->export()),
			"objects" => ( $objects !== false ) ? $objects : array(),
		)));
	}
}
?>