<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage User Analytics Viewer
 * @license Microsoft Reference License
 * @version 1.0
 * @filesource
 * @uses Base_model Uses the base model to do simple operations
 */
class Settings_model extends Base_model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 * Returns a settings key
	 * @param  string $key     The settings key
	 * @param  string|integer $default The default value
	 * @param string $section The settings section
	 * @return string|integer|array
	 */
	public function fetch_setting ( $key, $default, $section ) {
		$settings = $this->check_defaults($section, $this->get_settings($section));

		if ( ! isset($settings[$key]) ) return $default;

		return $settings[$key]->value;
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

		array_multisort($list);

		return $list;
	}

	/**
	 * Creates or updates a key in the settings database
	 * @param string $key   The key name
	 * @param string $value The key value
	 * @param string $section The section where the setting belongs
	 */
	public function set_setting ( $key, $value, $section ) {
		if ( $this->exists("settings", array("key" => $key)) ) {
			$this->db->where(array("key" => $key))->update("settings", array(
				"updated_at" => time(),
				"value" => $value,
				"section" => $section
			));
		} else {
			$this->db->insert("settings", array(
				"key" => $key,
				"value" => $value,
				"updated_at" => time(),
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

		$settings = $this->config->item("settings");

		if ( ! is_array($settings) || ( is_array($settings) && count($settings) == 0 ) ) {
			return false;
		}

		foreach ( $settings as $key => $array ) {
			if ( $section === null || ( ! is_null($section) && $array["section"] == $section ) ) {
				if ( ! isset($data[$key]) ) {
					$data[$key] =  (object) $array;
				}

				$data[$key]->language_key = $array["language_key"];
				$data[$key]->placeholder = $array["placeholder"];
				$data[$key]->help_text = $array["help_text"];
				$data[$key]->type = $array["type"];
			}
		}

		if ( $data !== false ) {
			foreach ( $data as $key => $object ) {
				if ( isset( $settings[$key] ) ) {
					if ( $settings[$key]["section"] != $object->section ) {
						$data[$key] = (object) $settings[$key];
						$this->set_setting($key, $object->value, $settings[$key]["section"]);
					}
				} else {
					$this->delete_setting($key);
					unset($data[$key]);
				}
			}

			array_multisort($data);
		}

		return $data;
	}

	/**
	 *    Fetches the list of categories
	 *
	 *    @return array<Object>
	 */
	public function get_categories () {
		$this->load->config("categories");
		$categories = $this->config->item("categories");

		$list = array();

		foreach ( $categories as $key => $array ) {
			$list[$array["key"]] = (object) $array;
		}

		return $list;
	}

	/**
	 *    Returns the intervals, first priority is the db, next is the defaults config
	 *
	 *    @return array
	 */
	public function get_intervals ( $removeInactive = false ) {
		$this->load->helper("array_data");
		$this->load->config("defaults");
		$intervals = $this->config->item("intervals");

		$query = $this->db->get("statistic_view_intervals");

		$defaults = $this->array_elements_to_object($this->get_default_intervals());

		uasort($defaults, function($a, $b)
		{
		    return ( $a->value > $b->value ) ? true : false;
		});

		if ( ! $query->num_rows() ) return $defaults;

		$list = array();

		foreach ( $query->result() as $row ) {
			if ( isset($intervals[$row->key]) ) {
				$row->value = $intervals[$row->key]["value"];
				$row->language_key = $intervals[$row->key]["language_key"];
				$row->name = $this->lang->line($row->language_key);
				$row->default = true;

				$row->name = $this->lang->line($intervals[$row->key]["language_key"]);

				if ( $row->login == "" ) {
					$row->login = $intervals[$row->key]["login"];
				}

				if ( $row->status == "" ) {
					$row->status = $intervals[$row->key]["status"];
				}

				if ( $row->email_change_value == "" ) {
					$row->email_change_value = $intervals[$row->key]["email_change_value"];
				}

				if ( $row->decrease_email == "" ) {
					$row->decrease_email = $intervals[$row->key]["decrease_email"];
				}

				if ( $row->increase_email == "" ) {
					$row->increase_email = $intervals[$row->key]["increase_email"];
				}

				if (  $row->category_difference == "") {
					$row->category_difference = $intervals[$row->key]["category_difference"];
				}

				if ( $row->category_change_value == "" ) {
					$row->category_change_value = $intervals[$row->key]["category_change_value"];
				}

			}

			$list[$row->key] = $row;
		}

		foreach ( $intervals as $key => $array ) {
			if ( ! isset($list[$key]) ) {
				$array["name"] = $this->lang->line($array["language_key"]);
				$array["default"] = true;
				$list[$array["key"]] = (object) $array;
			}
		}

		if ( $removeInactive ) {
			foreach ($list as $key => $object ) {
				if ( $object->status == false || $object->status == 0 ) {
					unset($list[$key]);
				}
			}
		}

		uasort($list, function($a, $b)
		{
		    return ( $a->value > $b->value ) ? true : false;
		});

		return $list;
	}

	/**
	 *    Parses the list of default intervals
	 *
	 *    @return array<Array>
	 */
	public function get_default_intervals () {
		$this->load->helper("array_data");
		$intervals = $this->config->item("intervals");

		foreach ( $intervals as $key => $array ) {
			$intervals[$key]["name"] = $this->lang->line($array["language_key"]);
			$intervals[$key]["default"] = true;
		}

		return $intervals;
	}

	/**
	 *    Loads up a config file, looks in the array key $array,
	 *    loops through the items, and looks through either the sub array or the value,
	 *    and returns if it matches the query or if $multiple is enabled,
	 *    then the items are added to a list and returned.
	 *
	 *    @param string  $file     The config file name
	 *    @param string  $item    The config item name
	 *    @param string  $key      The config item value array key
	 *    @param string  $value    The array->value key whe are looking for
	 *    @param string|boolean|integer|array  $default  The default value
	 *    @param boolean $multiple If multiple items should be returned
	 *
	 *    @return array|string|integer|boolean
	 */
	public function config_array_find ( $file, $item, $key, $value = "", $default = "", $multiple = false ) {
		$this->load->config($file);

		$items = $this->config->item($item);

		$list = array();

		foreach ( $items as $index => $array ) {
			if ( $index == $key && is_array($array) && isset($array[$value]) ) {
				if ( $multiple ) {
					$list[] = $array[$value];
				} else {
					return $array[$value];
				}
			} else if ( $index == $key ) {
				if ( $multiple ) {
					$list[] = $array;
				} else {
					return $array;
				}
			}
		}

		return $list;
	}
}