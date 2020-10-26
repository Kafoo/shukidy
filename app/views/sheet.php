<?php
$img = new app\Controller\ImgController;

$character = $variables;
$manager = \app\Manager::getInstance();
$manager->setTitle($character->name);
$manager->setStyle('sheet');
/*$manager->addScript('');*/
?>

<h1>FICHE PERSONNAGE</h1>

<div class="container">
	
	<div class="ventreBox centering">

		<h3><?=strtoupper($character->name)?> </h3>
		<img id="avatar" src="<?=$character->avatar?>">
		<br><br>
		<div>
			<h4>Nature</h4><br><b>-- <?=$character->nature?> --</b><br><br>
			<h4>Attitude</h4><br><b>-- <?=$character->attitude?> --</b><br><br>
			<h4>Concept</h4><br><b>-- <?=$character->concept?> --</b><br><br>
		</div>
	</div>

	<div class="ventreBox carac centering">

		<h3>CARACTERISTIQUES</h3>
		<h4>LVL <?=$character->lvl?></h4>

		<div class="infoPersoXP-container">
			<div class="infoPersoXP"  
			style="background: linear-gradient(to right, #5154bd <?=$character->nextLvlPourcent?>%, rgb(200,200,200) <?=$character->nextLvlPourcent?>%);"> 
				<b><?=$character->xp?></b> / <?=$character->nextlvl?> XP
			</div> 
		</div>

		<table>

			<?php foreach ($character->caracs as $carac): ?>
				
				<?php
				$isPositive = false;
				if ($carac->cond >= 0) {
					$carac->cond = '+'.$carac->cond;
					$isPositive = true;
				}?>

				<tr>
					<td>
						<div class="displayCarac-container" >
							<div class="displayCarac-icon" 
							data-toggle="tooltip" 
							data-placement="top" 
							title="<?=ucfirst($carac->name)?>"
							style="background-image: url('<?=$img->gameicon($carac->icon)?>');
							background-color: <?=$carac->color?>">
								<?=$carac->value?>
							</div>
							<div class="displayCarac-cond <?= $isPositive ? 'pos' : 'neg'?>">
								<?=$carac->cond?>
							</div>
						</div> 
					</td>
					<td><?=ucfirst($carac->name)?></td>
				</tr>

			<?php endforeach ?>

		</table>
	</div>

	<div class="ventreBox centering raceBox">
		<h3>RACE : </h3>
		<h4><?=$character->race->name?></h4><br>
		<div>
			<?=$character->race->description?>
		</div>
		<br>

		<h3>Tes capacités de <?=$character->race->name?> : </h3>

		<?php foreach ($character->capacités as $capacité): ?>
			<h4><?=$capacité->name?></h4><br>
			<div>
				<?=$capacité->description?>
			</div>
			<br>
		<?php endforeach ?>
		<br>
	</div>

	<div class="ventreBox centering classeBox">
		<h3>CLASSE : </h3>
		<h4><?=$character->classe->name?></h4><br>
		<div>
			<?=$character->classe->description?>
		</div>
		<br>

		<h3>Tes disciplines de <?=$character->classe->name?> : </h3>

		<?php foreach ($character->disciplines as $discipline): ?>
			<h4><?=$discipline->name?></h4><br>
			<div>
				<?=$discipline->description?>
			</div>
			<br>
		<?php endforeach ?>
		<br>
	</div>

	<div class="ventreBox centering">
		<h3>HISTOIRE</h3>
		<div id="persoLore"><?=nl2br($character->lore)?></div>
		<div id="editLoreBlock	" hidden>
			<form method="POST" action="SERVER_UPDATES.php?action=updatePersoLore&persoID=<?=$_GET['persoID']?>">
				<textarea id="editLoreArea" name="contentEditLore"></textarea>
				<input type="submit" name="submitEditLore" value="J'édite mon histoire !">
			</form>
		</div>
	</div>

</div>