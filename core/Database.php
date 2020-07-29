<?php

namespace core;

use \PDO;

class Database{

	private $db_name;
	private $db_user;
	private $db_pass;
	private $db_host; 
	private $pdo;

	public function __construct($db_name, $db_user, $db_pass, $db_host){
		$this->db_name = $db_name;
		$this->db_user = $db_user;
		$this->db_pass = $db_pass;
		$this->db_host = $db_host; 
	}

	private function getPDO(){
		if ($this->pdo === null) {
			$pdo = new PDO('mysql:host=127.0.0.1;dbname=heroku_3ca6f2b572bf369', "root", "");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo = $pdo;
		}
		return $this->pdo;
	}

	public function directQuery($statement, $class = null, $one = false){
		$req = $this->getPDO()->query($statement);

		if ($class === null) {
			$req->setFetchMode(PDO::FETCH_OBJ);
		}else{
			$class = '\\'.$class;
			$req->setFetchMode(PDO::FETCH_CLASS, $class);
		}
		if ($one) {
			$data = $req->fetch();
		}else{
			$data = $req->fetchall();
		}
		return $data;
	}


	public function prepare($statement, $values, $class = null, $one = false){
		
		$req = $this->getPDO()->prepare($statement);

		$res = $req->execute($values);
		if (strpos($statement, "INSERT") === 0 
		|| strpos($statement, "DELETE") === 0
		|| strpos($statement, "UPDATE") === 0) {
			return $res;
		}

		if ($class === null) {
			$req->setFetchMode(PDO::FETCH_OBJ);
		}else{
			$class = '\\'.$class;
			$req->setFetchMode(PDO::FETCH_CLASS, $class);
		}


		if ($one) {
			$data = $req->fetch();
		}else{
			$data = $req->fetchall();
		}
		return $data;
	}
}

?>