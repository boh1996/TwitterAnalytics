<?php
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
}
?>