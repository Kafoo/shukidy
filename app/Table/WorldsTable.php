<?php

namespace app\Table;

use app\Table\AppTable;
use app\Manager;

/**
 * 
 */
class WorldsTable extends AppTable{
	
	protected $table_name = 'worlds';


	public function edit($what, $worldID, $value){

		$value = str_replace( "\n", '<br />', $value );

		$res = $this->query("
			UPDATE {$this->table_name}
			SET {$what} = ?
			WHERE id = ?",
			[$value, $worldID]);
	}


}
?>