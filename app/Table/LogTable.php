<?php

namespace app\Table;

use app\Table\AppTable;
/**
 * 
 */
class LogTable extends AppTable{

	protected $table_name = 'log';

	public function add($msg){

		$this->query("
			INSERT INTO {$this->table_name}
			(content, dat)
			VALUES 
			(?, NOW())",
			[$msg]);

	}

}

?>