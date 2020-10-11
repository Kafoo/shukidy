<?php
$img = new app\Controller\ImgController;

$aventure = $variables;
$characters = $aventure->characters;
$carac = $aventure->carac;

?>


<div class="fixInfosSlider desktop">
	<div class="fixInfos desktop">
		<div class="coterieLogoContainer">		
			<div class="coterie-logo coterie-pu desktop">
				<div class="puFixInfos"></div>
			</div>
		</div>
		<?php
		//S'il n'y a que le GM pour le moment
		if (count($characters) == 1 AND $characters[0]->name == 'GM'){
			echo "<br>Il n'y a pas encore de joueur dans ton aventure<br><br>";
		}
		foreach ($characters as $key => $character) {  
			if ($character->name!=='GM') { //On n'affiche pas le GM ?> 
				<div class="infoPerso"> 
					<?php // Etoiles autour du nom si perso du user 
					if ($character->userID === $_SESSION['auth']) { ?> 
						<img src="<?=$img->icon('monperso')?>" style="width: 10px;"> 
						<div class="infoPersoNom">
							<a href="profil.php?persoID=<?=$character->id?>"><?=$character->name?></a>
							</div>
						<img src="<?=$img->icon('monperso')?>" style="width: 10px;"> 
					<?php 
					} else {?> 
						<div class="infoPersoNom"><a href="profil.php?persoID=<?=$character->id?>"><?=$character->name?></a></div> 

					<?php 
					} 
					//Calcul du pourcentage vers le nextLVL 
						$xp = $character->xp;
						$minxp = $character->minxp;
						$nextLVL = $character->nextlvl; 
						$pourcent = ($xp-$minxp)*100/($nextLVL-$minxp); 
					?> 

					<div class="infoPersoDropdown"> 
						<img src="<?=$img->rpg('pv_'.$character->pv) ?>" class="pvBar" data-toggle="tooltip" data-placement="left" title="<?=$character->pv?>/10 PV"> 
						<br>
						<div class="infoPersoLvl">
							lvl <?=$character->lvl?>
						</div> 
						<div class="infoPersoXP-container">
							<div class="infoPersoXP"  
							style="background: linear-gradient(to right, #5154bd <?=$pourcent?>%, rgb(200,200,200) <?=$pourcent?>%);"> 
								<b><?=$xp?></b> / <?=$nextLVL?> XP
							</div> 
						</div>

						<br>

						<div>

							<?php foreach ($character->caracs as $key => $carac): ?>

								<?php
								$isPositive = false;
								if ($carac->cond >= 0) {
									$carac->cond = '+'.$carac->cond;
									$isPositive = true;
								}?>

								<div class="displayCarac-container" >
									<div class="displayCarac-icon" 
									data-toggle="tooltip" 
									data-placement="top" 
									title="<?=ucfirst($carac->name)?>"
									style="background-image: url('<?=$img->gameicon($carac->icon)?>');
									background-color: <?=$carac->color?>">
										<?=$carac->value?>
									</div>
									<div class="displayCarac-cond <?= $isPositive ? 'pos' : 'neg'?>"
										data-toggle="tooltip" 
										data-placement="top" 
										title="Condition de <?=ucfirst($carac->name)?>">
										<?=$carac->cond?>
									</div>
								</div> 

							<?php endforeach ?>


						</div>

						<div class="infoPersoInventory">
							<?=$character->invent1?> <br>
							<?=$character->invent2?> <br>
							<?=$character->invent3?> <br>
							<?=$character->invent4?> <br>
							<?=$character->invent5?> <br>
						</div>
					</div>
					<img src="<?=$img->icon('dropdown')?>" class="dropdownIcone">
				</div>
				<?php // Séparation uniquement entre chaque perso
				if ($key !== count($characters)-2) { ?>
					<!-- <div class="separate"></div> -->
				<?php	
				}
			} ?>
		<?php
		} ?>
	</div>
</div>