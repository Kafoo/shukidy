<?php

namespace app\Entity;

use core\Entity\MainEntity;

/**
 * 
 */
class EntriesEntity extends MainEntity
{


	public function getResultFinal(){

		$this->resultFinal = floatval($this->result)+floatval($this->caracVal)+floatval($this->caracCond);

		return $this->resultFinal;
	}

	public function getSuccess(){
		if ($this->resultFinal>=$this->difficulty){
			$this->success = True;
		}else{
			$this->success = False;
		}

		return $this->success;
	}

	public function getSuccessMsg(){

		if ($this->rolled) {
			if ($this->resultFinal>=$this->difficulty){
				$this->successMsg = "Réussi !";
			}else{
				$this->successMsg = "Raté !";
			}	
		}else{
			$this->successMsg = "";
		}

		return $this->successMsg;
	}

	public function getRolled(){

		if ($this->result == 0) {
			$this->rolled = False;
		}else{
			$this->rolled = True;
		}

		return $this->rolled;
	}

}