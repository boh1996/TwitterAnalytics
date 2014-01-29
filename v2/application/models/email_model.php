<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright mettesolsikke@live.dk, 2014
 * @subpackage Email
 * @license Microsoft Reference License
 * @extends Base_model
 * @version 1.0
 * @filesource
 */
class Email_model extends Base_model {

	public function __construct () {
		parent::__construct();

		$this->load->library("email");
		$this->load->model("settings_model");
	}

	/**
	 *    Returns a list of the assigned recivers of the email
	 *
	 *    @param string $type Message type, "increase" or "decline"
	 *
	 *    @return array<String>
	 */
	public function get_email_recievers ( $type = "increase" ) {
		$query = $this->db->get("email_alert_recievers");

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$list[] = $row->value;
		}

		return $list;
	}

	/**
	 *    Returns a list of the BCC emails
	 *
	 *    @param string $type Message type, "increase" or "decline"
	 *
	 *    @return array<String>
	 */
	public function get_bccs ( $type = "increase" ) {
		$query = $this->db->get("email_bccs");

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$list[] = $row->value;
		}

		return $list;
	}

	/**
	 *    Returns a list of the CC emails
	 *
	 *    @param string $type Message type, "increase" or "decline"
	 *
	 *    @return array<String>
	 */
	public function get_ccs ( $type = "increase" ) {
		$query = $this->db->get("email_ccs");

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			$list[] = $row->value;
		}

		return $list;
	}

	/**
	 *    Merges the custom variables with the default variables
	 *
	 *    @param array $custom A list of custom variables
	 *
	 *    @return array
	 */
	public function variables ( $custom = array() ) {
		$default = array(
			"base_url" => $this->config->item("base_url"),
			"asset_url" => $this->config->item("asset_url"),
			"time" => time(),
			"sender_email" => $this->settings_model->fetch_setting("setting_email_sender", "support@illution.dk", "email"),
		);

		return array_merge($custom, $default);
	}

	/**
	 *    Sends the actual email, using the CodeIgniter email framework
	 *
	 *    @param array $settings An array of settings an the actual message content etc
	 *
	 *    @return string Debug info
	 *
	 */
	public function send_email ( $settings ) {
		$recievers = $this->get_email_recievers($settings["type"]);

		if ( $recievers === false ) return false;

		$this->email->from($recievers);

		$bccs = $this->get_bccs($settings["type"]);

		if ( $bccs !== false ) {
			$this->email->bcc($bccs);
		}

		$ccs = $this->get_ccs($settings["type"]);

		if ( $ccs !== false ) {
			$this->email->cc($settings["type"]);
		}

		$this->email->subject($settings["subject"]);

		$this->email->message($settings["message"]);

		$this->email->set_alt_message($settings["alt_message"]);

		if ( isset($settings["attachments"]) ) {
			if ( is_array($settings["attachment"]) ) {
				foreach ( $settings["attachment"] as $attachment ) {
					$this->email->attach($attachment);
				}
			} else {
				$this->email->attach($settings["attachments"]);
			}
		}

		$this->email->send();

		return $this->email->send_debugger();
	}

	public function process ( $interval, $page_id ) {
		$this->load->model("statistic_model");
		$calculations = $this->statistic_model->tweets_in_ranges_sum($this->statistic_model->create_time_ranges($interval, 2, time(), array(
			"newest",
			"second"
		)), $page_id);
		$difference = $calculations["newest"] - $calculations["second"];
		$percent_change = ($difference / $calculations["second"]) * 100;

		$type = "negative";

		if ( $percent_change > 0 ) {
			$type = "possitve";
		}

		echo $type;

		/*if ( $calculations["second"] == 0 ) {

		} else {

		}*/

		// If last is 0, then change need to be {{zero_min_change_amount}} % + to trigger
	}
}
?>