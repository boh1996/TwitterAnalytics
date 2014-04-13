<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Data
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage Data_IO
 * @license Microsoft Reference License
 * @extends Base_model
 * @version 1.0
 * @filesource
 */
class Email_model extends Base_model {
	public function __construct () {
		parent::__construct();
	}

	public function import_csv ( $text, $table, $property ) {
		$t1 = explode(";", $text);
		$t2 = explode(", ", $text);
		$t3 = explode(",", $text);

		if ( is_array($t1) && count($t1) > 0 ) {

		} else if ( is_array($t2) && count($t2) > 0 ) {

		} else if ( is_array($t3) && count($t3) > 0 ) {

		} else {
			return false;
		}
	}

	protected function _import ( $data, $table, $property ) {
		foreach ($variable as $key => $value) {
			# code...
		}
	}

	public function export_csv ( $rows, $delemiter = ";" ) {
		return implode($delemiter, $rows);
	}

	/**
	 *    Exports an array of elements into json,
	 *    where each row is placed inside a specified property
	 *
	 *    @param arrays $rows     The list of rows
	 *    @param string $property The property name
	 *
	 *    @return string
	 */
	public function export_json ( $rows, $property ) {
		$data = array();

		foreach ( $rows as $row ) {
			$data[] = array( $property => $row );
		}

		return json_encode($data);
	}
}
?>