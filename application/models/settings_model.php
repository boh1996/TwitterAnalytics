<?php
class Settings_model extends Base_model {

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
	 * Returns a list of settings, use the parameters to control which settings are returned
	 * @param  string $section The section to return settings for
	 * @param  array $keys    A list of keys to return
	 * @return array<Object>
	 */
	public function get_settings ( $section = null, $keys = null ) {
		if ( ! is_null($section) ) {
			$this->db->where(array(
				"section" => $section
			));
		}

		if ( ! is_null($keys) ) {
			$this->where_in("key", $keys);
		}

		$query = $this->db->get("settings");

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$list[$row->key] = $row;
		}

		return $list;
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

	/**
	 * Creates or updates a key in the settings database
	 * @param string $key   The key name
	 * @param string $value The key value
	 * @param string $section The section where the setting belongs
	 * @param string $type The data type
	 */
	public function set_setting ( $key, $value, $section, $type = "text" ) {
		if ( $this->exists("settings", array("key" => $key)) ) {
			$this->db->where(array("key" => $key))->update("settings", array(
				"updated_at" => time(),
				"value" => $value,
				"type" => $type,
				"section" => $section
			));
		} else {
			$this->db->insert("settings", array(
				"key" => $key,
				"value" => $value,
				"updated_at" => time(),
				"type" => $type,
				"section" => $section
			));
		}

		return true;
	}

	/**
	 * Retrieves a settings value
	 * @param  string $key The key to retrieve
	 * @return boolean|object
	 */
	public function get_setting ( $key ) {
		return $this->select("settings", array(
			"key" => $key
		));
	}

	/**
	 * Removes a setting
	 * @param  string $key The key to remove
	 */
	public function delete_setting ( $key ) {
		$this->db->where(array(
			"key" => $key
		))->delete("settings");
	}

	/**
	 * Matches the user settings, with the default settings
	 * @param  string $section The section to check for
	 * @param   $data    The user data
	 * @return array<Objet>
	 */
	public function check_defaults ( $section = null, $data ) {
		$this->config->load("defaults");

		foreach ( $this->config->item("settings") as $key => $array ) {
			if ( $section === null || ( ! is_null($section) && $array["section"] == $section ) ) {
				if ( ! isset($data[$key]) ) {
					$data[$key] =  (object) $array;
				}

				$data[$key]->language_key = $array["language_key"];
				$data[$key]->placeholder = $array["placeholder"];
			}
		}

		return $data;
	}
}