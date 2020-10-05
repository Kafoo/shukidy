<?php

namespace app\Table;

use core\Table\MainTable;
use app\Manager;

/**
 * 
 */
class CharactersTable extends MainTable{
	

	protected $table_name = 'characters';


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
			JOIN mas_leveling as lvl
			ON lvl.lvl = ch.lvl
			WHERE ch.avID = ?", 
			[$avID]);
		return $res;	
	}

	public function findUserChar($avID){

		$userID = $_SESSION['auth'];

		$res = $this->query("
			SELECT *, ch.id as id
			FROM {$this->table_name} as ch
			WHERE ch.avID = ? AND ch.userID = ?", 
			[$avID, $userID], true);
		return $res;	
	}

}

?>