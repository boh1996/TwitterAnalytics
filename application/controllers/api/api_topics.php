<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/api/T_API_Controller.php');

/**
 *
 * The Topics Controller/Endpoint
 *
 * @uses 			API Controller
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Bo Thomsen
 * @version 		1.0
 */
class API_Topics extends T_API_Controller {

	public function __construct () {
		parent::__construct();
		$this->load->model("alert_model");
	}

	/**
	 * Deletes a topic
	 */
	public function topic_delete () {
		if ( ! $this->get("id") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_missing_id")
				)
			), 400);
		}

		$this->base_model->delete($this->get("id"), "topics");

		$this->response(array(
			"status" => true
		), 200);
	}

	/**
	 * Saves the topics
	 */
	public function save_topics_post () {
		if ( ! $this->post("topics") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_missing_post_data")
				)
			), 400);
		}

		$this->base_model->save_list("topics", $this->post("topics") ,array("id", "value"));

		$this->response(array(
			"status" => true
		), 200);
	}
}