<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "user";
$route['404_override'] = '';

$route["sign_in"] = "login/sign_in_view";
$route["sign_out"] = "login/sign_out";
$route["admin/alerts"] = "admin/alerts_view";
$route["alerts"] = "user/alerts_view";
$route["admin/topics"] = "admin_topics_view";
$route["admin/access/control"] = "admin/access_control_view";
$route["admin/topics"] = "admin/topics_view";
$route["admin/blocked/strings"] = "admin/blocked_strings_view";
$route["admin/strings"] = "admin/strings_to_remove_view";
$route["admin/urls"] = "admin/urls_view";

$route["empty"] = "api/api_settings/empty";

$route["admin"] = "admin/status_view";
$route["admin/status"] = "admin/status_view";
$route["admin/settings"] = "admin/settings_view";
$route["admin/twitter"] = "admin/twitter_view";
$route["admin/hidden/words"] = "admin/hidden_words_view";

$route["admin/history"] = "admin/history_view";
$route["admin/scrapers"] = "admin/scrapers_view";
$route["admin/errors"] = "admin/errors_view";
$route["admin/active/scrapers"] = "admin/active_scrapers_view";

$route["user/words/temp"] = "user/words_view";
$route["user/alerts/temp/list"] = "user/alerts_list_view";
$route["user/alerts/temp"] = "user/alerts_box_view";
$route["user/alerts"] = "user/alerts_view";

#### API #####
$route["admin/twitter/save"] = "api/api_settings/twitter";
$route["sign_in/auth"] = "api/api_login/login";
$route["sign_out/noui"] = "api/api_login/logout";
$route["admin/twitter/remove/(:num)"] = "api/api_settings/remove_twitter/account/$1";
$route["admin/access/control/save"] = "api/api_access_control/save";
$route["admin/settings/save"] = "api/api_settings/settings";
$route["admin/setting/(:any)"] = "api/api_settings/setting/key/$1";
$route["admin/alert/(:num)"] = "api/api_alerts/alert_string/id/$1";
$route["admin/alerts/save"] = "api/api_alerts/save_alerts";
$route["admin/topic/(:num)"] = "api/api_topics/topic/id/$1";
$route["admin/topics/save"] = "api/api_topics/save_topics";

$route["admin/remove/string/(:num)"] = "api/api_list/object/id/$1/db/removed_strings";
$route["admin/remove/strings/save"] = "api/api_list/save_list/db/removed_strings";

$route["admin/url/(:num)"] = "api/api_list/object/id/$1/db/urls";
$route["admin/urls/save"] = "api/api_list/save_list/db/urls";

$route["admin/hidden/word/(:num)"] = "api/api_list/object/id/$1/db/hidden_connected_words";
$route["admin/hidden/words/save"] = "api/api_list/save_list/db/hidden_connected_words";

$route["admin/blocked/string/(:num)"] = "api/api_list/object/id/$1/db/blocked_strings";
$route["admin/blocked/strings/save"] = "api/api_list/save_list/db/blocked_strings";

$route["admin/hide/word/(:num)"] = "api/api_list/object/id/$1/db/hidden_words";
$route["admin/hide/words/save"] = "api/api_list/save_list/db/hidden_words";

$route["scrape/topics"] = "api/api_scraper/topics";
$route["scrape/urls"] = "api/api_scraper/urls";
$route["scrape/users"] = "api/api_scraper/users";

$route["admin/alerts/template/strings"] = "admin/alerts_strings_template_view";
$route["admin/alerts/template/connected"] = "admin/alerts_hidden_connected_words_template_view";
$route["admin/alerts/template/settings"] = "admin/alerts_settings_template_view";
$route["admin/hidden/words/template"] = "admin/hidden_words_template_view";


/* End of file routes.php */
/* Location: ./application/config/routes.php */