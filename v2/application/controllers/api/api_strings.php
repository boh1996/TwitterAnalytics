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
class API_Strings extends T_API_Controller {

	public function __construct () {
		parent::__construct();
	}

	/**
	 *    Deletes a Page String
	 *
	 */
	public function string_delete () {
		if ( ! $this->get("id") ) {
			$this->response(array(
				"status" => false,
				"error_code" => 400
			), 400);
		}

		$this->db->delete("statistic_strings", array(
			"id" => $this->get("id")
		));

		$this->db->delete(array(
			"statistic_tweet_string_id" => $this->get("id")
		));
	}
}