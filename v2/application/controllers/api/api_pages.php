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

		$this->page_model->update_element("statistic_pages",array(
			"name" => $this->get("name")
		), array(
			"id" => $this->get("id")
		));

		$this->repsonse(array(
			"status" => true
		));
	}
}