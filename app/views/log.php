<?php
$logs = $variables;
$manager = \app\Manager::getInstance();
$manager->setTitle('LOG');

foreach ($logs as $log) {
	
	echo $log->dat .' ____ '. $log->content .'<br>';

}

?>