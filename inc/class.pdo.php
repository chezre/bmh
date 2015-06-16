<?php

class pdo_functions {
	
	var $host;
	var $user;
	var $password;
	var $database;
	var $connection;
	var $lastError;
	
	function connect() {
		try {
		    $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, $this->password);
			return true;
		} catch (PDOException $pe) {
		    $this->connection = "Could not connect to the database {$this->database} :" . $pe->getMessage();
			return false;
		}
		
	}
	
	function select($sql) {
		
		$sqlOk = $this->parseSql($sql);
		if (!$sqlOk) return false;
		
		$result = array();
		$q = $this->connection->query($sql); 
		
		try {
			if ($q->rowCount()>0) {
				$q->setFetchMode(PDO::FETCH_ASSOC);
			} else {
				return false;
			}
		} catch (exception $ex){
			return false;
		}
		while ($row = $q->fetch()) $result[] = $row;
		return $result;
		
	}
	
	function parseSql($sql) {
		$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
		$stmt = $this->connection->prepare($sql);
		if (!$stmt) {
		    $this->lastError = $this->connection->errorInfo();
			return false;
		}
		return true;
	}
	
	function execute($sql) {
		$sqlOk = $this->parseSql($sql);
		if (!$sqlOk) return false;
		return $this->connection->exec($sql);
	}
	
}



?>