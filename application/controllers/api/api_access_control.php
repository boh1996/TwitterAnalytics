<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/api/T_API_Controller.php');

/**
 *
 * The Access Control Controller/Endpoint
 *
 * @uses 			API Controller
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Bo Thomsen
 * @version 		1.0
 */
class API_Access_Control extends T_API_Controller {

	/**
	 * This function is called on any request send to this endpoint,
	 * it loads up all the needed files
	 * @since 1.0
	 * @access public
	 */
	public function __construct () {
		parent::__construct();
		$this->lang->load("admin");
	}

	public function save_post () {
		if ( ! $this->post("pages") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_missing_post_data")
				)
			), 400);
		}

		$this->load->model("access_model");

		if ( $this->access_model->save_pages($this->post("pages")) ) {
			$this->response(array(
				"status" => true
			), 200);
		} else {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_post_data_error")
				)
			), 400);
		}
	}
}