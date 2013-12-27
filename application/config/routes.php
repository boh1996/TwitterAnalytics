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
$route["sign_in/auth"] = "api/api_login/login";
$route["sign_out/noui"] = "api/api_login/logout";
$route["admin/alerts"] = "admin/alerts_view";
$route["alerts"] = "user/alerts_view";
$route["admin/topics"] = "admin_topics_view";
$route["admin/access/control"] = "admin/access_control_view";
$route["admin/access/control/save"] = "api/api_access_control/save";
$route["admin/topics"] = "admin/topics_view";
$route["admin/twitter/save"] = "api/api_settings/twitter";
$route["admin/twitter/remove/(:num)"] = "api/api_settings/remove_twitter/account/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */