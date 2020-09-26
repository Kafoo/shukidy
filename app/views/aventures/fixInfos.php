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
		for ($j=0; $j < count($characters); $j++) {  
			if ($characters[$j]->name!=='GM') { //On n'affiche pas le GM ?> 
				<div class="infoPerso"> 
					<?php // Etoiles autour du nom si perso du user 
					if ($characters[$j]->userID === $_SESSION['auth']) { ?> 
						<img src="<?=$img->icon('monperso')?>" style="width: 10px;"> 
						<div class="infoPersoNom">
							<a href="profil.php?persoID=<?=$characters[$j]->id?>"><?=$characters[$j]->name?></a>
							</div>
						<img src="<?=$img->icon('monperso')?>" style="width: 10px;"> 
					<?php 
					} else {?> 
						<div class="infoPersoNom"><a href="profil.php?persoID=<?=$characters[$j]->id?>"><?=$characters[$j]->name?></a></div> 

					<?php 
					} 
					//Calcul du pourcentage vers le nextLVL 
						$xp = $characters[$j]->xp;
						$minxp = $characters[$j]->minxp;
						$nextLVL = $characters[$j]->nextlvl; 
						$pourcent = ($xp-$minxp)*100/($nextLVL-$minxp); 
					?> 

					<div class="infoPersoDropdown"> 
						<img src="<?=$img->rpg('pv_'.$characters[$j]->pv) ?>" class="pvBar" data-toggle="tooltip" data-placement="left" title="<?=$characters[$j]->pv?>/10 PV"> 
						<br>
						<div class="infoPersoLvl">lvl <?=$characters[$j]->lvl?></div> 
						<div class="infoPersoXP-container">
							<div class="infoPersoXP"  
							style="background: linear-gradient(to right, #5154bd <?=$pourcent?>%, rgb(200,200,200) <?=$pourcent?>%);"> 
								<b><?=$xp?></b> / <?=$nextLVL?> XP
							</div> 
						</div>

						<br>

						<?php
						$c1CondIsPos = false;
						$c2CondIsPos = false;
						$c3CondIsPos = false;
						$c4CondIsPos = false;
						$c5CondIsPos = false;
						if ($characters[$j]->c1Cond >= 0) {$c1Cond = '+'.$characters[$j]->c1Cond;$c1CondIsPos = true;}	else{$c1Cond = $characters[$j]->c1Cond;}		
						if ($characters[$j]->c2Cond >= 0) {$c2Cond = '+'.$characters[$j]->c2Cond;$c2CondIsPos = true;}	else{$c2Cond = $characters[$j]->c2Cond;}		
						if ($characters[$j]->c3Cond >= 0) {$c3Cond = '+'.$characters[$j]->c3Cond;$c3CondIsPos = true;}	else{$c3Cond = $characters[$j]->c3Cond;}		
						if ($characters[$j]->c4Cond >= 0) {$c4Cond = '+'.$characters[$j]->c4Cond;$c4CondIsPos = true;}	else{$c4Cond = $characters[$j]->c4Cond;}		
						if ($characters[$j]->c5Cond >= 0) {$c5Cond = '+'.$characters[$j]->c5Cond;$c5CondIsPos = true;}	else{$c5Cond = $characters[$j]->c5Cond;}		
						?>
						<div>
							<div class="displayCarac-container" >
								<div class="displayCarac-icon" 
								data-toggle="tooltip" 
								data-placement="top" 
								title="<?=ucfirst($carac['0']->name)?>"
								style="background-image: url('<?=$img->gameicon($carac['0']->icon)?>');
								background-color: <?=$carac['0']->color?>">
								</div>
								<div class="displayCarac-value">
									<?=$characters[$j]->c1?>
								</div>
							</div> 

							<div class="displayCarac-container" >
								<div class="displayCarac-icon" 
								data-toggle="tooltip" 
								data-placement="top" 
								title="<?=ucfirst($carac['1']->name)?>"
								style="background-image: url('<?=$img->gameicon($carac['1']->icon)?>');
								background-color: <?=$carac['1']->color?>">
								</div>
								<div class="displayCarac-value">
									<?=$characters[$j]->c2?>
								</div>
							</div> 

							<div class="displayCarac-container" >
								<div class="displayCarac-icon" 
								data-toggle="tooltip" 
								data-placement="top" 
								title="<?=ucfirst($carac['2']->name)?>"
								style="background-image: url('<?=$img->gameicon($carac['2']->icon)?>');
								background-color: <?=$carac['2']->color?>">
								</div>
								<div class="displayCarac-value">
									<?=$characters[$j]->c3?>
								</div>
							</div> 

							<div class="displayCarac-container" >
								<div class="displayCarac-icon" 
								data-toggle="tooltip" 
								data-placement="top" 
								title="<?=ucfirst($carac['3']->name)?>"
								style="background-image: url('<?=$img->gameicon($carac['3']->icon)?>');
								background-color: <?=$carac['3']->color?>">
								</div>
								<div class="displayCarac-value">
									<?=$characters[$j]->c4?>
								</div>
							</div>

							<div class="displayCarac-container" >
								<div class="displayCarac-icon" 
								data-toggle="tooltip" 
								data-placement="top" 
								title="<?=ucfirst($carac['4']->name)?>"
								style="background-image: url('<?=$img->gameicon($carac['4']->icon)?>');
								background-color: <?=$carac['4']->color?>">
								</div>
								<div class="displayCarac-value">
									<?=$characters[$j]->c5?>
								</div>
							</div>

						</div>
						<div>						
							<div class="infoPersoCond <?php if($c1CondIsPos){echo 'infoPersoCond-pos';}else{echo 'infoPersoCond-neg';} ?>" data-toggle="tooltip" data-placement="top" title="Condition de <?=ucfirst($carac['0']->name)?>"><?=$c1Cond?></div>
							<div class="infoPersoCond <?php if($c2CondIsPos){echo 'infoPersoCond-pos';}else{echo 'infoPersoCond-neg';} ?>" data-toggle="tooltip" data-placement="top" title="Condition de <?=ucfirst($carac['1']->name)?>"><?=$c2Cond?></div>
							<div class="infoPersoCond <?php if($c3CondIsPos){echo 'infoPersoCond-pos';}else{echo 'infoPersoCond-neg';} ?>" data-toggle="tooltip" data-placement="top" title="Condition de <?=ucfirst($carac['2']->name)?>"><?=$c3Cond?></div>
							<div class="infoPersoCond <?php if($c4CondIsPos){echo 'infoPersoCond-pos';}else{echo 'infoPersoCond-neg';} ?>" data-toggle="tooltip" data-placement="top" title="Condition de <?=ucfirst($carac['3']->name)?>"><?=$c4Cond?></div>
							<div class="infoPersoCond <?php if($c5CondIsPos){echo 'infoPersoCond-pos';}else{echo 'infoPersoCond-neg';} ?>" data-toggle="tooltip" data-placement="top" title="Condition de <?=ucfirst($carac['4']->name)?>"><?=$c5Cond?></div>
						</div>
						<div class="infoPersoInventory">
							<?=$characters[$j]->invent1?> <br>
							<?=$characters[$j]->invent2?> <br>
							<?=$characters[$j]->invent3?> <br>
							<?=$characters[$j]->invent4?> <br>
							<?=$characters[$j]->invent5?> <br>
						</div>
					</div>
					<img src="<?=$img->icon('dropdown')?>" class="dropdownIcone">
				</div>
				<?php // Séparation uniquement entre chaque perso
				if ($j !== count($characters)-2) { ?>
					<!-- <div class="separate"></div> -->
				<?php	
				}
			} ?>
		<?php
		} ?>
	</div>
</div>