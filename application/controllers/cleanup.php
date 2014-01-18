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
			"scrapers",
			"errros",
			"scraper_runs",
			"history",
			"scraper_statistics",
			"tweet_words",
			"tweets",
			"tweet_hashtags",
			"tweet_alert_strings",
			"tweet_mentions",
			"tweet_urls",
			"tweet_media"
		);

		$this->load->model("cleanup_model");

		$this->cleanup_model->cleanup_databases($databases, $maxtime);
	}
}