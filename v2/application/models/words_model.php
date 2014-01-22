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
			    GROUP_CONCAT(value, "@|", id SEPARATOR "@;") AS strings
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
			    email_change_value,
			    embed
			FROM statistic_pages sp
			INNER JOIN (
			    SELECT
			        statistic_page_id as su_page_id,
			        GROUP_CONCAT(IFNULL(url, "NULL"), "@|", id SEPARATOR "@;") AS urls,
			        url,
			        id as url_id
			    FROM statistic_urls
			    GROUP BY su_page_id
			) url_list ON url_list.su_page_id = sp.id
			INNER JOIN (
			    SELECT
			        value as string_value,
			        GROUP_CONCAT(IFNULL(value, "NULL"), "@|", id, "@|", IFNULL(category, "NULL"), "@|", IFNULL(color, "NULL") SEPARATOR "@;") AS strings,
			        category,
			        statistic_page_id as ss_page_id,
			        color
			    FROM statistic_strings
			    GROUP BY ss_page_id
			) string_list ON string_list.ss_page_id = sp.id'
		);

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$row->urls = explode("@;", $row->urls);
			$row->strings = explode("@;", $row->strings);

			foreach ( $row->urls as $key => $url ) {
				$row->urls[$key] = explode("@|", $url);
				$row->urls[$key]["url"] = $row->urls[$key][0];
				$row->urls[$key]["id"] = $row->urls[$key][1];
			}

			foreach ( $row->strings as $key => $string ) {
				$row->strings[$key] = explode("@|", $string);
				$row->strings[$key]["value"] = $row->strings[$key][0];
				$row->strings[$key]["id"] = $row->strings[$key][1];
				$row->strings[$key]["category"] = $row->strings[$key][2];
				$row->strings[$key]["color"] = $row->strings[$key][3];
			}

			$list[$row->id] = $row;
		}

		return $list;
	}
}
?>