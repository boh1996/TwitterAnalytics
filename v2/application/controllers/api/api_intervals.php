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

		$this->interval_model->change($this->post("key"), array(
			"login" => $this->post("login"),
			"name" => $this->post("name"),
			"value" => $this->post("value")
		));
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

		foreach ( $this->post("intervals") as $interval ) {
			$this->interval_model->change($interval->key, array(
				"login" => $interval->login,
				"name" => $interval->name,
				"value" => $interval->value
			));
		}
	}
}