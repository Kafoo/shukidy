<?php

$manager = \app\Manager::getInstance();
$manager->setTitle('Profil');
$manager->addScript('app', 'profil');

$user = $variables['user'];
$characters = $variables['characters'];

?>

<h1>Profil de <?=$user->username?></h1>

<div class="ventreBox centering">
	<h3>Informations</h3>

		<h4>
			Messages
		</h4>
		<?=$user->msgCount?> 
		<h4>
			Grade
		</h4>
		<?=$user->grade?> 

<br><br>
</div>


<div class="ventreBox centering">
	<h3>Personnages :</h3>

	<?php foreach($characters as $character):?>
		<div>		
			<a class="choice-gen button inline" href="/sheet/<?=$character->id?>">
				<?=$character->name?>
			</a>
			<div class="choice-gen choice-delete button inline" charID='<?=$character->id?>'>
				Supprimer
			</div>	
		</div>

	<?php endforeach; ?>

	<a class="choice-gen choice-add button" href="/crea/char">
		Créer un nouveau perso
	</a>

</div>


