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

	private function addRp($entry){

		$last = $this->lastByAv($entry->avID);

		$this->query("
			INSERT INTO 
			av_rp (entryID, charID, content)
			VALUES 
			(?, ?, ?)",
			[$last->id, $entry->charID, $entry->content]);
	}

	private function addDr($entry){

		$last = $this->lastByAv($entry->avID);

		$this->query("
			INSERT INTO 
			av_dicerolls (entryID, charID, title, caracID, caracVal, caracCond, difficulty, result, GM)
			VALUES 
			(?, ?, ?, ?, ?, ?, ?, ?, ?)",
			[$last->id, $entry->charID, $entry->title, $entry->caracID, $entry->caracVal, $entry->caracCond, $entry->diff, $entry->result, $entry->GM]);
	}

	

	public function add($entry){

		$this->query("
			INSERT INTO 
			av_entries (avID, postID, type, dat, charID)
			VALUES 
			(?, ?, ?, ?, ?)",
			[$entry->avID, $entry->postID, $entry->type, $entry->dat, $entry->charID]);

		if ($entry->type == "drPlayer" 
			OR $entry->type == "drGM") {
			$this->addDr($entry);
		}elseif ($entry->type == "rpPlayer" 
			OR $entry->type == "rpGM") {
			$this->addRp($entry);
		}

	}


	private function formatContent($res){

		if (is_array($res)) {
			foreach ($res as $key => $value) {
				$value->content = htmlspecialchars_decode(nl2br($value->content));
			}
		}else{
			$res->content = htmlspecialchars_decode(nl2br($res->content));
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
			ch.name as charName,
			ch.id as charID
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
			ON ent.charID = ch.id
			LEFT JOIN {$this->users_table} as user
			ON ch.userID = user.id
			WHERE av.id = ?
			ORDER BY ent.id", 
			[$avID]);
		return $this->formatContent($res);
	}


	public function findByPosts($avID, $first, $last){

		$res = $this->query("
			SELECT 
			ent.*,
			rp.content as content, 
			dr.*,
			carac.name as caracName,
			av.id as avID, av.name as avName,
			user.username, user.id as userID,
			ch.name as charName,
			ch.id as charID
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
			ON ent.charID = ch.id
			LEFT JOIN {$this->users_table} as user
			ON ch.userID = user.id
			WHERE av.id = ?
			AND postID BETWEEN $first AND $last
			ORDER BY ent.id", 
			[$avID]);
		return $this->formatContent($res);

	}

	public function lastByAv($avID){

		$res = $this->query("
			SELECT *
			FROM {$this->table_name} as ent
			WHERE avID = ?
			ORDER BY ent.id DESC", 
			[$avID], true);
		return $res;

	}


	public function countPosts($avID){

		$data = $this->query("
			SELECT COUNT(DISTINCT postID) as count
			FROM {$this->table_name}
			WHERE avID = ?",
			[$avID], true);
		return $data->count;

	}



}

?>