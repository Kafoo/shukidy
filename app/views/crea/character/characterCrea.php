<?php
$manager = \app\Manager::getInstance();
$img = new app\Controller\ImgController;

$manager->setTitle('Création de personnage');
$manager->setStyle('characterCrea');
$manager->addScript('app','crea.character.pager');
$manager->addScript('app','crea.character.characterCreaController');
$manager->addScript('app','crea.character.characterCrea');

$univers = $variables;

?>

<div class="univID-stock" hidden><?=$univers->id?></div>

<h1>CREATION DE PERSONNAGE</h1>


<div class="pagerTitle">
	<span class="pageCount"></span> : 
	<span class="pageName"></span>
</div>

<div class="pagerErrorContainer">
	<div class="closingError"></div>
	<div class="pagerError"></div>
</div>

<!-- PAGES -->
<div class="pagesBigContainer">

	<!-- RACE CHOICE -->
	<div class="pageContainer" pageName="Race/Capacité" page="1">
		<?php require ROOT."/app/views/crea/character/race_choice.php" ?>
	</div>

	<!-- CLASSE CHOICE -->
	<div class="pageContainer" pageName="Classe/Discipline" page="2">
		<?php require ROOT."/app/views/crea/character/classe_choice.php" ?>
	</div>
	
	<!-- CARAC CHOICE -->
	<div class="pageContainer" pageName="T'as quoi dans le ventre ?" page="3">
		<?php require ROOT."/app/views/crea/character/carac_choice.php" ?>
	</div>
	
	<!-- QUI ES TU -->
	<div class="pageContainer" pageName="Qui es-tu ?" page="4">
		<?php require ROOT."/app/views/crea/character/quiestu.php" ?>
	</div>
	
</div>

<div class="pagerNav">
	<div class="button pagerbutton pagerPrev"></div>
	<div class="button pagerbutton pagerNext"></div>
	<div class="button pagerbutton pagerSubmit" hidden>Je valide mon perso !</div>
</div>