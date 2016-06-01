<?php
/************************************************************\
 *
 * File					mysqlconnection.php
 *
 * Language		PHP
 *
 * Author			David Mack
 * Creation			24 mai 2016
 * modification 
 *
 * Project			orgapha
 *
 \************************************************************/

class MySqlConnection {
	const HOST = "127.0.0.1";
	const PORT = "3306";
	const DATABASE = "orgapha";
	const USER = "root";
	//const PWD = "GNPJyfnSsCXxcJ3x";
	const PWD = '';
	private $_connection;
	
	public function __construct() {
		try {
			$this->_connection = new PDO('mysql:host=' . self::HOST . 
										//'; port =' . self::PORT .
										'; dbname=' . self::DATABASE, self::USER, self::PWD);
		} catch (PDOException $e) {
			die ('Connection failed: ' . $e->getMessage());
		}
	}
	
	public function getConnection() {
		if(!isset($this->_connection) || $this->_connection == null)
			new MySqlConnection();
		
		return $this->_connection;
	}
	
	public function selectDB($query){
		$result= $this->getConnection()->query($query)
		or die (print_r($this->getConnection()->errorInfo(), true));
	
		return $result;
	}
	
	public function executeQuery($query)
	{	
		$result =$this->getConnection()->exec($query);
		$e = $this->getConnection()->errorInfo();
		var_dump($query);
	
		if($e[1]!=null){
			if($e[1] == 1062) //test if username already exist
				return 'doublon';
				else
					die(print_r($this->getConnection()->errorInfo(), true));
		}
	
	
		return $result;
	}	
}
?>