<?php

$manager = \App\Manager::getInstance();
$manager->setTitle('Profil');

$user = $variables['user'];
$characters = $variables['characters'];

?>

<h1>Profil de <?=$user->username?></h1>


<h2>Informations</h2>

<ul>
	<li>Messages : <?=$user->msgCount?> </li>
	<li>Grade : <?=$user->grade?> </li>
</ul>

<h2>Personnages :</h2>

<ul>

<?php foreach($characters as $character):?>

	<li><?=$character->name?></li>

<?php endforeach; ?>

</ul>


