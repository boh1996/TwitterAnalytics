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
}
?>