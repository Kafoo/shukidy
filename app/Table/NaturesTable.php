<?php

namespace app\Table;

use app\Table\AppTable;
use app\Manager;

/**
 * 
 */
class NaturesTable extends AppTable{
	

	protected $table_name = 'natures';


	public function remove($natureID){

		//On supprime la nature
		$this->query("
			DELETE FROM {$this->table_name}
			WHERE id = ?",
			[$natureID]);

		//On cherche les pouvoirs lui sont lié
		$powers = $this->query("
			SELECT p.id
			FROM powers as p
			JOIN rel_natures2powers as n2p
			ON n2p.powerid = p.id
			WHERE n2p.natureID = ?",
			[$natureID]);

		if (count($powers) > 0) {

			$powerIDArray = [];
			foreach ($powers as $power) {
				array_push($powerIDArray, $power->id);
			}
			$powerIDJoined = join(",", $powerIDArray);

			//On les supprime
			$this->query("
				DELETE FROM powers
				WHERE id IN ($powerIDJoined)");

			//On supprime leurs relations avec cette nature
			$this->query("
				DELETE FROM rel_natures2powers
				WHERE powerID IN ($powerIDJoined)");
		}


		//On supprime la relation de la nature avec l'univers
		$this->query("
			DELETE FROM rel_univ2natures
			WHERE natureID = ?",
			[$natureID]);

	}

	public function add($univID, $nature){

		$nature->uniqID = uniqid();

		//On ajoute la nature à la bdd
		$this->query("INSERT INTO {$this->table_name}
			(name, description, type, icon, uniqID)
			VALUES (?, ?, ?, ?, ?)",
			[$nature->name, $nature->description, $nature->type, $nature->icon, $nature->uniqID]);

		//On lie la nature à l'univers
		$nature->id = $this->findByUniqID($nature->uniqID)->id;
		$this->query("INSERT INTO rel_univ2natures
			(univID, natureID)
			VALUES (?, ?)",
			[$univID, $nature->id]);

	}

	public function edit($nature){
		$res = $this->query("
			UPDATE {$this->table_name}
			SET name = ?,
			description = ?,
			icon = ?
			WHERE id = ?",
			[$nature->name, $nature->description, $nature->icon, $nature->id]);
	}

	public function findByNameAndUniv($name, $univID){
		$data = $this->query("
			SELECT *
			FROM {$this->table_name} as nat
			JOIN rel_univ2natures as u2n 
			ON nat.id = u2n.natureID
			WHERE u2n.univID = ? AND nat.name = ?",
			[$univID, $name]);
		return $data;
	}

	public function findByUniv($univID, $type){
		$data = $this->query("
			SELECT nat.id, name, description, icon
			FROM {$this->table_name} as nat
			JOIN rel_univ2natures as u2n 
			ON nat.id = u2n.natureID
			WHERE u2n.univID = ? AND nat.type = ?",
			[$univID, $type]);
		return $data;
	}

	public function charHasNature($natureID){
		$data = $this->query("
			SELECT *
			FROM characters
			WHERE raceID = ?
			OR classeID = ?",
			[$natureID, $natureID]);
		return $data;
	}

	public function findByChar($charID){
		$data = $this->query("
			SELECT nat.id, nat.name, nat.description, nat.icon, nat.type
			FROM {$this->table_name} as nat
			JOIN characters as ch 
			ON nat.id = ch.raceID
			OR nat.id = ch.classeID
			WHERE ch.id = ?",
			[$charID]);
		return $data;
	}

}

?>