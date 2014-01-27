<?php
$config["settings"] = array(
        "setting_max_lifetime"         => array(
                "value"                 => 3600,
                "key"                         => "settings_max_life_time",
                "section"                 => "scraper",
                "type"                         => "text",
                "language_key"         => "admin_max_age",
                "placeholder"        => "admin_tweet_max_age",
                "help_text"                => "admin_max_life_time_help"
        ),
);


$config["intervals"] = array(
	"per_year" => array(
		"key" => "per_year",
		"value" => 31557600,
		"language_key" => "sort_per_year",
		"login" => "login",
		"status" => true,
	),
	"per_month" => array(
		"key" => "per_month",
		"value" => 2678400,
		"language_key" => "sort_per_month",
		"login" => "login",
		"status" => true
	),
	"per_week" => array(
		"key" => "per_week",
		"value" => 604800,
		"language_key" => "sort_per_week",
		"login" => "login",
		"status" => true,
	),
	"per_day" => array(
		"key" => "per_day",
		"value" => 86400,
		"language_key" => "sort_per_day",
		"login" => "login",
		"status" => true,
 	),
 	"per_half_day" => array(
 		"key" => "per_half_day",
 		"value" => 43200,
 		"language_key" => "sort_per_half_day",
 		"login" => "login",
		"status" => true,
 	),
 	"per_quater_of_a_day" => array(
 		"key" => "per_quater_of_a_day",
 		"value" => 21600,
 		"language_key" => "sort_per_quater_of_day",
 		"login" => "login",
		"status" => true,
 	),
 	"per_tree_hour" => array(
 		"key" => "per_tree_hour",
 		"value" => 10800,
 		"language_key" => "sort_per_tree_hours",
 		"login" => "login",
		"status" => true,
 	),
 	"per_hour" => array(
 		"key" => "per_hour",
 		"value" => 3600,
 		"language_key" => "sort_per_hour",
 		"login" => "login",
		"status" => true,
 	),
 	"per_half_hour" => array(
 		"key" => "per_half_hour",
 		"value" => 1800,
 		"language_key" => "sort_per_half_hour",
 		"login" => "login",
		"status" => true,
 	),
 	"per_fifteen_minutes" => array(
 		"key" => "per_fifteen_minutes",
 		"value" => 900,
 		"language_key" => "sort_per_fifteen_minutes",
 		"login" => "login",
		"status" => true,
 	),
 	"per_five_minutes" => array(
 		"key" => "per_five_minutes",
 		"value" => 300,
 		"language_key" => "sort_per_five_minutes",
 		"login" => "login",
		"status" => true,
 	),
 	"per_minute" => array(
 		"key" => "per_minute",
 		"value" => 60,
 		"language_key" => "sort_per_minute",
 		"login" => "login",
		"status" => true,
 	)
);
?>