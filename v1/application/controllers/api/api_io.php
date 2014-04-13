<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/api/T_API_Controller.php');

/**
 *
 * The IO Controller/Endpoint
 *
 * @uses 			API Controller
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Bo Thomsen
 * @version 		1.0
 */
class API_IO extends T_API_Controller {

	public function __construct () {
		parent::__construct();
		$this->load->model("base_model");
		$this->load->model("data_io_model");
	}

	/**
	 *    Exports the requested data set to one of the supported filetypes
	 */
	public function export_get () {
		$filetype = $this->get("filetype");
		$table = $this->get("table");
		$property = $this->get("property");
		$filename = $this->get("filename");

		$where = null;

		if ( $this->get("category") ) {
			$where = array("category" => $this->get("category"));
		}

		switch ( $filetype ) {
			case 'csv':
				$list = $this->base_model->get_list_property($table, $property, $where);
				header('Content-type: text/csv');
				header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
				echo $this->data_io_model->export_csv($list);
				break;

			case 'json':
				$list = $this->base_model->get_list($table, $where);
				header('Content-type: application/json');
				header('Content-Disposition: attachment; filename="' . $filename . '.json"');
				echo $this->data_io_model->export_json($list);
				break;

			case 'txt':
				$list = $this->base_model->get_list_property($table, $property, $where);
				header('Content-type: text/plain');
				header('Content-Disposition: attachment; filename="' . $filename . '.txt"');
				echo $this->data_io_model->export_csv($list, "\r\n");
				break;

			case 'xml':
				$list = $this->base_model->get_list($table, $where);
				header('Content-type: application/xml');
				header('Content-Disposition: attachment; filename="' . $filename . '.xml"');
				echo $this->data_io_model->export_xml($list);
				break;

		}
	}

	public function import_post () {
		if ( $this->file("file") === false ) {
			$this->response(400);
		}

		$fileArray = $this->file("file");

		if ( ! isset($fileArray["tmp_name"]) || empty($fileArray["tmp_name"]) ) {
			$this->response(400);
		}

		$file = file_get_contents($fileArray["tmp_name"]);
		$table = $this->get("table");
		$property = $this->get("property");
		$filetype = $this->get("filetype");

		switch ( $filetype ) {
			case 'csv':
				if ( $this->data_io_model->import_csv($file, $table, $property) ) {
					redirect($this->post("url"));
				}
				break;

			case 'txt':
				if ( $this->data_io_model->import_txt($file, $table, $property) ) {
					redirect($this->post("url"));
				}
				break;

		}
	}
}
?>