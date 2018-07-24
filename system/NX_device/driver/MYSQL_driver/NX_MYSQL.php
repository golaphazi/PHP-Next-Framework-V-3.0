<?php
namespace NX\driver\MYSQL_SE;
use NX\driver\selector\NX_dbAbstract as NX_dbAbstract;
class NX_MYSQL Extends NX_dbAbstract{
	
	private $con;
	private $server;
	private $base;
	private $database;
	private $password;
	private $user;
	private $host;
	private $port;
	
	public function __construct($server,$base,$database,$password,$user,$port,$host){
		$this->server 		= $server;
		$this->base 		= $base;
		$this->database 	= $database;
		$this->password 	= $password;
		$this->user			= $user;
		$this->port			= $port;
		$this->host			= $host;
		
		
		if($this->server == 'phpmyadmin'){
			$this->con = @mysql_connect($this->host,$this->user,$this->password) or die("ERROR: MYSQL CONNECTION ERROR...");
			mysql_select_db($this->database, $this->con) or die(mysql_error($this->con));
		}else if($this->server == 'sql'){
			$this->con = @mysql_connect('sqlsrv:Server='.$this->host.'; Database='.$this->database, $this->user, $this->password)  or die("ERROR: MYSQL CONNECTION ERROR...");
		}else if($this->server == 'oracle'){
			$this->con = @mysql_connect('oci:dbname='.$this->database.';charset=CL8MSWIN1251', $this->user, $this->password)  or die("ERROR: MYSQL CONNECTION ERROR...");
		}else if($this->server == 'mssql'){
			$this->con = @mysql_connect('dblib:host='.$this->host.':'.$this->port.'dbname='.$this->database, $this->user, $this->password)  or die("ERROR: MYSQL CONNECTION ERROR...");
		}else{
			$this->con = @mysql_connect($this->host,$this->user,$this->password,$this->database) or die("ERROR: MYSQL CONNECTION ERROR...");
		}
	
	}
	
	public function db_connect(){
		return $this->con;
	}
	
	
}
?>