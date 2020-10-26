<?php

namespace app\Table;

use app\Table\AppTable;
use app\Manager;

/**
 * 
 */
class PowersTable extends AppTable{
	

	protected $table_name = 'powers';

	public function remove($powerID){

		//On supprime le pouvoir
		$this->query("
			DELETE FROM {$this->table_name}
			WHERE id = ?",
			[$powerID]);

		//On supprime sa relation avec les natures
		$this->query("
			DELETE FROM rel_natures2powers
			WHERE powerID = ?",
			[$powerID]);

	}

	public function add($univID, $natureID, $power){

		$power->uniqID = uniqid();

		//On ajoute le power à la bdd
		$this->query("INSERT INTO {$this->table_name}
			(name, description, type, lvl, uniqID)
			VALUES (?, ?, ?, ?, ?)",
			[$power->name, $power->description, $power->type, $power->lvl, $power->uniqID]);

		//On lie le power à la nature
		$power->id = $this->findByUniqID($power->uniqID)->id;
		$this->query("INSERT INTO rel_natures2powers
			(natureID, powerID)
			VALUES (?, ?)",
			[$natureID, $power->id]);

	}

	public function edit($power){
		$res = $this->query("
			UPDATE {$this->table_name}
			SET name = ?,
			description = ?
			WHERE id = ?",
			[$power->name, $power->description, $power->id]);
	}

	public function findByNameAndNature($name, $natureID){
		$data = $this->query("
			SELECT *
			FROM {$this->table_name} as p
			JOIN rel_natures2powers as n2p 
			ON p.id = n2p.powerID
			WHERE n2p.natureID = ? AND p.name = ?",
			[$natureID, $name]);
		return $data;
	}

	public function findByNature($natureID){
		$data = $this->query("
			SELECT  p.id, name, description
			FROM {$this->table_name} as p
			JOIN rel_natures2powers as n2p 
			ON p.id = n2p.powerID
			WHERE n2p.natureID = ?",
			[$natureID]);
		return $data;
	}

	public function charHasPower($powerID){
		$data = $this->query("
			SELECT *
			FROM rel_char2powers
			WHERE powerID = ?",
			[$powerID]);
		return $data;
	}

	public function findByChar($charID){
		$data = $this->query("
			SELECT p.id, p.name, p.description, p.type
			FROM {$this->table_name} as p
			JOIN rel_char2powers as c2p
			ON p.id = c2p.powerID
			WHERE c2p.charID = ?",
			[$charID]);
		return $data;
	}

}

?>