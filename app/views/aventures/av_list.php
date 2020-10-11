<?php
$manager = \app\Manager::getInstance();
$manager->setStyle('aventures');
$manager->setTitle('Aventures');
?>


<h1>AVENTURES</h1>


<div class="cardContainer">
	
	<?php 

	foreach ($variables as $av): ?>

      <div class="card small z-depth-2">

	      <span class="card-title"> <?= $av->name ?></span>

	          <div class="card-info">
				     <b>Univers</b> : <?=ucfirst($av->univ_name)?> <br>
				     <b>GM</b> : <?= $av->gm_name ?> <br>
	          </div>
	          
	          <div class="card-desc">
	          	<?= $av->description ?>
	         </div>

	        <div class="card-action">
	          <a href="<?=$av->url?>">Continuer</a>
	          <a href="#">+ Infos</a>
	        </div>
        
        </div>
		
	<?php endforeach ?>


</div>

