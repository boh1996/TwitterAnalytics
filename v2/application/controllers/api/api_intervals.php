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
class API_Intervals extends T_API_Controller {

	public function __construct () {
		parent::__construct();
		$this->load->model("interval_model");
	}

	/**
	 *    Hide a default interval
	 *
	 */
	public function hide_get () {
		if ( ! $this->get("key") ) {
			$this->response(array(
				"status" => false
			), 400);
		}

		$this->interval_model->change($this->get("key"), array(
			"status" => false
		));
	}

	/**
	 *    Shows a default interval
	 *
	 */
	public function show_get () {
		if ( ! $this->get("key") ) {
			$this->response(array(
				"status" => false
			), 400);
		}

		$this->interval_model->change($this->get("key"), array(
			"status" => true
		));
	}

	/**
	 *    Delete an interval
	 *
	 */
	public function interval_delete () {
		if ( ! $this->get("key") ) {
			$this->response(array(
				"status" => false
			), 400);
		}

		$this->interval_model->change($this->get("key"));
	}

	/**
	 *    Creates / Updates an Interval
	 *
	 */
	public function interval_post () {
		if ( ! $this->post("key") ) {
			$this->response(array(
				"status" => false
			), 400);
		}

		$columns = array("login", "name", "value", "email_change_value", "decrease_email", "increase_email", "category_difference", "category_change_value");

		$data = array();

		foreach ( $columns as $key ) {
			if ( $this->post($key) !== false ) {
				$data[$key] = $this->post($key);
			}
		}

		$this->interval_model->change($this->post("key"), $data);
	}

	/**
	 *    Batch update Intervals
	 *
	 */
	public function intervals_post () {
		if ( ! $this->post("intervals") ) {
			$this->response(array(
				"status" => false
			), 400);
		}

		$columns = array("login", "name", "value", "email_change_value", "decrease_email", "increase_email", "category_difference", "category_change_value");

		foreach ( $this->post("intervals") as $interval ) {
			$data = array();

			foreach ( $columns as $key ) {
				if ( $this->post($key) !== false ) {
					$data[$key] = $this->post($key);
				}
			}
			$this->interval_model->change($interval->key, $data);
		}
	}
}