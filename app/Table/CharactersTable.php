<?php

namespace App\Table;

use Core\Table\MainTable;
use App\Manager;

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