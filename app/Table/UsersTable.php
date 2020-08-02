<?php

namespace app\Table;

use core\Table\MainTable;
use app\Manager;

/**
 * 
 */
class UsersTable extends MainTable{
	

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