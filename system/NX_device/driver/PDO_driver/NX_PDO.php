<?php
namespace NX\driver\PDO;
use NX\driver\selector\NX_dbAbstract as NX_dbAbstract;
use databaseApps\apps\NX_database as databaseq;
use PDO;
class NX_PDO Extends NX_dbAbstract{
	private $con;
	private $server;
	private $base;
	private $database;
	private $password;
	private $user;
	private $host;
	private $port;
	
	private $select_data = '*'; 
	private $query, $print_query, $sub_select, $sub_having, $join_data, $from_data, $group_data, $order_data, $limit_data, $having_data, $order_type, $insert, $update, $delete, $where_data, $fetch, $row_count, $sum, $count, $union, $all_union, $un_union = '';

	public function __construct($server,$base,$database,$password,$user,$port,$host){
		
		$this->server 		= $server;
		$this->base 		= $base;
		$this->database 	= $database;
		$this->password 	= $password;
		$this->user			= $user;
		$this->port			= $port;
		$this->host			= $host;
		
		try {
			if($this->server == 'phpmyadmin'){
				$this->con = New PDO('mysql:host='.$this->host.'; dbname='.$this->database, $this->user, $this->password);
			}else if($this->server == 'sql'){
				$this->con = New PDO('sqlsrv:Server='.$this->host.'; Database='.$this->database, $this->user, $this->password);
			}else if($this->server == 'oracle'){
				$this->con = New PDO('oci:dbname='.$this->database.';charset=CL8MSWIN1251', $this->user, $this->password);
			}else if($this->server == 'mssql'){
				$this->con = New PDO('dblib:host='.$this->host.':'.$this->port.'dbname='.$this->database, $this->user, $this->password);
			}else{
				$this->con = New PDO('mysql:host='.$this->host.'; dbname='.$this->database, $this->user, $this->password);
			}
		   
        }catch (PDOException $err) {  
            echo $err->getMessage() . "<br/>";
			die();
        }
	}
	
	/**
	###Database select for PDO
	**/
	private function htmlChar($data=''){
		return trim(htmlspecialchars($data));
	}
	
	public function select_sub($sub = array()){
		$this->sub_select = '';
		if(is_array($sub) AND sizeof($sub) > 0){
			$sub_select_data = '';
			$m = 1;
			foreach($sub AS $index=>$data):
				if(strlen(trim($index)) > 0){
					$index_ex = explode('.', trim($data));
					if(is_array($index_ex) AND sizeof($index_ex) > 1){
						$filedName = $index_ex[1];
						$define = '`'.$index_ex[0].'`.';
					}else{
						$filedName = $data;
						$define = '';
					}
					
					if($m != sizeof($sub)){
						$sub_select_data .= $index."(".$define."`".$filedName."`), ";
					}else{
						$sub_select_data .= $index."(".$define."`".$filedName."`) ";
					}
				$m++;
				}
			endforeach;
			$this->sub_select = trim($sub_select_data, ', ');
		}
		return $this->sub_select;
	}
	
	public function select( $select = '*' ){
		$this->select_data = '';
		if(is_array($select) AND sizeof($select) > 0){
			$dataSelect = '';
			$m = 1;
			foreach($select AS $sele):
				if(is_array($sele) AND sizeof($sele) > 0){
					$dataSelect .= $this->select_sub($sele).', ';
				}else{
					if(strlen(trim($sele)) > 0){
						$index_ex = explode('.', trim($sele));
						if(is_array($index_ex) AND sizeof($index_ex) > 1){
							$filedName = $index_ex[1];
							$define = '`'.$index_ex[0].'`.';
						}else{
							$filedName = $sele;
							$define = '';
						}
						
						if($m != sizeof($select)){
							$dataSelect .= $define.'`'.$this->htmlChar($filedName).'`, ';
						}else{
							$dataSelect .= $define.'`'.$this->htmlChar($filedName).'` ';
						}
					}
				}
			$m++;	
			endforeach;
			$dataSelect = trim($dataSelect, ', ');
			$this->select_data .= 'SELECT '.$dataSelect.' ';
		}else{
			if(strlen($select) > 2){
				$selectData = explode(',', trim($select));
				if(is_array($selectData) AND sizeof($selectData) > 0){
					$dataSelect = '';
					$m = 1;
					foreach($selectData AS $sele):
						if(strlen(trim($sele)) > 0){
							
							$index_ex = explode('.', trim($sele));
							if(is_array($index_ex) AND sizeof($index_ex) > 1){
								$filedName = $index_ex[1];
								$define = '`'.$index_ex[0].'`.';
							}else{
								$filedName = $sele;
								$define = '';
							}
							
							if($m != sizeof($selectData)){
								$dataSelect .= $define.'`'.$this->htmlChar($filedName).'`, ';
							}else{
								$dataSelect .= $define.'`'.$this->htmlChar($filedName).'` ';
							}
							$m++;
						}
					endforeach;
					$dataSelect = trim($dataSelect, ', ');
					$this->select_data .= 'SELECT '.$dataSelect.' ';					
				}else{
					$this->select_data .= 'SELECT `'.trim($select).'` ';					
				}	
			}else{
				$this->select_data .= 'SELECT '.$this->htmlChar($select).' ';				
			}
		}
		
		return $this;
	}
	
	/**
	###Database from for PDO
	**/
	public function from( $table= ''){
		$this->from_data = '';
		if(is_array($table) AND sizeof($table) > 0){
			$dataTable = '';
			$m = 1;
			$tableName = '';
			$define = '';
			foreach($table AS $tabl):
				if(strlen(trim($tabl)) > 0){
					$index_ex = explode(' AS ', trim($tabl));
					if(is_array($index_ex) AND sizeof($index_ex) > 1){
						$tableName = $index_ex[0];
						$define = 'AS `'.$index_ex[1].'`';
					}else{
						$tableName = $tabl;
						$define = '';
					}
					if($m != sizeof($table)){	
						$dataTable .= ' `'.$this->htmlChar($tableName).'` '.$define.', ';
					}else{
						$dataTable .= ' `'.$this->htmlChar($tableName).'` '.$define.' ';
					}
					$m++;
				}
			endforeach;
			$dataTable = trim($dataTable, ', ');
			$this->from_data = 'FROM '.$dataTable.' ';
		}else{
			if(strlen($table) > 2){
				$tableData = explode(',', trim($table));
				if(is_array($tableData) AND sizeof($tableData) > 0){
					$dataTable = '';
					$m = 1;
					$tableName = '';
					$define = '';
					foreach($tableData AS $tabl):
						if(strlen(trim($tabl)) > 0){
							$index_ex = explode(' AS ', trim($tabl));
							if(is_array($index_ex) AND sizeof($index_ex) > 1){
								$tableName = $index_ex[0];
								$define = 'AS `'.$index_ex[1].'`';
							}else{
								$tableName = $tabl;
								$define = '';
							}
							
							if($m != sizeof($tableData)){	
								$dataTable .= ' `'.$this->htmlChar($tableName).'` '.$define.', ';
							}else{
								$dataTable .= ' `'.$this->htmlChar($tableName).'` '.$define.' ';
							}
							$m++;
						}
					endforeach;
					$dataTable = trim($dataTable, ', ');
					$this->from_data = 'FROM '.$dataTable.' ';
				}else{
					$index_ex = explode(' AS ', trim($table));
					if(is_array($index_ex) AND sizeof($index_ex) > 1){
						$tableName = $index_ex[0];
						$define = 'AS `'.$index_ex[1].'`';
					}else{
						$tableName = $table;
						$define = '';
					}
					$this->from_data = 'FROM `'.trim($this->htmlChar($tableName)).'` '.$define.'  ';
				}	
			}
		}		
		return $this;
	}
	
	/**
	###Database where for PDO
	**/
	private function get_sub_check($data='AND'){
		if(is_array($data) AND sizeof($data) > 1){
			return $this->htmlChar($data[1]);
		}else{
			return 'AND';
		}
	}
	
	private function get_sub_check_data($data=''){
		if(is_array($data) AND sizeof($data) > 0){
			if(is_array($data[0]) AND sizeof($data[0]) > 0){
				$value = $data[0][0];
				$as_data = explode('.', trim($value));
				if(is_array($as_data) AND sizeof($as_data) > 1){
					$index = $as_data[1];
					$define = '`'.$as_data[0].'`.';
				}else{
					$define = '';
					$index = $value;
				}
				return $define."`".$this->htmlChar($index)."`"; 
			}else{
				return "'".$this->htmlChar($data[0])."'"; 
			}
			
		}else{
			return "'".$this->htmlChar($data)."'";
		}
	}
	
	public function where($where=array(), $type = ''){
		$this->where_data = '';
		$this->where_data .= 'WHERE ';
		if(is_array($where) AND sizeof($where) > 0){
			$whereData = '';
			$m = 1;
			foreach($where AS $index=>$value):
				$check = '';
				if(strlen(trim($index)) > 0){
					$coloumn = '';
					$operator = ' = ';
					if($m != sizeof($where)):	
						$check = $this->get_sub_check($value);
					endif;		
					
					$as_data = explode('.', trim($index));
					if(is_array($as_data) AND sizeof($as_data) > 1){
						$index = $as_data[1];
						$define = '`'.$as_data[0].'`.';
					}else{
						$define = '';
					}
					$checkData = $this->get_sub_check_data($value);							
					$index_ex = explode(' ', trim($index));
					if(is_array($index_ex) AND sizeof($index_ex) > 1){
						if(strlen(trim($index_ex[0])) > 0):
							$whereData .= $define."`".trim($index_ex[0])."` ".trim($index_ex[1])." ".trim($checkData)." ".$check." ";
						endif;
					}else{
						if(strlen(trim($index_ex[0])) > 0):
							$whereData .= $define."`".trim($index_ex[0])."` ".trim($operator)." ".trim($checkData)." ".$check." ";
						endif;
					}
				$m++;
				}				
			endforeach;
			$whereData .= "AND 1 = 1";
			$this->where_data .= $whereData;
		}else{
			if(strlen(trim($where)) > 1){
				$this->where_data .= $this->htmlChar($where);
			}
			$this->where_data .= " AND 1 = 1";
		}
		if($type == 'return'){
			return $this->where_data;
		}else{
			return $this;
		}
		
	}
	
	/**
	###Database order for PDO
	**/
	public function order($order = array()){
		$this->order_data = '';
		if(is_array($order) AND sizeof($order) > 0){
			$order_all = '';
			foreach($order AS $orderData){
				if(is_array($orderData) AND sizeof($orderData) > 0){
					$order_da = '';
					$m = 1;
					foreach($orderData AS $orderList):
						
						$index_ex = explode('.', trim($orderList));
						if(is_array($index_ex) AND sizeof($index_ex) > 1){
							$filedName = $index_ex[1];
							$define = '`'.$index_ex[0].'`.';
						}else{
							$filedName = $orderList;
							$define = '';
						}
						
						if($m != sizeof($orderData)){
							$order_da .= $define."`".$filedName."`, ";
						}else{
							$order_da .= $define."`".$filedName."` ";
						}
						
						$m++;
					endforeach;
					$order_all .= trim($order_da, ', ');
				}else{
					$order_all .= ' '.trim($orderData).' ';
				}
			}
			$this->order_data = 'ORDER BY '.trim($order_all);
		}else{
			if(strlen(trim($order)) > 1){
				$this->order_data = 'ORDER BY '.trim($order);
			}
		}
		return $this;
	}
	
	/**
	###Database limit for PDO
	**/
	public function limit($limit = array()){
		$this->limit_data = '';
		
		if(is_array($limit) AND sizeof($limit) > 0){
			$this->limit_data .= 'LIMIT '.trim($limit[0]).'';
			if(sizeof($limit) > 1){
				$this->limit_data .= ', '.trim($limit[1]).'';
			}
		}else{
			if(strlen(trim($limit)) > 1){
				$this->limit_data = 'LIMIT '.trim($limit).'';
			}
		}
		return $this;
	}

	
	/**
	###Database Group By for PDO
	**/
	public function group($group = array()){
		$this->group_data = '';
		if(is_array($group) AND sizeof($group) > 0){
			$group_all = '';
			$m = 1;
			foreach($group AS $groupData){
				
				$index_ex = explode('.', trim($groupData));
				if(is_array($index_ex) AND sizeof($index_ex) > 1){
					$filedName = $index_ex[1];
					$define = '`'.$index_ex[0].'`.';
				}else{
					$filedName = $groupData;
					$define = '';
				}
				
				if($m != sizeof($group)){
					$group_all .= $define."`".trim($filedName)."`, ";	
				}else{
					$group_all .= $define."`".trim($filedName)."` ";	
				}
							
				$m++;
			}
			$this->group_data = 'GROUP BY '.trim($group_all, ', ');
		}else{
			if(strlen(trim($group)) > 1){
				$this->group_data = 'GROUP BY '.trim($group);
			}
		}
		return $this;
	}
	
	/**
	###Database Group By for PDO
	**/
	public function having_sub($sub = array()){
		$this->sub_having = '';
		if(is_array($sub) AND sizeof($sub) > 0){
			$sub_select_data = '';
			$m = 1;
			foreach($sub AS $index=>$data):
				if(strlen(trim($index)) > 0){
					if($m != sizeof($sub)){
						$sub_select_data .= $index."(`".$data."`), ";
					}else{
						$sub_select_data .= $index."(`".$data."`) ";
					}		
					$m++;
				}
			
			endforeach;
			$this->sub_having = trim($sub_select_data, ', ');
		}
		return $this->sub_having;
	}
	
	public function having($having = array()){
		$this->having_data = '';
		if(is_array($having) AND sizeof($having) > 0){
			$have_all = '';
			foreach($having AS $index=>$groupData){
				if(strlen(trim($index)) > 0){
					
					$as_data = explode('.', trim($index));
					if(is_array($as_data) AND sizeof($as_data) > 1){
						$index = $as_data[1];
						$define = '`'.$as_data[0].'`.';
					}else{
						$define = '';
					}
					
					$coloumn = '';
					$operator = ' = ';
					$check = $this->get_sub_check($groupData);							
					$checkData = $this->get_sub_check_data($groupData);							
					$index_ex = explode(' ', trim($index));
					if(is_array($index_ex) AND sizeof($index_ex) > 1){
						if(strlen(trim($index_ex[0])) > 0):
							$have_all .= $define."`".trim($index_ex[0])."` ".trim($index_ex[1])." ".trim($checkData)." ".$check." ";
						endif;
					}else{
						if(strlen(trim($index_ex[0])) > 0):
							$have_all .= $define."`".trim($index_ex[0])."` ".trim($operator)." ".trim($checkData)." ".$check." ";
						endif;
					}
				}				
			}
			$this->having_data .= 'HAVING '.trim($have_all, ''.$check.' ');
		}else{
			if(strlen(trim($having)) > 1){
				$this->having_data .= 'HAVING '.$this->htmlChar($having);
			}
		}
		/*
		if(strlen($this->sub_having) > 0 AND strlen($this->having_data) > 5){
			$this->having_data .= ' AND '.$this->sub_having;
		}
		*/
		return $this;
	}
	
	
	/*Join Data*/
	private function get_sub_check_data_join($data=''){
		if(is_array($data) AND sizeof($data) > 0){
			if(is_array($data[0]) AND sizeof($data[0]) > 0){
				$value = $data[0][0];
				$as_data = explode('.', trim($value));
				if(is_array($as_data) AND sizeof($as_data) > 1){
					$index = $as_data[1];
					$define = '`'.$as_data[0].'`.';
				}else{
					$define = '';
					$index = $value;
				}
				return $define."`".$this->htmlChar($index)."`"; 
			}else{
				return "'".$this->htmlChar($data[0])."'"; 
			}
		}else{
			$as_data = explode('.', trim($data));
			if(is_array($as_data) AND sizeof($as_data) > 1){
				$data = $as_data[1];
				$define = '`'.$as_data[0].'`.';
			}else{
				$define = '';
			}
			return $define."`".$this->htmlChar($data)."`";
		}
	}
	
	public function join_where($type='INNNER', $table, $query= array()){
		$mass = 0;
		$this->join_data = '';
		if(strlen(trim($table)) > 2){
			$this->join_data .= strtoupper( $type ).' JOIN '."`".$table."`";
		}else{
			$mass = 1;
		}
		
		if(is_array($query) AND sizeof($query) > 0){
			$this->join_data .= ' ON ';
			$whereData = '';
			$m = 1;
			foreach($query AS $index=>$value):
				$check = '';			
				if(strlen(trim($index)) > 0){
					$coloumn = '';
					$operator = ' = ';
					if($m != sizeof($query)):
						$check = $this->get_sub_check($value);
					endif;	

					$as_data = explode('.', trim($index));
					if(is_array($as_data) AND sizeof($as_data) > 1){
						$index = $as_data[1];
						$define = '`'.$as_data[0].'`.';
					}else{
						$define = '';
					}
					
					$checkData = $this->get_sub_check_data_join($value);							
					$index_ex = explode(' ', trim($index));
					if(is_array($index_ex) AND sizeof($index_ex) > 1){
						if(strlen(trim($index_ex[0])) > 0):
							$whereData .= $define."`".trim($index_ex[0])."` ".trim($index_ex[1])." ".trim($checkData)." ".$check." ";
						endif;
					}else{
						if(strlen(trim($index_ex[0])) > 0):
							$whereData .= $define."`".trim($index_ex[0])."` ".trim($operator)." ".trim($checkData)." ".$check." ";
						endif;
					}
				$m++;
				}
					
			endforeach;
			$this->join_data .= $whereData;
		}
		return $this;
	}
	
	/*Fetch Data*/
	
	private function fetchData($print=0){
		$error = 0;
		$query = '';
		$this->query = '';
		
		/*Data Select option*/
		if(strlen(trim($this->select_data)) > 1){
			$query .= $this->select_data.' ';
		}else{
			$query .= 'SELECT * ';
		}
		
		/*Data Select Sub option*/
		/*if(strlen(trim($this->sub_select)) > 0){
			if(strlen(trim($this->select_data)) > 1){
				$query .= ', '.$this->sub_select.' ';
			}else{
				$query .= $this->sub_select.' ';
			}
			
		}else{
			if(strlen(trim($this->select_data)) > 1){
				
			}else{
				$query .= '* ';
			}
		}*/
		
		
		/*Data From option*/
		if(strlen(trim($this->from_data)) > 1){
			$query .= $this->from_data.' ';
		}else{
			$error = 1;
			$query .= 'FROM ';
		}
		
		/*Join section*/
		if(strlen(trim($this->join_data)) > 1){
			$query .= ' '.$this->join_data.' ';
		}
		
		/*Data Where option*/
		if(strlen(trim($this->where_data)) > 7){
			$query .= $this->where_data.' ';
		}else{
			$query .= 'WHERE 1 = 1';
		}
		
		/*GROUP by section*/
		if(strlen(trim($this->group_data)) > 1){
			$query .= ' '.$this->group_data.' ';
		}
		
		/*Having section*/
		if(strlen(trim($this->having_data)) > 1){
			$query .= ' '.$this->having_data.' ';
		}
		
		/*Order by section*/
		if(strlen(trim($this->order_data)) > 1){
			$query .= ' '.$this->order_data.' ';
		}
		
		/*Limit section*/
		if(strlen(trim($this->limit_data)) > 1){
			$query .= ' '.$this->limit_data.' ';
		}
		
		if($print == 1){
			return $query;
		}else{
			return $this->query($query);
		}
		
	}
	
	public function fetch(){
		$dataFetch = $this->fetchData();
		return $dataFetch->result();
	}
	
	
	public function fetch_once(){
		$dataFetch = $this->fetchData();
		return $dataFetch->result_once();
	}
	
	/**
	###Database query for PDO
	**/
	
	/*Query Start*/
	
	
	public function query_close(){
		$this->sub_select = '';
		$this->select_data = '';
		$this->from_data = '';
		$this->where_data = '';
		$this->order_data = '';
		$this->limit_data = '';
		$this->group_data = '';
		$this->having_data = '';
		$this->query = '';
		$this->join_data = '';
		return $this;
	}
	
	/*Query Print*/
	public function query_print(){
		$data = $this->print_query;
		echo $data;
	}
	
	public function query($query = ''){
		$query = $this->htmlChar($query);
		$this->query = '';
		$this->print_query = $query;
		if(strlen($query) > 5){
			$this->con->prepare("SET CHARACTER SET utf8");
			$this->con->prepare("SET SESSION collation_connection ='utf8_general_ci'");
			$this->query = $this->con->prepare($query);
			return $this;
		}else{
			return $this;
		}
	}
	
	/*****
	### Fetch all data
	****/
	
	public function result($type=''){
		if(is_object($this->query)){
			$this->query->execute();
			if($type == 'column'){
				return $this->query->fetchAll(PDO::FETCH_COLUMN);
			}else if($type == 'group'){
				return $this->query->fetchAll(PDO::FETCH_GROUP);
			}else if($type == 'column_group'){
				return $this->query->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
			}else{
				return $this->query->fetchAll();
			}			
		}else{
			return array();
		}
	}
	/*****
	### Fetch all once
	****/
	public function result_once($type=''){
		if(is_object($this->query)){
			$this->query->execute();
			if($type == 'assoc'){
				return $this->query->fetch(PDO::FETCH_ASSOC);
			}else if($type == 'both'){
				return $this->query->fetch(PDO::FETCH_BOTH);
			}else if($type == 'lazy'){
				return $this->query->fetch(PDO::FETCH_LAZY);
			}else{
				return $this->query->fetch();
			}
		}else{
			return array();
		}
	}
	
	
	/*****Last insert id**/
	
	public function last_insert_id(){
		if(is_object($this->query)){
			$this->query->execute();
			return $this->con->lastInsertId();		
		}else{
			return 0;
		}
	}
	/***** insert data**/
	
	public function insert($table, array $data){
		$insert = '';
		$insert1 = '';
		$tableData = '';
		if(strlen(trim($table)) > 1){
			$tableData = trim($table);
		}
		if(is_array($data) AND sizeof($data)>0){
			$insert .= '(';
			$insert1 .= 'VALUES(';
				foreach($data as $field=>$value){
					$insert .='`'.$field.'`,';
					$insert1 .="'".$value."',";
				}
				$insert = rtrim($insert, ',');
				$insert1 = rtrim($insert1, ',');
				$insert .= ')';
				$insert1 .= ')';				
			
			
			$this->query("INSERT INTO `$tableData` $insert $insert1");
			return $this->query->execute();
		}else{
			return false;
		}
		
	}
	
	
	#----------------- update Data ---------#
	 public function update($table, array $data, $query=array()){
		/****query section start **********/
			$where = $this->where($query, 'return');
			$set = '';
			
			if(is_array($data)){
				$set .= 'SET ';
					foreach($data as $field=>$value){
						//$set .='`'.$field.'` = "'.$value.'",';
						$set .= '`'.$field.'` = ';
						$set .= "'".$value."',";
					}
					$set = rtrim($set, ',');
			}else{
				$set = '';
			}
			//echo $where;exit;
			/*****  start table select *****/
			$tableData = '';
			if(strlen(trim($table)) > 1){
				$tableData = trim($table);
			}
		$this->query("UPDATE `$tableData` $set $where");
		return $this->query->execute();
	}
	
	
	#----------------- delete Data ---------#
	public function delete($table, $query= array()){
		/****query section start **********/
			$where = $this->where($query);
			$tableData = '';
			if(strlen(trim($table)) > 1){
				$tableData = trim($table);
			}
		$this->query("DELETE FROM `$tableData` $where");
		return $this->query->execute();
	}
	#----- delete data end ---------#
	
	public function num_rows(){
		if(is_object($this->query)){
			$this->query->execute();
			return $this->query->rowCount();		
		}else{
			return 0;
		}
	}
}
?>