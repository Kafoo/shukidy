<?php

namespace app\Table;

use app\Table\AppTable;
use app\Manager;

/**
 * 
 */
class AlloGMTable extends AppTable{
	
	protected $table_name = 'allogm';	


	public function add($avID, $fromID, $toID, $content){

		$this->query("
			INSERT INTO {$this->table_name} 
			(avID, fromID, toID, content, dat)
			VALUES 
			(?, ?, ?, ?, NOW())",
			[$avID, $fromID, $toID, $content]);

	}

	public function getByUsersAndAv($userID, $gmID, $avID){

		$res = $this->query("
			SELECT *
			FROM {$this->table_name} as allo
			WHERE fromID = ? AND toID = ? AND avID = ?
			OR fromID = ? AND toID = ? AND avID = ?
			ORDER BY allo.id", 
			[$userID, $gmID, $avID, $gmID, $userID, $avID]);
		return $res;

	}

}


?>