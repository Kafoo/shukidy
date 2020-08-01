<?php

namespace app\Table;

use core\Table\MainTable;
use app\Manager;
/**
 * 
 */
class AventuresTable extends MainTable{


	protected $table_name = 'aventures';


	public function getAll(){
		$data = $this->query("
			SELECT 
			av.id, av.name as name, av.visibility, 
			univ.name as univ_name,
			users.username as gm_name
			FROM {$this->table_name} as av
			JOIN mas_univers as univ
			ON univ.id = av.univID
			JOIN users
			ON av.gmID = users.id
			");
		return $data;
	}

	public function find($avId){
		echo "AventuresTable.find --- ";
		$data = $this->query("
			SELECT *
			FROM {$this->table_name}
			WHERE id = ?",
			[$avId], true);
		return $data;
	}

}

?>