<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage Page System
 * @license Microsoft Reference License
 * @version 1.0
 * @filesource
 */
class Page extends CI_Controller {

	public function get_page ( $unique ) {
		$this->load->model("page_model");
		$page = $this->page_model->get_statistic_page($unique);

		if ( $page === false ) {
			show_404();
			return;
		}

		if ( $page->login == "true" && $this->user_control->is_signed_in() === false ) {
			redirect($this->user_control->CheckHTTPS(base_url() . "sign_in"));
		}

		$this->lang->load("common");
		$this->lang->load("user");

		$this->load->model("settings_model");

		$intervals = $this->settings_model->get_intervals(true);

		$data = array(
			"current_section" => "user",
			"translations" => json_encode($this->lang->export()),
			"page_string" => $unique,
			"intervals" => $intervals,
			"page" => $page
		);

		$this->load->view("page_view", $this->user_control->ControllerInfo($data));
	}
}
?>