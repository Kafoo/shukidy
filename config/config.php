<?php

if (substr(__DIR__, 1, 3) == 'mnt') {

	return array(
		'title' => 'Shukidy',
		'db_name' => 'heroku_1dc514cb1b72fc8',
		'db_user' => 'root',
		'db_pass' => '',
		'db_host' => '127.0.0.1'
	);

}else{

	return array(
		'title' => 'Shukidy',
		'db_name' => getenv('DB_NAME'),
		'db_user' => getenv('DB_USER'),
		'db_pass' => getenv('DB_PASSWORD'),
		'db_host' => getenv('DB_HOST')
		);
}


?>