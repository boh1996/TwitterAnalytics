<?php
$config["settings"] = array(
        "setting_max_lifetime"      => array(
                "value"             => 3600,
                "key"               => "settings_max_life_time",
                "section"           => "scraper",
                "type"              => "text",
                "language_key"      => "admin_max_age",
                "placeholder"       => "admin_tweet_max_age",
                "help_text"         => "admin_max_life_time_help"
        ),
        "setting_number_of_columns" => array(
        	"value"                 => 10,
            "key"                   => "setting_number_of_columns",
            "section"               => "viewer",
            "type"                  => "text",
            "language_key"         	=> "admin_number_of_columns",
            "placeholder"       	=> "admin_graph_columns",
            "help_text"             => "setting_number_of_columns_help"
        ),
        "setting_default_zero_color" => array(
        	"value"                 => "#D1E0E0",
            "key"                   => "setting_default_zero_color",
            "section"               => "viewer",
            "type"                  => "text",
            "language_key"         	=> "admin_default_color",
            "placeholder"       	=> "admin_default_zero_color",
            "help_text"             => "setting_default_zero_color"
        ),

        # Email #
        "setting_email_sender" => array(
        	"value"                 => "support@illution.dk",
            "key"                   => "setting_email_sender",
            "section"               => "email",
            "type"                  => "text",
            "language_key"         	=> "admin_email_sender",
            "placeholder"       	=> "admin_email_sender_placeholder",
            "help_text"             => "setting_email_sender_help"
        ),
        "setting_email_subject" => array(
        	"value"                 => "{{page_name}} has changed {{change_value}}%",
            "key"                   => "setting_email_subject",
            "section"               => "email",
            "type"                  => "textarea",
            "language_key"         	=> "admin_email_subject",
            "placeholder"       	=> "admin_email_subject_placeholder",
            "help_text"             => "setting_email_subject_help"
        ),
        "setting_email_message" => array(
        	"value"                 => "There has been a change to {{page_name}}, at {{page_url}}, with {{tweet_count}} and a change of {{change_value}}%",
            "key"                   => "setting_email_message",
            "section"               => "email",
            "type"                  => "textarea",
            "language_key"         	=> "admin_email_message",
            "placeholder"       	=> "admin_email_message_placeholder",
            "help_text"             => "setting_email_message_help"
        ),
        "setting_email_zero_minimum_change_amount" => array(
            "value"                 => 100,
            "key"                   => "setting_email_zero_minimum_change_amount",
            "section"               => "email",
            "type"                  => "text",
            "language_key"          => "setting_email_zero_minimum_change_amount",
            "placeholder"           => "admin_email_change_from_zero_placeholder",
            "help_text"             => "setting_email_minimum_change_from_zero_help"
        )
);


$config["intervals"] = array(
	"per_year" => array(
		"key" => "per_year",
		"value" => 31557600,
		"language_key" => "sort_per_year",
		"login" => "login",
		"status" => true,
        "increase_email" => true,
        "decrease_email" => true,
        "email_change_value" => 100,
        "category_difference" => true,
        "category_change_value" => 70
	),
	"per_month" => array(
		"key" => "per_month",
		"value" => 2678400,
		"language_key" => "sort_per_month",
		"login" => "login",
		"status" => true,
        "increase_email" => true,
        "decrease_email" => true,
        "email_change_value" => 100,
        "category_difference" => true,
        "category_change_value" => 70
	),
	"per_week" => array(
		"key" => "per_week",
		"value" => 604800,
		"language_key" => "sort_per_week",
		"login" => "login",
		"status" => true,
        "increase_email" => true,
        "decrease_email" => true,
        "email_change_value" => 100,
        "category_difference" => true,
        "category_change_value" => 70
	),
	"per_day" => array(
		"key" => "per_day",
		"value" => 86400,
		"language_key" => "sort_per_day",
		"login" => "login",
		"status" => true,
        "increase_email" => true,
        "decrease_email" => true,
        "email_change_value" => 100,
        "category_difference" => true,
        "category_change_value" => 70
 	),
 	"per_half_day" => array(
 		"key" => "per_half_day",
 		"value" => 43200,
 		"language_key" => "sort_per_half_day",
 		"login" => "login",
		"status" => true,
        "increase_email" => true,
        "decrease_email" => true,
        "email_change_value" => 100,
        "category_difference" => true,
        "category_change_value" => 70
 	),
 	"per_quater_of_a_day" => array(
 		"key" => "per_quater_of_a_day",
 		"value" => 21600,
 		"language_key" => "sort_per_quater_of_day",
 		"login" => "login",
		"status" => true,
        "increase_email" => true,
        "decrease_email" => true,
        "email_change_value" => 100,
        "category_difference" => true,
        "category_change_value" => 70
 	),
 	"per_tree_hour" => array(
 		"key" => "per_tree_hour",
 		"value" => 10800,
 		"language_key" => "sort_per_tree_hours",
 		"login" => "login",
		"status" => true,
        "increase_email" => true,
        "decrease_email" => true,
        "email_change_value" => 100,
        "category_difference" => true,
        "category_change_value" => 70
 	),
 	"per_hour" => array(
 		"key" => "per_hour",
 		"value" => 3600,
 		"language_key" => "sort_per_hour",
 		"login" => "login",
		"status" => true,
        "increase_email" => true,
        "decrease_email" => true,
        "email_change_value" => 100,
        "category_difference" => true,
        "category_change_value" => 70
 	),
 	"per_half_hour" => array(
 		"key" => "per_half_hour",
 		"value" => 1800,
 		"language_key" => "sort_per_half_hour",
 		"login" => "login",
		"status" => true,
        "increase_email" => true,
        "decrease_email" => true,
        "email_change_value" => 100,
        "category_difference" => true,
        "category_change_value" => 70
 	),
 	"per_fifteen_minutes" => array(
 		"key" => "per_fifteen_minutes",
 		"value" => 900,
 		"language_key" => "sort_per_fifteen_minutes",
 		"login" => "login",
		"status" => true,
        "increase_email" => true,
        "decrease_email" => true,
        "email_change_value" => 100,
        "category_difference" => true,
        "category_change_value" => 70
 	),
 	"per_five_minutes" => array(
 		"key" => "per_five_minutes",
 		"value" => 300,
 		"language_key" => "sort_per_five_minutes",
 		"login" => "login",
		"status" => true,
        "increase_email" => true,
        "decrease_email" => true,
        "email_change_value" => 100,
        "category_difference" => true,
        "category_change_value" => 70
 	),
 	"per_minute" => array(
 		"key" => "per_minute",
 		"value" => 60,
 		"language_key" => "sort_per_minute",
 		"login" => "login",
		"status" => true,
        "increase_email" => true,
        "decrease_email" => true,
        "email_change_value" => 100,
        "category_difference" => true,
        "category_change_value" => 70
 	)
);
?>