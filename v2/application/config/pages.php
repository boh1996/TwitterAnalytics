<?php
$config["pages"] = array(
	"admin_status" => array(
		"page"					=> "admin_status",
		"mode" 					=> "login",
		"language_key" 			=> "admin_status",
		"section"				=> "admin",
		"admin_language_key" 	=> "admin_page_status",
		"url"					=> "admin/status;admin",
		"type"					=> "header",
		"header_language_key"	=> "control_panel"
	),
	"user_home" => array(
		"page"					=> "user_home",
		"mode" 					=> "login",
		"language_key" 			=> "viewer_section",
		"section"				=> "user",
		"admin_language_key" 	=> "admin_page_user_home",
		"url"					=> "",
		"type"					=> "header",
		"header_language_key"	=> "viewer_section"
	),
	"admin_access_control" => array(
		"page"					=> "admin_access_control",
		"mode" 					=> "login",
		"language_key" 			=> "admin_access_control",
		"section"				=> "admin",
		"admin_language_key" 	=> "admin_page_admin_access_control",
		"url"					=> "admin/access/control",
		"type"					=> "page",
		"header_language_key"	=> ""
	),
	"admin_settings" => array(
		"page"					=> "admin_settings",
		"mode" 					=> "login",
		"language_key" 			=> "admin_settings",
		"section"				=> "admin",
		"admin_language_key" 	=> "admin_page_settings",
		"url"					=> "admin/settings",
		"type"					=> "page",
		"header_language_key"	=> ""
	),
);
?>