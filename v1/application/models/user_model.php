<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage User Control
 * @license Microsoft Reference License
 * @extends CI_Model
 * @version 1.0
 * @filesource
 */
class User_model extends CI_Model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 * Checks if a user exists based on the user id
	 * @param  integer $id The users id
	 * @return boolean
	 */
	public function user_exists_id ( $id = null ) {
		if ( empty($id) ) return false;

		$query = $this->db->from("users")->where(array(
			"id" => $id
		))->get();

		if ( $query->num_rows() > 0 ) return true;

		return false;

	}

	/**
	 * Checks if a user exists based on the username
	 * @param  string $username The username of the user
	 * @return boolean
	 */
	public function user_exists_username ( $username = null ) {
		if ( empty($username) ) return false;

		$query = $this->db->where(array(
			"username" => $username
		))->get("users");

		if ( $query->num_rows() > 0 ) return true;

		return false;
	}

	/**
	 * This functions fetches the user information based on the id
	 * @param  integer $id The user id
	 * @return Object
	 */
	public function fetch_user_id ( $id ) {
		if ( empty($id) ) return false;

		$query = $this->from("users")->where(array(
			"id" => $id
		))->get();

		if ( $query->num_rows() > 0 ) {
			return $query->row();
		};

		return false;
	}

	/**
	 * Fetches the user information based on the username
	 * @param  string $username The users username
	 * @return Object
	 */
	public function fetch_user_username ( $username ) {
		if ( empty($username) ) return false;

		$query = $this->db->from("users")->where(array(
			"username" => $username
		))->get();

		if ( $query->num_rows() > 0 ) {
			return $query->row();
		};

		return false;
	}

	/**
	 * Updates a user, based on the user id
	 * @param  integer $id   The users id
	 * @param  Array $data The keys->values to update
	 */
	public function update_user_by_id ( $id, $data ) {
		$this->db->from("users")->where(array(
			"id" => $id
		))->update($data);
	}

	/**
	 *    Creates a user
	 *
	 *    @param string $username           The users username
	 *    @param string $password           The users password
	 *    @param string $user_secret        The users hash salt
	 *    @param integer $hashing_iterations The number of hashing iterations
	 *
	 *    @return boolean
	 */
	public function create_user ( $username, $password, $user_secret, $hashing_iterations ) {
		if ( $this->user_exists_username($username) ) {
			return false;
		}

		$this->db->insert("users", array(
			"username" => $username,
			"password" => $password,
			"user_token" => $user_secret,
			"hashing_iterations" => $hashing_iterations,
			"created_at" => time()
		));

		return true;
	}
}
?>