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
	 *    Deletes a pages and the associated URLs and Strings
	 *
	 *    @param integer $page_id The id of the page
	 *
	 */
	public function delete_page ( $page_id ) {
		$this->db->delete("statistic_pages", array(
			"id" => $page_id
		));

		$this->db->delete("statistic_strings", array(
			"statistic_page_id" => $page_id
		));

		$this->db->delete("statistic_urls", array(
			"statistic_page_id" => $page_id
		));
	}

	/**
	 *    Recieves the page that matches the search
	 *
	 *    @param stirng|integer $value The row id(integer) or the key name(string)
	 *
	 *    @return Object The database row
	 */
	public function get_statistic_page ( $value ) {
		if ( is_numeric($value) ) {
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

	/**
	 *    Updates the list of strings
	 *
	 *    @param array $strings The list of strings to save
	 *    @param integer $page_id The page it's associated with
	 *
	 */
	public function save_strings ( $strings, $page_id ) {
		foreach ( $strings as $string ) {
			if ( isset($string["id"]) ) {
				$this->db->where(array(
					"id" => $string["id"]
				))->update("statistic_strings", array(
					"value" => $string["string"],
					"category" => $string["category"],
					"statistic_page_id" => $page_id
				));
			} else {
				$this->db->insert("statistic_strings", array(
					"value" => $string["string"],
					"category" => $string["category"],
					"statistic_page_id" => $page_id
				));
			}
		}
	}

	/**
	 *    Updates the list of urls
	 *
	 *    @param array $urls    The list of URLs
	 *    @param integer $page_id The page it's associated with
	 *
	 */
	public function save_urls ( $urls, $page_id ) {
		foreach ( $urls as $url ) {
			if ( isset($url["id"]) ) {
				$this->db->where(array(
					"id" => $url["id"]
				))->update("statistic_urls", array(
					"url" => $url["url"],
					"statistic_page_id" => $page_id
				));
			} else {
				$this->db->insert("statistic_urls", array(
					"url" => $url["url"],
					"statistic_page_id" => $page_id
				));
			}
		}
	}

	/**
	 *    Saves a list of pages
	 *
	 *    @param array $pages The list of pages
	 *
	 */
	public function save_pages ( $pages ) {
		foreach ( $pages as $page ) {
			if ( isset($page["id"]) && $this->exists("statistic_pages", array(
				"id" => $page["id"]
			)) ) {
				$this->db->where(array(
					"id" => $page["id"]
				));
				$this->db->update("statistic_pages",array(
					"name" => ( isset($page["name"]) ) ? $page["name"] : "",
					"login" => ( isset($page["login"]) ) ? $page["login"] : "",
					"embed" => ( isset($page["embed"]) ) ? $page["embed"] : "",
					"exact_match" => ( isset($page["exact_match"]) ) ? $page["exact_match"] : false,
				));
				$this->save_strings($page["strings"], $page["id"]);
				$this->save_urls($page["urls"], $page["id"]);
			} else {
				$id = $this->insert("statistic_pages",array(
					"name" => ( isset($page["name"]) ) ? $page["name"] : "",
					"login" => ( isset($page["login"]) ) ? $page["login"] : "",
					"embed" => ( isset($page["embed"]) ) ? $page["embed"] : "",
					"exact_match" => ( isset($page["exact_match"]) ) ? $page["exact_match"] : false,
				));
				$this->save_strings($page["strings"], $id);
				$this->save_urls($page["urls"], $id);
			}
		}
	}
}