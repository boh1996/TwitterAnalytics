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

		$tweets = $this->statistic_model->tweets_ranges($this->statistic_model->create_time_ranges($this->get("interval"), $this->settings_model->fetch_setting("setting_number_of_columns", 10, "viewer"), time()), $this->get("page"));

		$response = $tweets;

		$this->response(array(
			"status" => true,
			"tweets" => $tweets
		),200);
	}
}