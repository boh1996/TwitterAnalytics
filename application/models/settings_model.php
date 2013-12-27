<?php
class Settings_model extends CI_Model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 * Saves the twitter account data
	 * @param  array $accounts An array of accounts
	 * @return boolean
	 */
	public function save_twitter ( $accounts ) {
		foreach ( $accounts as $account ) {
			if ( isset($account["username"]) || isset($account["password"]) ) {
				if ( isset($account["id"]) && $this->exists("twitter_users", array("id" => $account["id"])) ) {
					$data = array(
						"username" => $account["username"]
					);

					if ( isset($account["password"]) ) {
						$data["password"] = $this->encrypt_password($account["password"]);
					}
					$this->db->where(array("id" => $account["id"]))->update("twitter_users", $data);
				} else {
					if ( $this->exists("twitter_users", array("username" => $account["username"])) ) {
						if ( isset($account["password"]) ) {
							$this->db->where(array("username" => $account["username"]))->update("twitter_users", array(
								"password" => $this->encrypt_password($account["password"]),
							));
						}
					} else {
						if ( isset($account["password"]) && isset($account["username"]) ) {
							$this->db->insert("twitter_users", array(
								"username" => $account["username"],
								"password" => $this->encrypt_password($account["password"]),
							));
						}
					}
				}
			}
		}

		return true;
	}

	/**
	 * Encrypts the password with AES256
	 * @param  string $password The password
	 * @return string           base_64_encoded password
	 */
	public function encrypt_password ( $password ) {

		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
    	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

		$ciphertext =  mcrypt_encrypt(MCRYPT_RIJNDAEL_256, base64_decode($this->config->item("encrypt_key")) , $password, MCRYPT_MODE_CBC, $iv);

		$ciphertext = $iv . $ciphertext;

		return base64_encode($ciphertext);
	}

	/**
	 * Decrypts the password with MCRYPT_RIJNDAEL_256
	 * @param  string $text The text to decrypt
	 * @return string
	 */
	public function decrypt_password ( $text ) {
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
		$ciphertext_dec = base64_decode($text);

		$iv_dec = substr($ciphertext_dec, 0, $iv_size);

		$ciphertext_dec = substr($ciphertext_dec, $iv_size);

		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, base64_decode($this->config->item("encrypt_key")), $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec), chr(0));
	}

	/**
	 * Removes a twitter account from the database
	 * @param  integer $id The database id of the account
	 * @return boolean
	 */
	public function delete_twitter_account ( $id ) {
		$this->db->where(array(
			"id" => $id
		))->delete("twitter_users");

		return true;
	}

	/**
	 * Checks if a row exists
	 * @param  string $table The table to look in
	 * @param  array $where The where clause
	 * @return boolean        True means the row exists
	 */
	public function exists ( $table, $where ) {
		$query = $this->db->where($where)->get($table);

		return ( $query->num_rows() > 0 ) ? true : false;
	}

	/**
	 * Returns the first row of the query
	 * @param  string $table The table to select from
	 * @param  array $where The query
	 * @return object
	 */
	public function select ( $table, $where ) {
		$query = $this->db->where($where)->get($table);

		if ( ! $query->num_rows() ) {
			return false;
		}

		return $query->row();
	}

	/**
	 * Fetches a list of all the twitter users
	 * @return array
	 */
	public function get_twitter_users () {
		$query = $this->db->select("username, id")->get("twitter_users");

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$list[$row->username] = $row;
		}

		return $list;
	}
}