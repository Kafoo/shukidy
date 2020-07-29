<?php

if (!empty($_POST)) {

	$success = app\Manager::getInstance()->getTable('aventures')->delete($_POST['id']);

	if ($success) {
		header('Location: admin.php?p=av_list');
	}

}
