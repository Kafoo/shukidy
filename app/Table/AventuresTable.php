<?php

namespace app\Table;

use app\Table\AppTable;
/**
 * 
 */
class AventuresTable extends AppTable{


	protected $table_name = 'aventures';


	public function getAll(){

		$data = $this->query("
			SELECT 
			av.id, av.name as name, av.visibility,  av.description, av.worldID,
			univ.name as univ_name,
			users.username as gm_name
			FROM {$this->table_name} as av
			JOIN worlds as univ
			ON univ.id = av.worldID
			JOIN users
			ON av.gmID = users.id
			");
		return $data;
	}

	public function find($avId){

		$data = $this->query("
			SELECT *
			FROM {$this->table_name}
			WHERE id = ?",
			[$avId], true);
		return $data;
	}

}

?>