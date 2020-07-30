<?php

if (substr(__DIR__, 0, 2) == 'D:') {

	return array(

		'title' => 'Shukidy',

		'db_name' => 'heroku_3ca6f2b572bf369',
		'db_user' => 'root',
		'db_pass' => '',
		'db_host' => '127.0.0.1'

	);

}
else{

	return array(

			'title' => 'Shukidy',

			'db_name' => DB_NAME,
			'db_user' => DB_USER,
			'db_pass' => DB_PASSSWORD,
			'db_host' => DB_HOST

		);

}


?>