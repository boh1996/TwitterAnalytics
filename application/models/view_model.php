<?php
class View_model extends CI_Model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 * Retrieves all the pages for a section
	 * @param  String $section The section name
	 * @return array
	 */
	public function get_section_pages ( $section ) {
		$query = $this->db->where(array(
			"section" => $section
		))->get("access_control");

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$list[] = $row;
		}

		return $list;
	}

	/**
	 * Returns all the pages
	 * @return array
	 */
	public function get_pages () {
		$query = $this->db->get("access_control");

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$list[] = $row;
		}

		return $list;
	}

	/**
	 * Retrieves all the pages and adds them to a list, and the headers in another
	 * @return array
	 */
	public function get_pages_ordered_in_sections () {
		$pages = $this->get_pages();

		$list = array();
		$headers = array();

		foreach ( $pages as $row ) {
			if ( ! isset($list[$row->section]) ) {
				$list[$row->section] = array();
			}

			$list[$row->section][] = $row;

			if ( $row->type == "header" ) {
				$headers[$row->section] = $row;
			}
		}

		return array(
			"headers" => $headers,
			"pages" => $list
		);
	}

}