<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/api/T_API_Controller.php');

/**
 *
 * The Alert Controller/Endpoint
 *
 * @uses 			API Controller
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Bo Thomsen
 * @version 		1.0
 */
class API_Alerts extends T_API_Controller {

	public function __construct () {
		parent::__construct();
		$this->load->model("alert_model");
	}

	/**
	 * Deletes an alert string
	 */
	public function alert_string_delete () {
		if ( ! $this->get("id") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_missing_id")
				)
			), 400);
		}

		$this->alert_model->delete($this->get("id"));

		$this->response(array(
			"status" => true
		), 200);
	}

	/**
	 * Saves the alerts
	 */
	public function save_alerts_post () {
		if ( ! $this->post("alerts") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_missing_post_data")
				)
			), 400);
		}

		$this->alert_model->save_list("alert_strings", $this->post("alerts") ,array("id", "value"));

		$this->response(array(
			"status" => true
		), 200);
	}
}