<?php

namespace app\Table;

use app\Table\AppTable;
use app\Manager;

/**
 * 
 */
class CharactersTable extends AppTable{
	

	protected $table_name = 'characters';

	public function add($char){

		$this->query("
			INSERT INTO {$this->table_name}
			(userID, name, nature, attitude, concept, defaut, physique, univID, raceID, classeID, lore)
			VALUES 
			(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
			[$char->userID, $char->name, $char->nature, $char->attitude, $char->concept, $char->defaut, $char->physique, $char->univID, $char->raceID, $char->classeID, $char->lore]);

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

	public function findByUser($userID){
		$res = $this->query("
			SELECT *
			FROM {$this->table_name}
			WHERE userID = ?", 
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

	public function findUserChar($avID){

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