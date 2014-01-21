<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage Page Data Model
 * @license Microsoft Reference License
 * @version 1.0
 * @filesource
 * @uses Base_model Uses the base model to do simple operations
 */
class Page_model extends Base_model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 *    Fetches a list of pages
	 *
	 *    @param [type] $where [description]
	 *
	 *    @return [type] [description]
	 */
	/*public function get_statistic_pages ( $where = null ) {
		if ( ! is_null($where) && is_array($where) ) {
			$this->db->where($where);
		}

		$this->db->from("statistic_pages");
		$query = $this->db->get();

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$list[$row->key] = $row;
		}

		return $list;
	}*/

	/**
	 *    Recieves the page that matches the search
	 *
	 *    @param stirng|integer $value The row id(integer) or the key name(string)
	 *
	 *    @return Object The database row
	 */
	public function get_statistic_page ( $value ) {
		if ( is_integer($value) ) {
			$key = "id";
		} else {
			$key = "name";
		}

		$query = $this->db->where(array(
			$key => $value
		))->get("statistic_pages");

		if ( ! $query->num_rows() ) return false;

		return $query->row();
	}
}