<?php
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