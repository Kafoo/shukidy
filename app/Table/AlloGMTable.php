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

	public function getAllByUsers($userID, $gmID){

		$res = $this->query("
			SELECT *
			FROM {$this->table_name} as allo
			WHERE fromID = ? AND toID = ?
			OR fromID = ? AND toID = ?
			ORDER BY allo.id", 
			[$userID, $gmID, $gmID, $userID]);
		return $res;

	}

}


?>