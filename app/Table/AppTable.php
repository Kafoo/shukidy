<?php

namespace app\Table;

use core\Table\MainTable;
use app\Manager;

/**
 * 
 */
class AppTable extends MainTable{
	
	protected $table_name = 'av_entries';
	protected $rp_table = 'av_rp';
	protected $dicerolls_table = 'av_dicerolls';
	protected $log_table = 'av_log';
	protected $av_table = 'aventures';
	protected $users_table = 'users';
	protected $characters_table = 'characters';
	protected $carac_table = 'carac';

}

?>