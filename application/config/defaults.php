<?php
$config["settings"] = array(
	"setting_alert_words" 	=> array(
		"value" 		=> 5,
		"key" 			=> "setting_alert_words",
		"section" 		=> "alerts",
		"type" 			=> "text",
		"language_key" 	=> "alerts_count",
		"placeholder"	=> "number_of_alerts"
	),
	"setting_max_lifetime" 	=> array(
		"value" 		=> 86000,
		"key" 			=> "settings_max_life_time",
		"section" 		=> "scraper",
		"type" 			=> "text",
		"language_key" 	=> "admin_max_age",
		"placeholder"	=> "admin_tweet_max_age"
	),
	"settings_word_charset" => array(
		"value" 		=> "_#@[]{}()&:'",
		"key" 			=> "settings_word_charsets",
		"section" 		=> "scraper",
		"type" 			=> "text",
		"language_key" 	=> "admin_word_extra_characters",
		"placeholder"	=> "admin_word_extra_chars"
	),
	"setting_words_shown" => array(
		"value" 		=> 50,
		"key" 			=> "settings_words_shown",
		"section" 		=> "scraper",
		"type" 			=> "text",
		"language_key" 	=> "admin_standard_rows_shown",
		"placeholder"	=> "admin_words_shown"
	),
);

$config["limit_values"] = array(
	50,
	100,
	500,
	1000
);

// Number of words shown
// Number of connected words, with special alert strings, shown
?>