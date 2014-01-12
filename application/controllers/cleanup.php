<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage Cleanup
 * @license Microsoft Reference License
 * @version 1.0
 * @filesource
 */
class Cleanup extends CI_Controller {

	/**
	 * Contructor
	 */
	public function __construct () {
		parent::__construct();
	}

	public function index () {
		$this->load->model("settings_model");
		$maxtime = 
	}

}