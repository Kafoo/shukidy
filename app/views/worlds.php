<?php
$manager = \app\Manager::getInstance();

$manager->setTitle('Univers');
$manager->addScript('app','worlds');
$worlds = $variables
?>


<h1>UNIVERS</h1>

<div id="world-list" class="ventreBox centering">

	<?php foreach ($worlds as $world): ?>
		<div class="choice-gen" style="background-color: #4caf5091;">
			<?=$world->name?>
		<a href="/crea/world/<?=$world->id?>" class="choice-gen button">Modifier</a>
		</div> 
		<br>
	<?php endforeach ?>
</div>