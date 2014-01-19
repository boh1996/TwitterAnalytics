<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage View Control
 * @license Microsoft Reference License
 * @extends CI_Model
 * @version 1.0
 * @filesource
 */
class View_model extends CI_Model {

	/**
	 * An internal variable storing the pages
	 * @var array
	 */
	public $pages = array();

	public function __construct () {
		parent::__construct();
		$this->load->config("pages");
		$this->pages = $this->config->item("pages");
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
			$row->language_key = $this->pages[$row->page]["language_key"];
			$row->section = $this->pages[$row->page]["section"];
			$row->admin_language_key = $this->pages[$row->page]["admin_language_key"];
			$row->url = $this->pages[$row->page]["url"];
			$row->type = $this->pages[$row->page]["type"];
			$row->header_language_key = $this->pages[$row->page]["header_language_key"];
			$list[$row->page] = $row;
		}

		foreach ( $this->pages as $key => $array ) {
			if ( ! isset($list[$key]) ) {
				$list[$key] = (object) $array;
			}
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
			if ( isset($this->pages[$row->page]) ) {
				$row->language_key = $this->pages[$row->page]["language_key"];
				$row->section = $this->pages[$row->page]["section"];
				$row->admin_language_key = $this->pages[$row->page]["admin_language_key"];
				$row->url = $this->pages[$row->page]["url"];
				$row->type = $this->pages[$row->page]["type"];
				$row->header_language_key = $this->pages[$row->page]["header_language_key"];

				$list[$row->page] = $row;
			}
		}

		foreach ( $this->pages as $key => $array ) {
			if ( ! isset($list[$key]) ) {
				$list[$key] = (object) $array;
			}
		}

		return $list;
	}

	/**
	 * Retrieves all the pages and adds them to a list, and the headers in another
	 * @return array
	 */
	public function get_pages_ordered_in_sections () {
		$pages = $this->get_pages();

		if ( ! is_array($pages) ) {
			return false;
		}

		$list = array();
		$headers = array();

		foreach ( $pages as $row ) {
			$row->language_key = $this->pages[$row->page]["language_key"];
			$row->section = $this->pages[$row->page]["section"];
			$row->admin_language_key = $this->pages[$row->page]["admin_language_key"];
			$row->url = $this->pages[$row->page]["url"];
			$row->type = $this->pages[$row->page]["type"];
			$row->header_language_key = $this->pages[$row->page]["header_language_key"];

			if ( ! isset($list[$row->section]) ) {
				$list[$row->section] = array();
			}

			$list[$row->section][$row->page] = $row;

			if ( $row->type == "header" ) {
				$headers[$row->section] = $row;
			}
		}

		foreach ( $this->pages as $key => $array ) {
			if ( ! isset($list[$array["section"]][$key]) ) {
				$list[$array["section"]][$key] = (object) $array;
			}

			if ( $array["type"] == "header" && ! isset($headers[$array["section"]]) ) {
				$headers[$row->section] = (object) $array;
			}
		}

		return array(
			"headers" => $headers,
			"pages" => $list
		);
	}

}