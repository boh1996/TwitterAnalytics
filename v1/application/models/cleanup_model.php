<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage User Analytics Viewer
 * @license Microsoft Reference License
 * @version 1.0
 * @filesource
 * @uses Base_model Uses the base model to do simple operations
 */
class Cleanup_model extends Base_model {

	public function __construct () {
		parent::__construct();
	}

	/**
	 *    Removes data older then the allowed
	 *
	 *    @param array $databases     The databases to cleanup from
	 *    @param integer $max_lift_time The max amount in seconds data are allowed to be stored
	 *
	 */
	public function cleanup_databases ( $databases, $max_lift_time ) {
		foreach ( $databases as $database) {
			$this->db->from($database)->where(array(
				"created_at <" => time() - $max_lift_time
			))->delete();
		}
	}
}
?>