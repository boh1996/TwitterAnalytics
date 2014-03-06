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
class API_Pages extends T_API_Controller {

	public function __construct () {
		parent::__construct();
		$this->load->model("page_model");
	}

	/**
	 * Deletes an alert string
	 */
	public function pages_get () {
		if ( ! $this->get("name") || ! $this->get("id") ) {
			$this->response();
		}

		if ( $this->get("id") != "undefined" ) {

			$this->page_model->update_element("statistic_pages",array(
				"name" => $this->get("name")
			), array(
				"id" => $this->get("id")
			));
		} else {
			$ids = $this->page_model->save_pages(array(array(
				"name" => $this->get("name"),
				"strings" => array(),
				"urls" => array(),
				"login" => true,
				"exact_match" => false
			)));
		}

		$this->response(array(
			"status" => true,
		));
	}

	/**
	 *    Delete page endpoint
	 *
	 */
	public function page_delete () {
		if ( ! $this->get("id") ) {
			$this->response(array(
				"status" => false,
			), 400);
		}

		$this->page_model->delete_page($this->get("id"));

		$this->response(array(
			"status" => true
		));
	}

	/**
	 *    Save post batch
	 *
	 */
	public function save_post () {
		if ( ! $this->post("pages") ) {
			$this->response(array(
				array(
					"status" => false
				)
			),400);
		}

		$this->page_model->save_pages($this->post("pages"));

		$this->response(array(
			"status" => true
		),200);
	}
}