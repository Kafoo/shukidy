<?php
$manager = \app\Manager::getInstance();

$manager->setTitle('Univers');
/*$manager->addScript('app','');*/
?>


<h1>UNIVERS</h1>

<div class="ventreBox centering">
	<div class="choice-gen" style="background-color: #4caf5091;">
		"Vampire"
	<div class="choice-gen button" onclick="alert('Déso, on peut pas modifier celui-là =P')">Modifier</div>
	</div> 
	<br>
	<div class="choice-gen" style="background-color: #4caf5091;">
		"Fantasy"
	<a href="/crea/univ/2" class="choice-gen button">Modifier</a>
	</div> 
</div>