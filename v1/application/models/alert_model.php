<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage Alert Object
 * @license Microsoft Reference License
 * @version 1.0
 * @extends Base_model
 * @filesource
 */
class Alert_model extends Base_model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 * Deletes an alert string
	 * @param  integer $id The alert string id
	 * @return boolean
	 */
	public function delete ( $id ) {
		$this->db->where(array(
			"id" => $id
		))->delete("alert_strings");

		return true;
	}
}