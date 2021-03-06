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

	/**
	 *    Removes to old data
	 *
	 */
	public function index () {
		$this->load->model("settings_model");
		$data = $this->settings_model->check_defaults("scraper",$this->settings_model->get_settings("scraper"));
		$maxtime = $data["setting_max_lifetime"]->value;

		$databases = array(
			"errors",
			"scraper_runs",
			"history",
			"scrape_statistics",
			"statistic_tweets",
			"statistic_tweet_strings",
			"page_stats",
			"page_tweets",
		);

		$this->load->model("cleanup_model");

		$this->cleanup_model->cleanup_databases($databases, $maxtime);
	}
}