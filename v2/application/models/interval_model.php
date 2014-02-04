<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage User Control
 * @license Microsoft Reference License
 * @extends Base_model
 * @version 1.0
 * @filesource
 */
class Interval_model extends Base_model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 *    Change Interval data
	 *
	 *    @param string $key  The key to change
	 *    @param array $data The data to insert / Update with
	 *
	 */
	public function change ( $key, $data ) {

		if ( $this->exists("statistic_view_intervals", array("key" => $key)) ) {
			$this->update_element("statistic_view_intervals", $data, array("key" => $key));
		} else {
			$data["key"] = $key;
			$this->db->insert("statistic_view_intervals", $data);
		}
	}

	/**
	 *    Deletes an interval
	 *
	 *    @param string $key The interval to delete
	 *
	 */
	public function delete ( $key ) {
		$this->db->delete("statistic_view_intervals", array(
			"key" => $key
		));
	}

	/**
	 *    Fetches an interval item
	 *
	 *    @param string $key The interval to fetch
	 *
	 *    @return onject
	 */
	public function fetch ( $key ) {
		$query = $this->db->from("statistic_view_intervals")->where(array(
			"key" => $key
		))->get();

		if ( ! $query->num_rows() ) return false;

		return $query->row();
	}
}
?>