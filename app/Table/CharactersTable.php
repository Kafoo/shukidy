<?php

namespace app\Table;

use app\Table\AppTable;
use app\Manager;

/**
 * 
 */
class CharactersTable extends AppTable{
	

	protected $table_name = 'characters';




	public function remove($charID){

		$this->query("
			DELETE FROM {$this->table_name}
			WHERE id = ?",
			[$charID]);

		$this->query("
			DELETE FROM rel_char2powers
			WHERE charID = ?",
			[$charID]);		

		$this->query("
			DELETE FROM rel_char2carac
			WHERE charID = ?",
			[$charID]);

	}

	public function add($char){

		$this->query("
			INSERT INTO {$this->table_name}
			(userID, name, nature, attitude, concept, defaut, univID, raceID, classeID, lore)
			VALUES 
			(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
			[$char->userID, $char->name, $char->nature, $char->attitude, $char->concept, $char->defaut, $char->univID, $char->raceID, $char->classeID, $char->lore]);

		$userChars = $this->findByUser($char->userID);
		$last = end($userChars);

		$char->id = $last->id;

		$this->query("
			INSERT INTO rel_char2powers
			(charID, powerID)
			VALUES 
			(?, ?)",
			[$char->id, $char->capaID]);

		$this->query("
			INSERT INTO rel_char2powers
			(charID, powerID)
			VALUES 
			(?, ?)",
			[$char->id, $char->discID]);

		foreach ($char->caracs as $key => $value) {

			$this->query("
				INSERT INTO rel_char2carac
				(charID, caracID, value)
				VALUES 
				(?, ?, ?)",
				[$char->id, $key, $value]);
		}


	}

	public function findByUniv($univID){

		$data = $this->query("
			SELECT *
			FROM {$this->table_name}
			WHERE univID = ?",
			[$univID]);
		return $data;
	}

	public function find($charID){
		$res = $this->query("
			SELECT *, ch.id as id
			FROM {$this->table_name} as ch
			JOIN leveling as lvl
			ON lvl.lvl = ch.lvl
			WHERE ch.id = ?", 
			[$charID], true);
		return $res;
	}

	public function findByName($name){
		$res = $this->query("
			SELECT *
			FROM {$this->table_name}
			WHERE name = ?", 
			[$name], true);
		return $res;
	}


	public function findByUser($userID){
		$res = $this->query("
			SELECT *, ch.id as id
			FROM {$this->table_name} as ch
			JOIN leveling as lvl
			ON lvl.lvl = ch.lvl
			WHERE userID = ?
			ORDER BY ch.id", 
			[$userID]);
		return $res;
	}

	public function findByAv($avID){
		$res = $this->query("
			SELECT *, ch.id as id
			FROM {$this->table_name} as ch
			JOIN rel_char2av as c2a
			ON c2a.charID = ch.id
			JOIN leveling as lvl
			ON lvl.lvl = ch.lvl
			WHERE c2a.avID = ?", 
			[$avID]);
		return $res;	
	}

	public function findByUserAndAv($avID){

		$userID = $_SESSION['auth'];

		$res = $this->query("
			SELECT *, ch.id as id
			FROM {$this->table_name} as ch
			JOIN rel_char2av as c2a
			ON c2a.charID = ch.id
			WHERE c2a.avID = ? AND ch.userID = ?", 
			[$avID, $userID], true);
		return $res;	
	}

}

?>