<?php
return array(
	'configApps\apps\NX_config' 		=> 'system/NX_config.php',
	'routerApps\apps\NX_router' 		=> 'system/NX_device/NX_router.php',
	'databaseApps\apps\NX_database' 	=> 'system/NX_device/NX_database.php',
	'DBApps\NX_db' 						=> 'system/NX_device/NX_db.php',
	'NX\DB_driver\apps\NX_db_driver' 	=> 'system/NX_device/driver/NX_db_driver.php',
	
	'NX\driver\PDO\NX_PDO' 				=> 'system/NX_device/driver/PDO_driver/NX_PDO.php',
	'NX\driver\MYSQL_SE\NX_MYSQL' 		=> 'system/NX_device/driver/MYSQL_driver/NX_MYSQL.php',
	'NX\driver\MYSQLI_SE\NX_MYSQLI' 	=> 'system/NX_device/driver/MYSQLI_driver/NX_MYSQLI.php',
	'NX\driver\MSSQL_SE\NX_MSSQL' 		=> 'system/NX_device/driver/MSSQL_driver/NX_MSSQL.php',
	'NX\driver\ORACLE_SE\NX_ORACLE' 	=> 'system/NX_device/driver/ORACLE_driver/NX_ORACLE.php',
	'NX\driver\SQL_SE\NX_SQL' 			=> 'system/NX_device/driver/SQL_driver/NX_SQL.php',
	
	'NX_trait\templeate\NX_templeate' 									=> 'system/NX_device/template/NX_templeate.php',
	'NX_trait\templeate\NX_Interface\NX_templeate_interface' 			=> 'system/NX_device/template/NX_templeate_interface.php',
	'NX_trait\templeate\NX_Page_info\NX_templeate_page_info' 			=> 'system/NX_device/template/NX_templeate_page_info.php',
	
	'NX\From\InterfaceApps\NX_From_interface' 	=> 'system/NX_helper/html/NX_from_interface.php',
	'NX\Input\InterfaceApps\NX_Input_interface' => 'system/NX_helper/html/NX_input_interface.php',
	'NX\Html\InterfaceApps\NX_Html_interface' 	=> 'system/NX_helper/html/NX_html_interface.php',
	'NX\Html\Apps\htmlApps' 					=> 'system/NX_helper/html/NX_html.php',
	
	'NX\Session\InterfaceApps\NX_Session_interface' 	=> 'system/NX_helper/session/NX_session_interface.php',
	'NX\Cookie\InterfaceApps\NX_Cookie_interface' 		=> 'system/NX_helper/session/NX_cookie_interface.php',
	'NX\Session\OS\InterfaceApps\NX_OS_info_interface' 	=> 'system/NX_helper/session/NX_OS_info.php',
	'NX\Session\Apps\NX_Session' 						=> 'system/NX_helper/session/NX_session.php',
	
	'NX\Url\InterfaceApps\NX_Url_interface' 			=> 'system/NX_helper/url/NX_url_interface.php',
	'NX\Url\Apps\NX_Url' 								=> 'system/NX_helper/url/NX_url.php',
	
	'NX\Country\InterfaceApps\NX_Country_interface' 			=> 'system/NX_library/country/NX_country_interface.php',
	'NX\Country\Apps\NX_Country' 								=> 'system/NX_library/country/NX_country.php',
	
	'NX\Pagination\InterfaceApps\NX_Pagination_interface' 			=> 'system/NX_library/pagination/NX_pagination_interface.php',
	'NX\Pagination\Apps\NX_Pagination' 								=> 'system/NX_library/pagination/NX_pagination.php',
	
	'NX\Upload\InterfaceApps\NX_Upload_interface' 					=> 'system/NX_library/upload/NX_upload_interface.php',
	'NX\Upload\Apps\NX_Upload' 										=> 'system/NX_library/upload/NX_upload.php',
	
	'NX\Editor\Apps\NX_Editor' 								=> 'system/NX_library/editor/NX_editor.php',
	
	
	'databaseApps\apps\NX_databaseAbstract' 	=> 'system/NX_attachment/NX_databaseAbstract.php',
	'NX\driver\selector\NX_dbAbstract' 			=> 'system/NX_attachment/NX_dbAbstract.php',
);
?>