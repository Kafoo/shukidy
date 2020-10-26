<?php

namespace core\Table;

use core\Database;
/**
 * 
 */
class MainTable
{

	protected $table_name;
	protected $db;

	public function __construct(Database $db = null){
		
		$this->db = $db;

		if (is_null($this->table_name)) {
			$parts = explode('\\', get_class($this));
			$name = str_replace('Table', '', end($parts));
			$this->table_name = strtolower($name);
		}
	}


	public function encodeSQL($data){
		return nl2br(htmlspecialchars($data, ENT_QUOTES));
	}

	public function query($statement, $values = false, $one = false){

		$entity_name = str_replace('Table', 'Entity', get_class($this));
		if ($values) {
/*			foreach ($values as $key => $value) {
				$values[$key] = $this->encodeSQL($value);
			}*/
			$data = $this->db->prepare($statement, 
				$values , $entity_name, $one);
		}else{
			$data = $this->db->directQuery($statement, $entity_name, $one);		
		}

		return $data;
	}

	public function getAll(){
		$data = $this->query("
			SELECT * 
			FROM {$this->table_name} ");
		return $data;
	}

	protected function findByUniqID($uniqID){
		$data = $this->query("
			SELECT id
			FROM {$this->table_name}
			WHERE uniqID= ?",
			[$uniqID], true);
		return $data;
	}

	public function find($id){
    		$data = $this->query("
			SELECT *
			FROM {$this->table_name}
			WHERE id = ?",
			[$id], true);
		return $data;
	}

	public function delete($id){

		$statement = "DELETE FROM {$this->table_name} WHERE id = ?
		";

		return $this->query($statement, [$id], true);
	}



}

?>