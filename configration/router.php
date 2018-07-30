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




/*===========
*
	Return array for route...............
*
============*/


return $route;
?>
