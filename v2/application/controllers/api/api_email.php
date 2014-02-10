<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/api/T_API_Controller.php');

/**
 *
 * The Scraper Controller/Endpoint
 *
 * @uses 			API Controller
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Bo Thomsen
 * @version 		1.0
 */
class API_Email extends T_API_Controller {

	public $methods = array("interval_get" => array("key" => false));

	public function __construct () {
		parent::__construct();
	}

	/**
	 *    The input that triggers an interval alert text
	 *
	 */
	public function interval_get () {
		if ( ! $this->get("interval") ) {
			$this->response(array(
				"status" => false
			), 400);
		}

		$this->load->model("email_model");

		$interval_object = $this->email_model->get_interval($this->get("interval"));

		if ( $interval_object === false ) {
			$this->response(array(
				"status" => false
			), 400);
		}

		$email = true;

		if ( $interval_object->email == "false" ) {
			$email = false;
		} else if ( $interval_object->email == "0" ) {
			$email = false;
		} else if ( $interval_object->email === false ) {
			$email = false;
		}

		if ( $email == false) {
			$this->response(array(
				"status" => false
			), 400);
		}

		$pages = $this->base_model->get_list("statistic_pages");

		foreach ( $pages as $page ) {
			$this->email_model->process($interval_object->value, $page->id);
		}

		$this->response(array(
			"status" => true
		));
	}
}