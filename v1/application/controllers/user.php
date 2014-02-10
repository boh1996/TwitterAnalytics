<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage User Analytics Viewer
 * @license Microsoft Reference License
 * @version 1.0
 * @filesource
 */
class User extends CI_Controller {

	/**
	 * A variable storing the limit,
	 * and initialized by the constructor
	 * @var integer
	 * @since 1.0
	 */
	public $limit = 50;

	/**
	 * A variable storing the possible selected date string
	 * @var string
	 * @since 1.0
	 */
	public $date = null;

	/**
	 * Users/default settings container
	 * @var array
	 * @since 1.0
	 */
	public $settings = array();

	/**
	 * Constructor function
	 * @since 1.0
	 * @uses setings_model Uses the settings model to retrieve user settings
	 */
	public function __construct () {
		parent::__construct();

		$this->load->model("settings_model");
		$this->settings["scraper"] = $this->settings_model->check_defaults("scraper",$this->settings_model->get_settings("scraper"));
		$this->settings["alerts"] = $this->settings_model->check_defaults("alerts",$this->settings_model->get_settings("alerts"));

		if ( $this->input->get("limit") ) {
			$this->limit = $this->input->get("limit");
		}

		if ( $this->input->get("date") ) {
			$this->date = $this->input->get("date");
		}

		$this->max = $this->settings["scraper"]["setting_viewer_max_time"]->value * 60;
	}

	/**
	 * Shows the alert box template view
	 * @uses user_control Uses the user_control library to check for security
	 * @uses analytics_model Uses the analytics model to fetch alerts
	 */
	public function alerts_box_view () {
		if ( ! $this->user_control->check_security("user_home") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
		}

		$this->lang->load("common");
		$this->load->model("analytics_model");

		$alert_strings = $this->analytics_model->fetch_alert_box($this->limit, $this->settings["alerts"]["setting_alert_words"]->value, $this->date, $this->max);

		$data = array(
			"current_section" => "user",
			"translations" => json_encode($this->lang->export()),
			"alert_strings" => ( $alert_strings !== false ) ? $alert_strings : array(),
		);

		$this->load->view("templates/analytics_alerts_view", $this->user_control->ControllerInfo($data));
	}

	/**
	 * Shows the user analytics view
	 */
	public function index () {
		if ( ! $this->user_control->check_security("user_home") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
		}

		$this->lang->load("common");
		$this->load->model("analytics_model");

		$words = $this->analytics_model->fetch_words($this->limit, $this->date, $this->max);
		$alert_strings = $this->analytics_model->fetch_alert_box($this->limit, $this->settings["alerts"]["setting_alert_words"]->value, $this->date, $this->max);

		$data = array(
			"current_section" => "user",
			"translations" => json_encode($this->lang->export()),
			"words" => ( $words !== false ) ? $words : array(),
			"limits" => $this->analytics_model->limits(),
			"alert_strings" => ( $alert_strings !== false ) ? $alert_strings : array(),
		);

		$this->load->view("user_home_view", $this->user_control->ControllerInfo($data));
	}

	/**
	 * Shows the alerts page view
	 */
	public function alerts_view () {
		$this->lang->load("common");
		$this->load->model("analytics_model");

		if ( ! $this->user_control->check_security("user_alerts") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
		}

		$alerts = $this->analytics_model->fetch_alert_words($this->limit, $this->date, $this->max);

		$data = array(
			"current_section" => "user",
			"translations" => json_encode($this->lang->export()),
			"alerts" => ( $alerts !== false ) ? $alerts : array(),
			"limits" => $this->analytics_model->limits()
		);

		$this->load->view("user_alerts_view", $this->user_control->ControllerInfo($data));
	}

	/**
	 * Shows the alerts list view
	 */
	public function alerts_list_view () {

		$this->lang->load("common");
		$this->load->model("analytics_model");

		if ( ! $this->user_control->check_security("user_alerts") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
		}

		$alerts = $this->analytics_model->fetch_alert_words($this->limit, $this->date, $this->max);

		$data = array(
			"current_section" => "user",
			"translations" => json_encode($this->lang->export()),
			"alerts" => ( $alerts !== false ) ? $alerts : array(),
		);

		$this->load->view("templates/analytics_alerts_list_view", $this->user_control->ControllerInfo($data));
	}

	/**
	 * Shows the words templates view
	 */
	public function words_view () {
		if ( ! $this->user_control->check_security("user_home") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
		}

		$this->load->model("analytics_model");

		$words = $this->analytics_model->fetch_words($this->limit, $this->date, $this->max);

		$data = array(
			"current_section" => "user",
			"translations" => json_encode($this->lang->export()),
			"words" => ( $words !== false ) ? $words : array()
		);

		$this->load->view("templates/analytics_words_view", $this->user_control->ControllerInfo($data));
	}
}
?>