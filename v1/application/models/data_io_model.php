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
class Data_io_model extends Base_model {
	public function __construct () {
		parent::__construct();
	}

	public function import_csv ( $text, $table, $property ) {
		$t1 = explode(";", $text);
		$t2 = explode(", ", $text);
		$t3 = explode(",", $text);

		if ( is_array($t1) && count($t1) > 0 ) {
			$this->_import($t1, $table, $property);
		} else if ( is_array($t2) && count($t2) > 0 ) {
			$this->_import($t2, $table, $property);
		} else if ( is_array($t3) && count($t3) > 0 ) {
			$this->_import($t3, $table, $property);
		} else {
			return false;
		}

		return true;
	}

	public function import_txt ( $text, $table, $property ) {
		$t1 = array_filter(explode("\r\n", $text));
		$t2 = array_filter(explode("\n", $text));

		$result = array();

		if ( ! is_array($t1) && ! is_array($t2) ) {
			return false;
		}

		if ( count($t1) == 0 && count($t2) == 0 ) {
			return false;
		}

		if ( is_array($t1) && is_array($t2) && count($t1) > 0 && count($t2) > 0 ) {
			if ( count($t1) > count($t2) ) {
				$result = $t1;
			} else {
				$result = $t2;
			}
		} else if ( is_array($t1) & count($t1) > 0 ) {
			$result = $t1;
		} else if ( is_array($t2) && count($t2) > 0 ) {
			$result = $t2;
		}

		$this->_import($result, $table, $property);

		return true;
	}

	protected function _import ( $data, $table, $property ) {
		$rows = array();

		foreach ( $data as $row ) {
			if ( ! $this->exists($table, array($property => $row)) && ! empty($row) ) {
				$element = array($property => $row);

				if ( isset($_GET["category"]) ) {
					$element["category"] = $_GET["category"];
				}

				$rows[] = $element;
			}
		}

		if ( is_array($rows) && count($rows) > 0 ) {
			$this->db->insert_batch($table, $rows);
			return true;
		}

		return false;
	}

	/**
	 *    Implodes an array with the delemiter
	 *
	 *    @param Array $rows      The rows to implode
	 *    @param string $delemiter The delemiter to impldoe the collection with
	 *
	 *    @return string
	 */
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
	public function export_json ( $rows, $property = null ) {
		$data = array();

		if ( ! is_null($property) ) {
			foreach ( $rows as $row ) {
				$data[] = array( $property => $row );
			}

			return json_encode($data);
		} else {
			return json_encode($rows);
		}
	}

	/**
	 *    Turns the array data into xml
	 *
	 *    @param array $rows The array to export
	 *
	 *    @return string
	 */
	public function export_xml ( $rows) {
		$xml = new SimpleXMLElement('<root/>');
		foreach ( $rows as $key => $row ) {
			$element = $xml->addChild("element");
			$this->array_to_xml($row, $element);
		}

		return $xml->asXML();
	}

	/**
	 *    Converts an arary to xml
	 *
	 *    @param array $arr Array data
	 *    @param SimpleXMLElement $xml
	 *
	 *    @return SimpleXMLElement
	 */
	public function array_to_xml ( $arr, $xml = null ) {

		foreach ($arr as $k => $v) {
	        is_array($v)
	            ? array_to_xml($v, $xml->addChild($k))
	            : $xml->addChild($k, htmlspecialchars($v));
	    }

	    return $xml;
	}
}
?>