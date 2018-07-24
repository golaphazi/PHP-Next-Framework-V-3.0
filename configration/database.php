<?php
/** database config**/
$database = array();

/*server host name*/

$database['host'] = 'localhost';


/*server host user name*/

$database['user'] = 'root';


/*server host password name*/

$database['password'] = '';


/*Database name*/

$database['database'] = 'hotlancher';


/*defualt Database Driver PDO . use dirver = pdo, mysql, mysqli, mssql, oracle */

$database['driver'] = 'pdo'; // pdo, mysql, mysqli, mssql, oracle, sql

/*defualt server phpmyadmin  . use database = sql, phpmyadmin, oracle */


$database['server'] = 'phpmyadmin'; // sql, phpmyadmin, oracle, mssql


$database['port'] = '8080'; // only for mssql



return $database;
?>