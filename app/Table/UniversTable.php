<?php

namespace app\Table;

use app\Table\AppTable;
use app\Manager;

/**
 * 
 */
class UniversTable extends AppTable{
	
	protected $table_name = 'univers';


	public function edit($what, $univID, $value){

		$res = $this->query("
			UPDATE {$this->table_name}
			SET {$what} = ?
			WHERE id = ?",
			[$value, $univID]);
	}


}
?>