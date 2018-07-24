<?php
namespace NX\driver\MYSQLI_SE;
use NX\driver\selector\NX_dbAbstract as NX_dbAbstract;
use \Mysqli;
class NX_MYSQLI Extends NX_dbAbstract{
	
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
			$this->con = New Mysqli($this->host,$this->user,$this->password,$this->database);
		}else if($this->server == 'sql'){
			$this->con = New Mysqli('sqlsrv:Server='.$this->host.'; Database='.$this->database, $this->user, $this->password);
		}else if($this->server == 'oracle'){
			$this->con = New Mysqli('oci:dbname='.$this->database.';charset=CL8MSWIN1251', $this->user, $this->password);
		}else if($this->server == 'mssql'){
			$this->con = New Mysqli('dblib:host='.$this->host.':'.$this->port.'dbname='.$this->database, $this->user, $this->password);
		}else{
			$this->con = New Mysqli($this->host,$this->user,$this->password,$this->database);
		}
	
		if ($this->con->connect_error) {
			die('Connect Error (' . $this->con->connect_errno . ') '. $this->con->connect_error);
		}
	}
	
	public function db_connect(){
		return $this->con;
	}
	
	
}
?>