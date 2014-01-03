<?php
class Status_model extends Base_model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 * Returns a list of the newest errors
	 * @param  integer $limit The number of errors to return
	 * @return array<Object>
	 */
	public function get_errors ( $limit = 10 ) {
		$query = $this->db->limit($limit)->order_by("created_at", "DESC")->get("errors");

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$list[] = $row;
		}

		return $list;
	}
}