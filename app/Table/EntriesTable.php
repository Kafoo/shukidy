<?php

namespace app\Table;

use core\Table\MainTable;
use app\Manager;

/**
 * 
 */
class EntriesTable extends MainTable{
	
	protected $table_name = 'av_entries';
	private $rp_table = 'av_rp';
	private $dicerolls_table = 'av_dicerolls';
	private $log_table = 'av_log';
	private $av_table = 'aventures';
	private $users_table = 'users';
	private $characters_table = 'characters';
	private $carac_table = 'carac';

	private function formatContent($res){

		foreach ($res as $key => $value) {
			$value->content = htmlspecialchars_decode(nl2br($value->content));
		}
		return $res;
	}


	public function getAllByAv($avID){
		$res = $this->query("
			SELECT 
			ent.*,
			rp.content as content, 
			dr.*,
			carac.name as caracName,
			av.id as avID, av.name as avName,
			user.username, user.id as userID,
			ch.name as chName
			FROM {$this->table_name} as ent
			LEFT JOIN {$this->rp_table} as rp
			ON ent.id = rp.entryID
			LEFT JOIN {$this->dicerolls_table} as dr
			ON ent.id = dr.entryID
			LEFT JOIN {$this->carac_table} as carac
			ON dr.caracID = carac.id
			LEFT JOIN {$this->log_table} as log
			ON ent.id = log.entryID
			LEFT JOIN {$this->av_table} as av
			ON ent.avID = av.id
			LEFT JOIN {$this->characters_table} as ch
			ON ent.characterID = ch.id
			LEFT JOIN {$this->users_table} as user
			ON ch.userID = user.id
			WHERE av.id = ?
			ORDER BY ent.id", 
			[$avID]);
		return $this->formatContent($res);
	}
}

?>