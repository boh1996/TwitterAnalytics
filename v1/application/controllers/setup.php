<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setup extends CI_Controller {

	public function index () {
		if ( file_exists("setup.txt") ) {
			redirect(base_url());
		}

		$this->lang->load("setup");

		$data = array(
			"translations" => json_encode($this->lang->export()),
		);

		$this->load->view("setup_view", $this->user_control->ControllerInfo($data));
	}

	public function save () {
		if ( file_exists("setup.txt") ) {
			redirect(base_url());
		}

		$this->load->library("input");
		if ( ! $this->input->post("username") ||! $this->input->post("password") ) {
			redirect(base_url() . "setup");
		}

		$this->load->config("login");

		$this->load->library("auth/login_security");
		$hashing_iterations = $this->config->item("hashing_iterations");
		$password = $this->login_security->createUser($this->input->post("password"), $hashing_iterations, 64, $user_salt);

		if ( $password === false ) {
			redirect(base_url() . "setup");
		}

		$this->load->model("user_model");

		$success = $this->user_model->create_user($this->input->post("username"), $password, $user_salt, $hashing_iterations );

		if ( ! $success ) {
			redirect(base_url() . "setup");
		} else {
			file_put_contents("setup.txt", "true");;
			redirect(base_url());
		}
	}
}
?>