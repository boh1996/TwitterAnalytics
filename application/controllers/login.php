<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {

	public function index () {}

	/**
	 * Shows the sig in view
	 */
	public function sign_in_view () {

		$this->lang->load("login");

		if ( ! $this->user_control->is_signed_in() ) {
			$this->load->view("sign_in", $this->user_control->ControllerInfo(array(
				"translations" => json_encode($this->lang->export()),
				"current_section" => "login"
			)));
		} else {
			redirect($this->config->item("base_url"));
		}
	}

	/**
	 * Signs the user out
	 */
	public function sign_out () {
		$token = $_SESSION["data"]["token"];
		$this->load->model("token_model");
		$this->token_model->remove_token($token);
		session_destroy();

		redirect(base_url());
	}
}
?>