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

		$email = $this->email_model->if_to_email($interval_object, $email_types);

		if ( $email == false) {
			$this->response(array(
				"status" => false
			), 400);
		}

		$pages = $this->base_model->get_list("statistic_pages");

		if ( $pages == false) {
			$this->response(array(
				"status" => false
			), 400);
		}

		$mail_send = false;

		foreach ( $pages as $page ) {
			$intervals_difference = $this->email_model->process($interval_object->value, $page->id, $email_types, $interval_object->email_change_value, $interval_object->category_change_value);
			if ( $intervals_difference == true ) {
				$mail_send = true;
			}

			if ( in_array("category", $email_types) && ! ( in_array("increase", $email_types) || in_array("decrease", $email_types) ) ) {
				$category_mail = $this->email_model->category_alert($interval_object->value, $page->id, $interval_object->category_change_value);
				if ( $category_mail == true ) {
					$mail_send = true;
				}
			}
		}

		$this->response(array(
			"status" => $mail_send
		));
	}
}