<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage User Access Control
 * @license Microsoft Reference License
 * @version 1.0
 * @filesource
 * @extends CI_Model
 */
class Access_model extends CI_Model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 * Checks in the database, if a page requires sign-in
	 * @param  string $page The name of the page
	 * @return boolean
	 */
	public function page_requires_login ( $page ) {
		$this->config->load("login");
		$query = $this->db->from("access_control")->where(array(
			"page" => $page
		))->get();

		if ( ! $query->num_rows() ) {
			return ( $this->config->item("standard_access_control_mode") == "login" ) ? true : false;
		}

		$row = $query->row();

		return ( $row->mode == "login" ) ? true : false;
	}

	/**
	 * Retrieves all the pages
	 * @return Array
	 */
	public function get_pages () {
		$query = $this->db->get("access_control");

		$list = array();

		if ( ! $query->num_rows() ) return false;

		foreach ( $query->result() as $row ) {
			$list[] = $row;
		}

		return $list;
	}

	/**
	 * Updates the page access control data
	 * @param  array $pages The new data
	 */
	public function save_pages ( $pages ) {
		foreach ( $pages as $index => $page ) {
			if ( ! in_array($page["mode"], array("nologin", "login")) ) {
				unset($pages[$index]);
			}
		}

		if ( count($pages) == 0 ) {
			return false;
		}

		$this->db->update_batch("access_control", $pages, "page");

		return true;
	}
}
?>