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
	          
	          <div class="card-desc">ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				     tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				     quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				     consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				     cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				     proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	         </div>

	        <div class="card-action">
	          <a href="<?=$av->url?>">Continuer</a>
	          <a href="#">+ Infos</a>
	        </div>
        
        </div>
		
	<?php endforeach ?>


</div>

