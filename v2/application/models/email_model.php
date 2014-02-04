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

		$this->load->helper('email');

		mail(implode(",", $recievers), $settings["subject"], wordwrap($settings["message"], 70, "\r\n"), "From: " . $settings["sender_email"]);
	}

	/**
	 *    Returns if the selected types notifications are turend on
	 *
	 *    @param string $type "increase" or "decrease"
	 *
	 *    @return boolean
	 */
	public function mail_type_on ( $type ) {
		$this->load->model("settings_model");

		if ( $type == "increase" ) {
			return $this->settings_model->fetch_setting("setting_email_increase_alert", true, "email");
		} else {
			return $this->settings_model->fetch_setting("setting_email_decrease_alert", true, "email");
		}
	}

	/**
	 *    Fetches the calculated data and decides if a mail should be send,
	 *    and calls the function that sends the mail
	 *
	 *    @param integer $interval The time between the newest and the next one
	 *    @param integer $page_id  The page to search tweets for
	 *
	 *    @return boolean
	 */
	public function process ( $interval, $page_id ) {
		$this->load->model("statistic_model");
		$this->load->model("page_model");
		$this->load->model("settings_model");
		$calculations = $this->statistic_model->tweets_in_ranges_sum($this->statistic_model->create_time_ranges($interval, 2, time(), array(
			"newest",
			"second"
		)), $page_id);
		$page_id = (int)$page_id;
		$difference = $calculations["newest"] - $calculations["second"];

		if ( $difference == 0 or $calculations["second"] == 0 ) {
			return false;
		}

		$percent_change = ($difference / $calculations["second"]) * 100;
		$page = $this->page_model->get_statistic_page($page_id);
		$min_change = $page->email_change_value;

		$type = "decrease";

		$settings = array(
			"change_value" => $percent_change,
			"time" => time(),
			"tweet_count_now" => $calculations["newest"],
			"tweet_count_last" => $calculations["second"],
			"page_name" => $page->name,
			"page_url" => $this->config->item("base_url") . "page/" . $page->id
		);

		if ( $percent_change > 0 ) {
			$type = "increase";
		}

		if ( $percent_change == 0 ) {
			return false;
		}

		if ( $calculations["second"] == 0 ) {
			if ( abs($percent_change) >= $this->settings_model->fetch_setting("setting_email_zero_minimum_change_amount", 200, "email") and $this->mail_type_on($type) ) {
				$this->create_message($settings, $type);
			}
		} else {
			if ( abs($percent_change) > $min_change and $this->mail_type_on($type) ) {
				$this->create_message($settings, $type);
			}
		}
	}

	/**
	 *    Creates the message text parts
	 *
	 *    @param array $settings The mustache variables
	 *    @param string $type     The message type
	 *
	 */
	public function create_message ( $settings, $type ) {
		$this->load->file("application/libraries/mustache.php");

		$message = $this->settings_model->fetch_setting("setting_email_message", "", "email");
		$alt_message = $this->settings_model->fetch_setting("setting_email_alt_message", "", "email");
		$subject = $this->settings_model->fetch_setting("setting_email_subject", "", "email");

		$mustache = new Mustache;

		$variables = $this->variables(array_merge($settings));

		$parts = array(
			"message" => $mustache->render($message, $variables),
			"alt_message" => $mustache->render($alt_message, $variables),
			"subject" => $mustache->render($subject, $variables),
			"type" => $type
		);

		$parts = $this->variables($parts);

		$this->send_email($parts);
	}
}
?>