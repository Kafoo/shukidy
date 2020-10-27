<?php
$manager = \app\Manager::getInstance();
$manager->setStyle('aventures');
$manager->setTitle('Aventures');
$manager->addScript('app', 'aventures.av_list')

?>


<h1>AVENTURES</h1>


<div id="av-list" class="cardContainer">
	
	<?php foreach ($variables as $aventure): ?>

      <div class="card small z-depth-2">

	      <span class="card-title"> <?= $aventure->name ?></span>

	          <div class="card-info">
				     <b>Univers</b> : <?=ucfirst($aventure->univ_name)?> <br>
				     <b>GM</b> : <?= $aventure->gm_name ?> <br>
	          </div>
	          <div class="card-desc">
	          	<?= $aventure->description ?>
	         </div>

	        <div class="card-action">
	        	<?php if ($aventure->userIsIn): ?>
		        	<a href="<?=$aventure->url?>">Continuer</a>
	        	<?php else : ?>
	        		<a @click="tryJoin"
	        		avID="<?=$aventure->id?>"
	        		worldID="<?=$aventure->worldID?>"
	        		href="#">Rejoindre</a>
	        	<?php endif ?>

        		<a href="#">+ Infos</a>

	        </div>
        
        </div>
		
	<?php endforeach ?>

	<div class="custConf centering" v-if="charList">
		<div v-if="characters.length">Avec quel personnage souhaites-tu rejoindre l'aventure ?</div>
		<div v-else>Tu n'as pas encore de personnages dans cet univers</div>

		<div v-for="character in characters"
		class="choice-gen button"
		@click="join(character.id)">
			{{character.name}}
		</div>

		<div style="text-decoration:underline; cursor:pointer" 
		@click="list_close()">
			<span v-if="characters.length">Annuler</span>
			<a v-else class="choice-gen button" 
			onclick="window.location = '/crea/char/<?=$aventure->worldID?>'">
				Créer un personnage dans cet univers
			</a>
		</div>
	</div>

</div>

