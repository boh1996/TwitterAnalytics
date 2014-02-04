<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage Login System
 * @license Microsoft Reference License
 * @version 1.0
 * @filesource
 */
class Login extends CI_Controller {

	public function index () {}

	/**
	 * Shows the sig in view
	 */
	public function sign_in_view () {

		$this->lang->load("login");

		if ( $this->user_control->is_signed_in() === false ) {
			$this->load->view("sign_in_view", $this->user_control->ControllerInfo(array(
				"translations" => json_encode($this->lang->export()),
				"current_section" => "login"
			)));
		} else {
			redirect($this->user_control->CheckHTTPS(base_url()));
		}
	}

	/**
	 * Signs the user out
	 */
	public function sign_out () {
		$token = $this->session->userdata('token');;
		$this->session->sess_destroy();
		$this->load->model("token_model");
		$this->token_model->remove_token($token);

		redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
	}
}
?>