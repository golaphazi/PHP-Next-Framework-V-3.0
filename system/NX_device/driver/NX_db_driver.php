<?php
namespace NX\DB_driver\apps;
use databaseApps\apps as database;

use NX\driver\PDO\NX_PDO as PDO_SE;
use NX\driver\MYSQL_SE\NX_MYSQL as MYSQL_SE;
use NX\driver\MYSQLI_SE\NX_MYSQLI as MYSQLI_SE;
use NX\driver\MSSQL_SE\NX_MSSQL as MSSQL_SE;
use NX\driver\ORACLE_SE\NX_ORACLE as ORACLE_SE;
use NX\driver\SQL_SE\NX_SQL as SQL_SE;

class NX_db_driver Extends database\NX_database{
	
	private $driver;
	private $server;
	private $base;
	private $database;
	private $password;
	private $user;
	private $host;
	private $port;
	private $selector;
	
	protected function __construct(){
		parent::__construct();
		
		$this->driver 		= strtolower(parent::get_driver());		
		$this->server 		= strtolower(parent::get_server());
		$this->base 		= parent::get_base_name();
		$this->database 	= parent::get_database();
		$this->password 	= parent::get_host_password();
		$this->user			= parent::get_host_user();
		$this->port			= parent::get_host_port();
		$this->host			= strtolower(parent::get_host());
		
		if(parent::use_database() == 'Yes'){
		
			switch($this->driver){
					case 'pdo':
						$this->selector = New PDO_SE($this->server,$this->base,$this->database,$this->password,$this->user,$this->port,$this->host);
					break;
				
					case 'mysql':
						$this->selector = New MYSQL_SE($this->server,$this->base,$this->database,$this->password,$this->user,$this->port,$this->host);
					break;
					
					case 'mysqli':
						$this->selector = New MYSQLI_SE($this->server,$this->base,$this->database,$this->password,$this->user,$this->port,$this->host);
					break;
					
					case 'mssql':
						$this->selector = New MSSQL_SE($this->server,$this->base,$this->database,$this->password,$this->user,$this->port,$this->host);
					break;
					
					case 'oracle':
						$this->selector = New ORACLE_SE($this->server,$this->base,$this->database,$this->password,$this->user,$this->port,$this->host);
					break;
					
					case 'sql':
						$this->selector = New SQL_SE($this->server,$this->base,$this->database,$this->password,$this->user,$this->port,$this->host);
					break;
					
					default:
						$this->selector = New SQL_SE($this->server,$this->base,$this->database,$this->password,$this->user,$this->port,$this->host);
					break;
					
			}
		}
		
	}
	
	protected function selector(){
		return $this->selector;
	}
	
	protected function self_db($arrayValue){
		$this->database = $arrayValue[0];
		return $this->selector;
	}
	
	
	
}
?>