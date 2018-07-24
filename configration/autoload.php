<?php
$autoload = array();

/*auto load model*/
/* autoload model
for example:  
$autoload['model'] = array('model call name' => 'model page location', 'model call name' => 'model page location', 'db' => 'db', 'form' => 'form); 
*/
$autoload['model'] = array('register' => 'registration_module/register');

/*auto load library*/
$autoload['library'] = '';

/* autoload helper
for example:  
$autoload['helper'] = array('url' => 'url', 'session' => 'session', 'db' => 'db', 'form' => 'form'); 
*/
$autoload['helper'] = ''; 

/*language....*/
$autoload['language'] = 'English'; 



/*
for NX framework
*/

/*auto load library*/
$autoload['NX_library'] = array('');

/* autoload helper
for example:  
$autoload['helper'] = array('url', 'session', 'database'); 
*/
$autoload['NX_helper'] = array('url', 'session', 'db', 'form'); 

/*language....*/
$autoload['NX_language'] = 'English'; 

return $autoload;
?>
