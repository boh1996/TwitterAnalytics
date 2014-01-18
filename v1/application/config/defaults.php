<?php
$config["settings"] = array(
	"setting_alert_words" 	=> array(
		"value" 		=> 5,
		"key" 			=> "setting_alert_words",
		"section" 		=> "alerts",
		"type" 			=> "text",
		"language_key" 	=> "alerts_count",
		"placeholder"	=> "number_of_alerts",
		"help_text"		=> "admin_alert_words_help"
	),
	"setting_max_lifetime" 	=> array(
		"value" 		=> 86000,
		"key" 			=> "settings_max_life_time",
		"section" 		=> "scraper",
		"type" 			=> "text",
		"language_key" 	=> "admin_max_age",
		"placeholder"	=> "admin_tweet_max_age",
		"help_text"		=> "admin_max_life_time_help"
	),
	"settings_word_charset" => array(
		"value" 		=> "_#@[]{}()&:'",
		"key" 			=> "settings_word_charsets",
		"section" 		=> "scraper",
		"type" 			=> "text",
		"language_key" 	=> "admin_word_extra_characters",
		"placeholder"	=> "admin_word_extra_chars",
		"help_text"		=> "admin_word_charset_help"
	),
	"setting_words_shown" => array(
		"value" 		=> 50,
		"key" 			=> "settings_words_shown",
		"section" 		=> "analytics",
		"type" 			=> "text",
		"language_key" 	=> "admin_standard_rows_shown",
		"placeholder"	=> "admin_words_shown",
		"help_text"		=> "admin_words_shown_help"
	),
	"setting_alert_connection_words_shown" => array(
		"value" 		=> 3,
		"key" 			=> "setting_alert_connection_words_shown",
		"section" 		=> "alerts",
		"type" 			=> "text",
		"language_key" 	=> "admin_settings_alert_connetion_words_shown",
		"placeholder"	=> "admin_connection_words_shown",
		"help_text"		=> "admin_alert_connection_words_help"
	),
);

$config["limit_values"] = array(
	50,
	100,
	500,
	1000
);
?>