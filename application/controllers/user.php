<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {

	public $limit = 50;

	public $date = null;

	/**
	 * Shows the user analytics view
	 */
	public function index () {
		if ( $this->input->get("limit") ) {
			$this->limit = $this->input->get("limit");
		}

		$this->lang->load("common");
		$this->load->model("analytics_model");

		if ( ! $this->user_control->check_security("user_home") ) {
			redirect(base_url() . "sign_in");
		}

		$words = $this->analytics_model->fetch_words($this->limit, $this->date);

		$data = array(
			"current_section" => "user",
			"translations" => json_encode($this->lang->export()),
			"words" => ( $words !== false ) ? $words : array()
		);

		$this->load->view("user_home_view", $this->user_control->ControllerInfo($data));
	}

	/**
	 * Shows the words templates view
	 */
	public function words_view () {
		if ( $this->input->get("limit") ) {
			$this->limit = $this->input->get("limit");
		}

		if ( $this->input->get("date") ) {
			$this->date = $this->input->get("date");
		}

		$this->load->model("analytics_model");

		if ( ! $this->user_control->check_security("user_home") ) {
			redirect(base_url() . "sign_in");
		}

		$words = $this->analytics_model->fetch_words($this->limit, $this->date);

		$data = array(
			"current_section" => "user",
			"translations" => json_encode($this->lang->export()),
			"words" => ( $words !== false ) ? $words : array()
		);

		$this->load->view("templates/analytics_words_view", $this->user_control->ControllerInfo($data));
	}
}
?>