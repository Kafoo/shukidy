<?php

namespace app\Table;

use app\Table\AppTable;
use app\Manager;

/**
 * 
 */
class NaturesTable extends AppTable{
	

	protected $table_name = 'natures';

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