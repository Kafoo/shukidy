<?php

$herokuDBname = getenv('DB_NAME');
$herokuDBuser = getenv('DB_USER');
$herokuDBpass = getenv('DB_PASSSWORD');
$herokuDBhost = getenv('DB_HOST');

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

		'db_name' => $herokuDBname,
		'db_user' => $herokuDBuser,
		'db_pass' => $herokuDBpass,
		'db_host' => $herokuDBhost

		);

}


?>