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

		if ( $this->input->get("limit") ) {
			$this->limit = $this->input->get("limit");
		}

		if ( $this->input->get("date") ) {
			$this->date = $this->input->get("date");
		}
	}

	/**
	 * Shows the user analytics view
	 */
	public function index () {
		if ( ! $this->user_control->check_security("user_home") ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
		}

		$this->lang->load("common");

		$this->load->model("words_model");

		$objects = $this->words_model->get_pages_info();

		$data = array(
			"current_section" => "user",
			"translations" => json_encode($this->lang->export()),
			"objects" => ( $objects !== false ) ? $objects : array()
		);

		$this->load->view("user_home_view", $this->user_control->ControllerInfo($data));
	}
}
?>