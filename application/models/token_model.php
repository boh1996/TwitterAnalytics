<?php
class Token_Model extends CI_Model {

	/**
	 * Checks if a token exists, based it's token string
	 * @param  string $token The token to look for
	 * @return boolean
	 */
	public function token_exists_token ( $token = null ) {
		if ( empty($token) ) return false;

		$query = $this->db->from("api_tokens")->where(array(
			"token" => $token
		))->get();

		if ( $query->num_rows() > 0 ) return true;

		return false;
	}

	/**
	 * Creates and inserts a token into the database
	 * @param  integer $user_id The database id of the user who owns the token
	 * @param string &$token A variable to store the token in
	 * @return integer          The token id
	 */
	public function create_token ( $user_id, &$token ) {
		$this->load->helper("rand");
		$token = Rand_Str(64);
		$data = array(
			"ip_address" => $_SERVER['REMOTE_ADDR'],
			"is_private_key" => false,
			"user_id" => $user_id,
			"created_at" => time(),
			"token" => $token
		);

		$this->db->insert("api_tokens", $data);

		return $this->db->insert_id();
	}

	/**
	 * This function removes the users token from the database
	 * @param  string $token   The token to remove
	 * @return boolean
	 */
	public function remove_token ( $token = null) {
		if ( empty($token) ) return false;

		$this->db->where(array(
			"token" => $token
		))->delete("api_tokens");

		return true;
	}
}
?>