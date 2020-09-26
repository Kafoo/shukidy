<?php

namespace app\Table;

use core\Table\MainTable;
use app\Manager;

/**
 * 
 */
class UsersTable extends MainTable{
	

	protected $table_name = 'users';

	public function findByName($username){
		$data = $this->query("
			SELECT *
			FROM {$this->table_name}
			WHERE username = ?",
			[$username], true);
		return $data;
	}

	public function findCharacters($userID){

		$data = $this->query("
			SELECT
			user.id,
			user.username,
			user.password,
			user.mail,
			user.grade,
			user.msgCount,
			characters.userID,
			characters.name,
			characters.lvl,
			characters.xp,
			characters.nature,
			characters.attitude,
			characters.concept,
			characters.defaut,
			characters.physique,
			characters.avID,
			characters.univID,
			characters.raceID,
			characters.classeID,
			characters.c1,
			characters.c2,
			characters.c3,
			characters.c4,
			characters.c5,
			characters.c1Cond,
			characters.c2Cond,
			characters.c3Cond,
			characters.c4Cond,
			characters.c5Cond,
			characters.lore,
			characters.pv,
			characters.invent1,
			characters.invent2,
			characters.invent3,
			characters.invent4,
			characters.invent5,
			characters.active
			FROM {$this->table_name} as user
			JOIN characters
			ON characters.userID = user.id
			WHERE user.id = ?",
			[$userID]);
		return $data;
	}

}

?>