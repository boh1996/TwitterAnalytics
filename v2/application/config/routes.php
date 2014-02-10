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
$route["admin/access/control"] = "admin/access_control_view";
$route["setup"] = "setup";

$route["empty"] = "api/api_settings/empty";

$route["admin"] = "admin/status_view";
$route["admin/status"] = "admin/status_view";
$route["admin/settings"] = "admin/settings_view";
$route["admin/email"] = "admin/email_view";

$route["admin/history"] = "admin/history_view";
$route["admin/scrapers"] = "admin/scrapers_view";
$route["admin/errors"] = "admin/errors_view";
$route["admin/active/scrapers"] = "admin/active_scrapers_view";
$route["admin/pages"] = "admin/pages_view";
$route["admin/template/pages"] = "admin/pages_template_view";
$route["admin/intervals"] = "admin/intervals_view";

if ( ! isset($_GET["token"]) ) {
	$route["page/(:any)"] = "page/get_page/$1";
} else {
	$route["page/(:any)"] = "api/api_pages/page/id/$1";
}

#### API #####
$route["scrape/pages"] = "api/api_scraper/pages";

$route["admin/access/control/save"] = "api/api_access_control/save";

$route["admin/twitter/save"] = "api/api_settings/twitter";
$route["sign_in/auth"] = "api/api_login/login";
$route["sign_out/noui"] = "api/api_login/logout";
$route["save/page/name"] = "api/api_pages/pages";

$route["admin/settings/save"] = "api/api_settings/settings";
$route["admin/setting/(:any)"] = "api/api_settings/setting/key/$1";

$route["admin/interval/hide"] = "api/api_intervals/hide";
$route["admin/interval/show"] = "api/api_intervals/show";
$route["admin/interval/edit"] = "api/api_intervals/interval";
$route["admin/intervals/edit"] = "api/api_intervals/intervals";

$route["get/tweets/(:any)/(:any)"] = "api/api_viewer/stats/page/$1/interval/$2";

$route["email/(:any)"] = "api/api_email/interval/interval/$1";

$route["save/pages"] = "api/api_pages/save";

$route["string/(:any)"] = "api/api_strings/string/id/$1";
$route["url/(:any)"] = "api/api_urls/url/id/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */