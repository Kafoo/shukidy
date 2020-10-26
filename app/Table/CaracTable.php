<?php

namespace app\Table;

use app\Table\AppTable;
/**
 * 
 */
class CaracTable extends AppTable{


	protected $table_name = 'carac';

	public function update($carac){

		

		$res = $this->query("
			UPDATE {$this->table_name}
			SET num = ?,
			name = ?,
			color = ?,
			icon = ?
			WHERE id = ?",
			[$this->encodeSQL($carac->num), 
			$this->encodeSQL($carac->name), 
			$this->encodeSQL($carac->color), 
			$this->encodeSQL($carac->icon),
			 $this->encodeSQL($carac->id)]);

	}

	public function findByUniv($univID){

		$data = $this->query("
			SELECT carac.*
			FROM {$this->table_name} as carac
			WHERE carac.univID = ?
			ORDER BY num",
			[$univID]);
		return $data;
	}


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

	public function findByChar($charID){

		$data = $this->query("
			SELECT carac.*, rel.*, carac.id as id
			FROM {$this->table_name} as carac
			JOIN rel_char2carac as rel
			ON carac.id = rel.caracID
			WHERE rel.charID = ?",
			[$charID]);
		return $data;
	}

}

?>