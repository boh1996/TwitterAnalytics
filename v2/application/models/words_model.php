<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage Scraper
 * @license Microsoft Reference License
 * @extends Base_model
 * @version 1.0
 * @filesource
 */
class Words_model extends Base_model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 *    Fetches the list of strings, grouped by their page_id
	 *
	 *    @return array<Object>
	 */
	public function get_strings_grouped_in_pages () {
		$query = $this->db->query('SELECT
			    statistic_page_id,
			    GROUP_CONCAT(value, "@|", id, "@|", category SEPARATOR "@;") AS strings
			FROM statistic_strings
			GROUP BY statistic_page_id'
		);

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$row->strings = explode("@;", $row->strings);

			foreach ( $row->strings as $key => $string ) {
				$row->strings[$key] = explode("@|", $string);
			}

			$list[$row->statistic_page_id] = $row;
		}

		return $list;
	}

	/**
	 *    Retrieves a list of pages, with all information
	 *
	 *    @return array<Object>
	 */
	public function get_pages_info () {
		$query = $this->db->query('SELECT
			    id,
			    name,
			    urls,
			    strings,
			    login,
			    embed
			FROM statistic_pages sp
			LEFT JOIN (
			    SELECT
			        statistic_page_id as su_page_id,
			        GROUP_CONCAT(IFNULL(url, "NULL"), "@|", id SEPARATOR "@;") AS urls,
			        url,
			        id as url_id
			    FROM statistic_urls
			    GROUP BY su_page_id
			) url_list ON url_list.su_page_id = sp.id
			LEFT JOIN (
			    SELECT
			    	id as string_id,
			        value as string_value,
			        GROUP_CONCAT(IFNULL(value, "NULL"), "@|", id, "@|", IFNULL(category, "NULL") SEPARATOR "@;") AS strings,
			        category,
			        statistic_page_id as ss_page_id
			    FROM statistic_strings
			    GROUP BY ss_page_id
			) string_list ON string_list.ss_page_id = sp.id'
		);

		if ( ! $query->num_rows() ) return false;

		$this->load->config("categories");
		$config_categories = $this->config->item("categories");

		$list = array();

		foreach ( $query->result() as $row ) {
			$urls = explode("@;", $row->urls);
			$strings_list = explode("@;", $row->strings);

			$row->urls = array();
			$row->strings = array();

			foreach ( $urls as $key => $url ) {
				$url = explode("@|", $url);
				if ( is_array($url) && count($url) > 1 ) {
					$row->urls[$key] = array();
					$row->urls[$key]["url"] = $url[0];
					$row->urls[$key]["id"] = $url[1];
				}
			}

			$strings = array();

			foreach ( $config_categories as $category ) {
				$strings[$category["key"]] = array("strings" => array());
				$strings[$category["key"]]["config"] = $category;
			}

			foreach ( $strings_list as $key => $string ) {
				$string = explode("@|", $string);
				if ( is_array($string) && count($string) > 2 ) {
					$category = $string[2];
					$strings[$category]["strings"][$key] = array();
					$strings[$category]["strings"][$key]["value"] = $string[0];
					$strings[$category]["strings"][$key]["id"] = $string[1];
					$strings[$category]["strings"][$key]["category"] = $string[2];
				}
			}

			$row->strings = $strings;

			$list[$row->id] = $row;
		}

		return $list;
	}
}
?>