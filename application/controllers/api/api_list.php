<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/api/T_API_Controller.php');

/**
 *
 * The Lists Controller/Endpoint
 *
 * @uses 			API Controller
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Bo Thomsen
 * @version 		1.0
 */
class API_List extends T_API_Controller {

	public function __construct () {
		parent::__construct();
	}

	/**
	 * Deletes an alert string
	 */
	public function object_delete () {
		if ( ! $this->get("id") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_missing_id")
				)
			), 400);
		}

		$this->base_model->delete($this->get("id"), $this->get("db"));

		$this->response(array(
			"status" => true
		), 200);
	}

	/**
	 * Saves the list
	 */
	public function save_list_post () {
		if ( ! $this->post("list") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_missing_post_data")
				)
			), 400);
		}

		$this->base_model->save_list($this->get("db"), $this->post("list") ,array("id", "value"));

		$this->response(array(
			"status" => true
		), 200);
	}
}