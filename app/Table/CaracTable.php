<?php

namespace app\Table;

use core\Table\MainTable;
/**
 * 
 */
class CaracTable extends MainTable{


	protected $table_name = 'carac';


	public function findByAv($avID){

		$data = $this->query("
			SELECT carac.*
			FROM {$this->table_name} as carac
			JOIN aventures as av
			ON carac.univID = av.univID
			WHERE av.id = ?",
			[$avID]);
		return $data;
	}

}

?>