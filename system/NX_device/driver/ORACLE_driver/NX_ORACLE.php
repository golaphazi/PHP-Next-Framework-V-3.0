<?php
namespace NX\driver\ORACLE_SE;
use NX\driver\selector\NX_dbAbstract as NX_dbAbstract;

class NX_ORACLE Extends NX_dbAbstract{
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
			$this->con = oci_connect($this->user,$this->password,$this->host);
		}else if($this->server == 'sql'){
			$this->con = oci_connect($this->user,$this->password,$this->host);
		}else if($this->server == 'oracle'){
			$this->con = oci_connect($this->user,$this->password,$this->host);
		}else if($this->server == 'mssql'){
			$this->con = oci_connect($this->user,$this->password,$this->host);
		}else{
			$this->con = oci_connect($this->user,$this->password,$this->host);
		}
	
		if (!$this->con) {
			die('Connect Error for oracle ');
		}
	}
	
	public function db_connect(){
		return $this->con;
	}
	
}
?>