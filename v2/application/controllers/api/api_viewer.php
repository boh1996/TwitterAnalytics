<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/api/T_API_Controller.php');

/**
 *
 * The Viewer Controller/Endpoint
 *
 * @uses 			API Controller
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Bo Thomsen
 * @version 		1.0
 */
class API_Viewer extends T_API_Controller {

	protected $methods = array(
		"stats_get" => array("key" => false)
	);


	public function __construct () {
		parent::__construct();
		$this->load->model("settings_model");
		$this->load->model("statistic_model");
	}

	public function stats_get () {
		if ( ! $this->get("page") || ! $this->get("interval") ) {
			$this->response(array(
				"status" => false
			), 400);
		}

		$this->load->model("page_model");
		$page = $this->page_model->get_statistic_page($this->get("page"));

		if ( $page === false ) {
			$this->response(array(
				"status" => false,
			),400);
		}

		if ( $page->login == "true" && $this->user_control->is_signed_in() === false ) {
			$this->response(array(
				"status" => false,
				"login_redirect" => true
			),403);
		}

		$tweets = $this->statistic_model->tweets_ranges($this->statistic_model->create_time_ranges($this->get("interval"), $this->settings_model->fetch_setting("setting_number_of_columns", 10, "viewer"), time()), $page->id);

		$response = $tweets;

		$this->response(array(
			"status" => true,
			"tweets" => $tweets
		),200);
	}
}