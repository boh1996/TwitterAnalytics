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
	 *    Fetches the given interval with the desired value
	 *
	 *    @param integer $value The interval value
	 *
	 *    @return boolean|object
	 */
	public function get_interval ( $value ) {
		$this->load->model("settings_model");
		$intervals = $this->settings_model->get_intervals();

		foreach ( $intervals as $key => $object ) {
			if ( $object->value == $value ) {
				return $object;
			}
		}

		return false;
	}

	/**
	 *    Checks if an email alert should be sent for this interval
	 *
	 *    @param Object $interval The interval database row object
	 *    @param array &$type A container for the email type
	 *
	 *    @return boolean
	 */
	public function if_to_email ( $interval, &$type ) {
		$result = false;
		$type = array();

		if ( $interval->increase_email == "true" ) {
			$result = true;
			$type[] = "increase";
		} else if ( $interval->increase_email == "1" ) {
			$result = true;
			$type[] = "increase";
		} else if ( $interval->increase_email === true ) {
			$result = true;
			$type[] = "increase";
		}

		if ( $interval->decrease_email == "true" ) {
			$result = true;
			$type[] = "decrease";
		} else if ( $interval->decrease_email == "1" ) {
			$result = true;
			$type[] = "decrease";
		} else if ( $interval->decrease_email === true ) {
			$result = true;
			$type[] = "decrease";
		}

		if ( $interval->category_difference == "true" ) {
			$result = true;
			$type[] = "category";
		} else if ( $interval->category_difference == "1" ) {
			$result = true;
			$type[] = "category";
		} else if ( $interval->category_difference === true ) {
			$result = true;
			$type[] = "category";
		}

		return $result;
	}

	/**
	 *    Fetches all the categories and the associated words
	 *
	 *    @param integer $page_id The page to recieve strings for
	 *
	 *    @return array
	 */
	public function get_category_strings ( $page_id, $min, $max ) {
		$this->load->config("categories");
		$categories = $this->config->item("categories");
		$query = $this->db->query('
			SELECT
			    COUNT(*) AS string_count,
			    statistic_tweet_string_id,
			    value,
			    category
			FROM statistic_tweet_strings
			INNER JOIN (
			    SELECT
			        value,
			        id as  string_id,
			        category
			    FROM statistic_strings
			) strings on strings.string_id = statistic_tweet_string_id
			WHERE tweet_id IN (
			    SELECT id
			    FROM statistic_tweets
			    WHERE created_at BETWEEN ? AND ? AND id IN ( SELECT tweet_id FROM page_tweets WHERE page_id = ? )
			)
			GROUP BY statistic_tweet_string_id
			ORDER BY string_count DESC
		', array($min, $max, $page_id));

		if ( ! $query->num_rows() ) return false;

		$list = array();

		foreach ( $query->result() as $row ) {
			if ( ! isset($list["category_" . $row->category]) ) {
				$list["category_" . $categories[$row->category]["name"]] = array();
			}
			$list["category_" . $categories[$row->category]["name"]][] = $row->value;
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

		@mail(implode(",", $recievers), $settings["subject"], wordwrap($settings["message"], 70, "\r\n"), "From: " . $settings["sender_email"]);
	}

	/**
	 *    Calculates the percentage difference between the two categories
	 *
	 *    @param integer $min     The minimum time
	 *    @param integer $max     Max time
	 *    @param integer $page_id Page
	 *    @param string &$top_category The top scoring category
	 *    @param integer &$top_category_percent The percent value the top scoring category has
	 *    @param integer &$top_category_count The number of hits by the top category string
	 *
	 *    @return integer
	 */
	public function top_category ( $min, $max, $page_id, &$top_category = "", &$top_category_percent = "", &$top_category_count = "" ) {
		$this->load->model("statistic_model");

		$categories = $this->statistic_model->cateogories_sum($min, $page_id, $max );

		$difference = 0;
		$second = 0;
		$percent_change = 0;
		$sum = 0;

		if ( $categories !== false & count($categories) < 2 ) {
			$element = current($categories);
			$key = key($categories);
			$top_category_percent = $element["count"];
			$top_category = $element["category"]->name;
			$difference = $element["count"];
			$top_category_count = $element["count"];
		} else if ( $categories !== false ) {
			$first = current($categories);
			$last = end($categories);
			$difference = $first["count"] - $last["count"];
			$second = $last["count"];

			$sum = $first["count"] + $second;

			if ( ( $sum / $first["count"] * 100 ) >= 50 ) {
				$top_category_percent = $first["count"] / $sum  * 100;
				$top_category = $first["category"]->name;
				$top_category_count = $first["count"];
			} else {
				$top_category = $last["category"]->name;
				$top_category_percent = ($second / $sum * 100);
				$top_category_count = $last["count"];
			}
		}

		if ( $difference != 0 and $second != 0 ) {
			$percent_change = ($difference / $second) * 100;
		}

		return $percent_change;
	}

	/**
	 *    Checks for the category alert
	 *
	 *    @param integer $interval   The interval to check for
	 *    @param integer $page_id The page id
	 *    @param integer $change_value Minimum change
	 *
	 */
	public function category_alert ( $interval, $page_id, $change_value = 0 ) {
		$this->load->model("statistic_model");
		$this->load->model("page_model");
		$this->load->model("settings_model");

		$page_id = (int)$page_id;
		$page = $this->page_model->get_statistic_page($page_id);
		$percent_change = $this->top_category(time() - $interval, time(), $page_id, $top_category, $top_category_percent, $top_category_count);
		$type = "category";

		$settings = array(
			"change_value" => $percent_change,
			"time" => time(),
			"page_name" => $page->name,
			"page_url" => $this->config->item("base_url") . "page/" . $page->id,
			"type" => $type,
			"top_category" => $top_category,
			"top_category_percent" => $top_category_percent,
			"top_category_count" => $top_category_count
		);

		$category_strings = $this->get_category_strings($page_id, time() - $interval, time());

		if ( $category_strings !== "false" ) {
			foreach ( $category_strings as $key => $value ) {
				$settings[$key] = implode(",", $value);
			}
		}

		if ( $this->settings_model->fetch_setting("setting_email_zero_minimum_change_amount", 200, "email") == 0 ) {
			$this->create_message($settings, $type);
		}

		if ( abs($percent_change) >= $change_value ) {
			$this->create_message($settings, $type);
		}

	}

	/**
	 *    Fetches the calculated data and decides if a mail should be send,
	 *    and calls the function that sends the mail
	 *
	 *    @param integer $interval The time between the newest and the next one
	 *    @param integer $page_id  The page to search tweets for
	 *    @param array $types The email types to send
	 *    @param integer $min_change Minimum change to trigger
	 *    @param integer $min_category_difference Minimum category difference before trigger is activated
	 *
	 *    @return boolean
	 */
	public function process ( $interval, $page_id, $types, $min_change = 0, $min_category_difference = 0 ) {
		$this->load->model("statistic_model");
		$this->load->model("page_model");
		$this->load->model("settings_model");
		$calculations = $this->statistic_model->tweets_in_ranges_sum($this->statistic_model->create_time_ranges($interval, 2, time(), array(
			"newest",
			"second"
		)), $page_id);
		$page_id = (int)$page_id;
		$difference = $calculations["newest"] - $calculations["second"];
		$percent_change = 0;
		$page = $this->page_model->get_statistic_page($page_id);
		$category_difference = $this->top_category(time() - $interval, time(), $page_id, $top_category, $top_category_percent, $top_category_count);

		if ( $difference != 0 and $calculations["second"] != 0 ) {
			$percent_change = ($difference / $calculations["second"]) * 100;
		} else if ( $difference != 0 ) {
			$percent_change = ($difference / $calculations["newest"]) * 100;
		}

		$type = "increase";

		if ( $percent_change < 0 ) {
			$type = "decrease";
		}

		$settings = array(
			"change_value" => $percent_change,
			"time" => time(),
			"tweet_count_now" => $calculations["newest"],
			"tweet_count_last" => $calculations["second"],
			"page_name" => $page->name,
			"page_url" => $this->config->item("base_url") . "page/" . $page->id,
			"type" => ( ! in_array("category", $types) ) ? $type : "multiple",
			"top_category" => $top_category,
			"top_category_percent" => $top_category_percent,
			"top_category_count" => $top_category_count
		);

		$category_strings = $this->get_category_strings($page_id, time() - $interval, time());

		if ( $category_strings !== false ) {
			if ( $category_strings !== "false" ) {
				foreach ( $category_strings as $key => $value ) {
					$settings[$key] = implode(",", $value);
				}
			}
		}

		if ( $this->settings_model->fetch_setting("setting_email_zero_minimum_change_amount", 200, "email") == 0 ) {
			$this->create_message($settings, $type);
			return true;
		}

		if ( $calculations["second"] == 0 ) {
			if ( abs($percent_change) >= $this->settings_model->fetch_setting("setting_email_zero_minimum_change_amount", 100, "email") and in_array($type, $types) ) {
				$this->create_message($settings, $type);
			}
		} else {
			if ( in_array("category", $types) ) {
				if ( abs($percent_change) >= $min_change and abs($category_difference) >= $min_category_difference and in_array($type, $types) ) {
					$this->create_message($settings, $type);
				}
			} else if ( abs($percent_change) >= $min_change and in_array($type, $types) ) {
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
		if ( ! class_exists("Mustache") ) {
			$this->load->file("application/libraries/mustache.php");
		}

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