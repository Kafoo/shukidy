<?php

namespace app\Table;

use core\Table\MainTable;
use app\Manager;

/**
 * 
 */
class CharactersTable extends MainTable{
	

	protected $table_name = 'characters';


	public function getAllByUser($userID){
		$res = $this->query("
			SELECT *
			FROM {$this->table_name}
			WHERE userID = ?", 
			[$userID]);

		return $res;
	}

}

?>