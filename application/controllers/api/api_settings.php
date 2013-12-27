<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/api/T_API_Controller.php');

/**
 *
 * The Settings Controller/Endpoint
 *
 * @uses 			API Controller
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Bo Thomsen
 * @version 		1.0
 */
class API_Settings extends T_API_Controller {

	/**
	 * This function is called on any request send to this endpoint,
	 * it loads up all the needed files
	 * @since 1.0
	 * @access public
	 */
	public function __construct () {
		parent::__construct();
	}

	/**
	 * Updates the twitter account information
	 */
	public function twitter_post () {
		$this->load->model("settings_model");

		if ( ! $this->post("twitter") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_missing_post_data")
				)
			), 400);
		}

		if ( ! $this->settings_model->save_twitter($this->post("twitter"))  ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_post_data_error")
				)
			), 400);
		} else {
			$this->response(array(
				"status" => true
			), 200);
		}
	}

	/**
	 * Removes a twitter account
	 */
	public function remove_twitter_get () {
		if ( ! $this->get("account") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_missing_account_id")
				)
			), 400);
		}

		$this->load->model("settings_model");

		$this->settings_model->delete_twitter_account($this->get("account"));

		$this->response(array(
			"status" => true
		), 200);
	}

	public function settings_post () {

	}

	/**
	 * Removes a settings key
	 */
	public function setting_delete () {
		if ( ! $this->get("key") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_missing_key_name")
				)
			), 400);
		}

		$this->load->model("settings_model");

		$this->settings_model->delete_setting($this->get("key"));

		$this->response(array(
			"status" => true
		), 200);
	}

	/**
	 * Retrieves a settings value
	 */
	public function setting_get () {
		if ( ! $this->get("key") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_missing_key_name")
				)
			), 400);
		}

		$this->load->model("settings_model");

		$this->settings_model->get_setting($this->get("key"));

		$this->response(array(
			"status" => true
		), 200);
	}

	/**
	 * Updates a setting
	 */
	public function setting_post () {
		if ( ! $this->get("key") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("admin_missing_key_name")
				)
			), 400);
		}

		$this->load->model("settings_model");

		$this->settings_model->set_setting($this->get("key"));

		$this->response(array(
			"status" => true
		), 200);
	}
}