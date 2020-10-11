<?php

namespace app\Table;

use app\Table\AppTable;
use app\Manager;

/**
 * 
 */
class NotesTable extends AppTable{
	
	protected $table_name = 'notes';	


	public function update($avID, $userID, $content){

		$this->query("
			UPDATE {$this->table_name} 
			SET content = ?
			WHERE avID = ? and userID = ?",
			[$content, $avID, $userID]);

	}

	public function getByUserAndAv($userID, $avID){

		$res = $this->query("
			SELECT *
			FROM {$this->table_name}
			WHERE userID = ? AND avID = ?", 
			[$userID, $avID], true);
		return $res;

	}

}


?>