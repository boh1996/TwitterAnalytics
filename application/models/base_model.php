<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage Database Operations
 * @extends CI_Model
 * @license Microsoft Reference License
 * @version 1.0
 * @filesource
 */
class Base_model extends CI_Model {

	public function __construct () {
		parent::__construct();
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
	 * Performs an update query
	 * @param  string $tabel The database tabel
	 * @param  array $data  The rows and new data
	 * @param  array $where The where caluse
	 */
	public function update_element ( $tabel, $data, $where ) {
		$this->db->where($where)->update($tabel, $where);
	}

	/**
	 * Fetches a list of objects
	 * @param  string $table The database tabel to fetch from
	 * @param  array $where An optional where clause
	 * @param  integer $limit The max number of rows to be returned
	 * @return boolean|array<Object>
	 */
	public function get_list ( $table, $where = null, $limit = null ) {
		if ( ! is_null($limit) ) {
			$this->db->limit($limit);
		}

		if ( ! is_null($where) ) {
			$this->db->where($where);
		}

		$query = $this->db->get($table);

		$list = array();

		if ( ! $query->num_rows() ) return false;

		foreach ( $query->result() as $row ) {
			$list[] = $row;
		}

		return $list;
	}

	/**
	 * Fetches a key from an unknown elemenbt
	 * @param  Object|Array $element The element
	 * @param  string $key     The key to fetch
	 * @return value
	 */
	protected function _fetch ( $element, $key ) {
		if ( is_object($element) ) {
			return $element->{$key};
		} else {
			return $element[$key];
		}
	}

	/**
	 * Checks if an  element exists
	 * @param  string $table   The corresponding table
	 * @param  Array|Object $element The element
	 * @param  array  $unique  An array of unique rows
	 * @param boolean $multiple If the update will result in multiple rows
	 * @return boolean
	 */
	public function element_exist ( $table, $element, $unique = array("id"), &$multiple ) {
		if ( is_array($unique) ) {
			foreach ( $unique as $key ) {
				if ( ( is_object($element) && isset($element->{$key}) ) || isset($element[$key]) ) {
					if ( $this->exists($table, array($key => $this->_fetch($element, $key))) ) {
						return true;
					}
				} else {
					$multiple = true;
				}
			}
		}

		return false;
	}

	/**
	 * Deletes an object
	 * @param  integer $id The object id
	 * @param string $table The object table
	 * @return boolean
	 */
	public function delete ( $id, $table ) {
		$this->db->where(array(
			"id" => $id
		))->delete($table);

		return true;
	}

	/**
	 * Unsets all values in the unique array
	 * @param  Object|Array $element The element
	 * @param  Array $unique  The keys to unset
	 */
	protected function _unset_unique ( $element, $unique = array() ) {
		if ( is_array($unique) ) {
			foreach ( $unique as $key ) {
				if ( ( is_object($element) && isset($element->{$key}) ) || isset($element[$key]) ) {
					if ( is_object($element) ) {
						unset($element->{$key});
					} else {
						unset($element[$key]);
					}
				}
			}
		}

		return $element;
	}

	/**
	 * Creates a list of value taken from an element
	 * @param  Array|Object $element The element
	 * @param  array $unique  The keys
	 * @return array
	 */
	protected function _create_unique_pair ( $element, $unique ) {
		$pair = array();

		if ( is_array($unique) ) {
			foreach ( $unique as $key ) {
				$pair[$key] = $this->_fetch($element, $key);
			}
		}

		return $pair;
	}

	/**
	 * Sets a value to an element
	 * @param Object|Array $element The element
	 * @param string $key     The key
	 * @param Any $value   The value
	 */
	protected function _set ( $element, $key, $value ) {
		if ( is_object($element) ) {
			$element->{$key} = $value;
		} else {
			$element[$key] = $value;
		}

		return $element;
	}

	/**
	 * Saves a list of objects/elements to a database table
	 * @param  string $table  The table to save in
	 * @param  array $list   The data to save
	 * @param  array  $unique Unique rows
	 * @return boolean
	 */
	public function save_list ( $table, $list, $unique = array("id") ) {
		foreach ( $list as $element ) {
			if ( $this->element_exist($table, $element, $unique, $multiple) ) {
				if ( ! $multiple ) {
					$element = $this->_set($element, "updated_at", time());
					$this->db->where($this->_create_unique_pair($element, array("id")))->update($table, $element);
				}
			} else{
				$element = $this->_set($element, "updated_at", time());
				$element = $this->_set($element, "created_at", time());
				$this->db->insert($table, $element);
			}
		}

		return true;
	}

	/**
	 * Retrieves the id of a row
	 * @param  string $table The table to select from
	 * @param  array $where The where clause
	 * @return boolean|integer
	 */
	public function get_id ( $table, $where ) {
		$query = $this->db->select("id")->where($where)->get($table);

		if ( $query->num_rows() > 0 ) {
			$row = $query->row();

			return $row->id;
		} else {
			return false;
		}
	}
}