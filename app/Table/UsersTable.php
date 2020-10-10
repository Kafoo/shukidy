<?php

namespace app\Table;

use app\Table\AppTable;
use app\Manager;

/**
 * 
 */
class UsersTable extends AppTable{
	

	protected $table_name = 'users';

	public function findByName($username){
		$data = $this->query("
			SELECT *
			FROM {$this->table_name}
			WHERE username = ?",
			[$username], true);
		return $data;
	}

}

?>