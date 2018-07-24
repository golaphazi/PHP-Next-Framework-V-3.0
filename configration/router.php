<?php
$route = array();

/*===========
*
	Default Controller setting.... put your default controller name..... 
	Remove "Controller" from your controller full name. 
*
============*/
$route['default_controller'] = 'index';



/*===========
*
	Default Method setting in controller.... put your default method name..... 
	Remove "Action" from your method full name. 
*
============*/
$route['default_method'] = 'index';

/*===========
*
	short url.............  How to use url same as www.facebook.com/golap.hazi   ........... Then you call your controller and method by "default_NX_url "
*
============*/
$route['default_NX_url'] 	= 'profile_module/profile@index';

/*===========
*
	Dynamic Controller setting.
*
============*/

$route['register'] 			= 'registration_module/registration@index';
$route['login'] 			= 'registration_module/registration@login';
$route['logout'] 			= 'registration_module/logout@logout_user';

$route['manage-item'] 		= 'profile_module/account@manage_items';
$route['upload-item'] 		= 'profile_module/account@upload_items';
$route['upload-project'] 	= 'profile_module/account@upload_project';
$route['json_search_category'] 				= 'profile_module/account@category_search';
$route['json_search_category_filter'] 		= 'profile_module/account@category_filter_search';
$route['json_search_sub_category_filter'] 	= 'profile_module/account@sub_category_filter_search';
$route['json_search_category_delivery'] 	= 'profile_module/account@category_delivery_search';
$route['json_search_category_project'] 				= 'profile_module/account@category_search_project';

$route['manage-script'] 	= 'profile_module/account@manage_script';
$route['upload-script'] 	= 'profile_module/account@upload_script';

$route['account-setting'] 	= 'profile_module/account@index';
$route['json_searchskills'] = 'profile_module/account@searchskills';
$route['json_searchtags'] 	= 'profile_module/account@searchtags';

$route['notification'] 		= 'profile_module/account@notification';
$route['messages'] 			= 'profile_module/account@messages';
$route['categories'] 		= 'product_module/categorie@index';




/*===========
*
	Return array for route...............
*
============*/


return $route;
?>