<?php
namespace NX\driver\SQL_SE;
use NX\driver\selector\NX_dbAbstract as NX_dbAbstract;

class NX_SQL Extends NX_dbAbstract{
	
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
			$this->con = sqlsrv_connect($this->host, array('UID' => $this->user, 'PWD' => $this->password, 'Database' => $this->database));
		}else if($this->server == 'sql'){
			$this->con = sqlsrv_connect($this->host, array('UID' => $this->user, 'PWD' => $this->password, 'Database' => $this->database));
		}else if($this->server == 'oracle'){
			$this->con = odbc_connect($this->database, $this->user, $this->password);			
		}else if($this->server == 'mssql'){
			$this->con = sqlsrv_connect($this->host, array('UID' => $this->user, 'PWD' => $this->password, 'Database' => $this->database));			
		}else{
			$this->con = sqlsrv_connect($this->host, array('UID' => $this->user, 'PWD' => $this->password, 'Database' => $this->database));
		}
	
	}
	
	public function db_connect(){
		return $this->con;
	}
	
	
}
?>