<?php
$manager = \app\Manager::getInstance();
$manager->setStyle('aventures');
$manager->setTitle('Aventures');

?>


<h1>AVENTURES</h1>


<div class="cardContainer">
	
	<?php 

	foreach ($variables as $aventure): ?>


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
	        		<a href="">Rejoindre</a>
	        	<?php endif ?>

        		<a href="#">+ Infos</a>

	        </div>
        
        </div>
		
	<?php endforeach ?>


</div>

