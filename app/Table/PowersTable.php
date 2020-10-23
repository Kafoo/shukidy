<?php

namespace app\Table;

use app\Table\AppTable;
use app\Manager;

/**
 * 
 */
class PowersTable extends AppTable{
	

	protected $table_name = 'powers';

	public function findByNature($natureID){
		$data = $this->query("
			SELECT  p.id, name, description, icon
			FROM {$this->table_name} as p
			JOIN rel_natures2powers as n2p 
			ON p.id = n2p.powerID
			WHERE n2p.natureID = ?",
			[$natureID]);
		return $data;
	}

}

?>