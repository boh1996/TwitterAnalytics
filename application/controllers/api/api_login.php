<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/api/T_API_Controller.php');

/**
 *
 * The Login Controller/Endpoint
 *
 * @uses 			API Controller
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Bo Thomsen
 * @version 		1.0
 */
class API_Login extends T_API_Controller {

	/**
	 * Methods settings
	 * @var array
	 */
	protected $methods = array(
		"login_post" => array("key" => false)
	);

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
	 * Removes the session data and token
	 */
	public function logout_get () {
		$token = $_SESSION["data"]["token"];
		$this->load->model("token_model");
		$this->token_model->remove_token($token);

		session_destroy();

		$this->response(array(
			"status" => true,
		), 200);
	}

	/**
	 * This endpoint validates the users credidentials and returns a token
	 */
	public function login_post () {
		$this->lang->load("login");

		$this->config->load("login");

		$this->load->library("auth/login_security");

		$this->load->model("user_model");

		// Remove illegal chars from the input
		$username = $this->login_security->check_security($this->post('username'));
		$password = $this->login_security->check_security($this->post('password'));

		// If no username and password has been posted, show an error
		if ( ! $this->post("username") && ! $this->post("password") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("sign_in_missing_username_and_password")
				)
			), 400);
		}

		// If no username has been posted, show an error
		if ( ! $this->post("username") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("sign_in_missing_username")
				)
			), 400);
		}

		// If not password has been posted, shown an error
		if ( ! $this->post("password") ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("sign_in_missing_password")
				)
			), 400);
		}

		// If variables are empty then the posted data included only illegal data
		if ( is_null($username) || is_null($password) || $password === false || $username === false ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("sign_in_secuirty_details")
				)
			), 400);
		}

		// Check if the user exists
		if ( ! $this->user_model->user_exists_username($username) ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("sign_in_username_not_found")
				)
			), 400);
		}

		$user = $this->user_model->fetch_user_username($username);

		// Database error has occured or user removed since last check
		if ( $user === false ) {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("sign_in_error_occured")
				)
			), 500);
		}

		// Check if the username and password match, and is hashed correctly
		if ( $this->login_security->check($password, $user->password, $user->user_token ,$user->hashing_iterations, $userHash) ) {
			if ( $user->password != $userHash) {
				$this->user_model->update_user_by_id($user->id, array(
					"hashing_iterations" => $this->config->item("hashing_iterations"),
					"password"	=> $userHash
				));
			}
		} else {
			$this->response(array(
				"status" => false,
				"error_messages" => array(
					$this->lang->line("sign_in_password_not_correct")
				)
			), 403);
		}

		$this->load->model("token_model");

		// Create the access token
		$this->token_model->create_token($user->id, $token);

		// Change the session data
		$_SESSION["signed_in"] = true;
		$_SESSION["data"] = array(
			"token" => $token,
			"user_id" => $user->id,
			"signed_in_at" => mktime()
		);

		$this->response(array(
			"status" => true,
			"token" => $token
		), 200);
	}

}