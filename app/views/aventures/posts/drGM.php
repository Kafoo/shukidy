<?php
$img = new app\Controller\ImgController;

/*$aventure = $variables['aventure'];*/
$post = $variables['post'];
$entry = $variables['entry'];
$character = $post->characterInfos;
$user = $post->userInfos;
$userChars = unserialize($_SESSION['characters']);


$entry->resultFinal = floatval($entry->result)+floatval($entry->caracVal)+floatval($entry->caracCond);
if ($entry->difficulty<$entry->resultFinal) {$success = 1;}
elseif ($entry->difficulty>=$entry->resultFinal) {$success = 0;}

foreach ($userChars as $userChar) {
	if ($userChar->id === $character->id) {
		$charMatch = True;
	}else{
		$charMatch = False;
	}
}

?>

<div class="diceRollTitle centering">
	- <?=$entry->title?> -
</div>

<div>

 	<div class="diceRollBox">
	<div class="diceRollPerso">
		<div class="box">
			<b><u><?=$character->name?></u></b>
		</div>
		<div class="box">
			<i>(<?=ucfirst($entry->caracName)?>)</i>
		</div>

		<?php
		if ($charMatch) {
		// IF CURRENT USER
		if ($entry->result == 0) { ?>
			Not Rolled
			<div class="box rollBox rollTheDie button"
			ajax="?action=rollTheDie&rollID=<?=$diceRoll[0]?>"
			>Lance le dé !</div>
		<?php
		}else{ ?>
			Rolled
			<div class="box rollBox dieRolled">
				Résultat du jet : <?=$entry->result?>
			</div>
		<?php
		}
	}else{
		// IF OTHER USER
		if ($entry->result == 0) { ?>
			Not Rolled
			<div class="box rollBox">En attente</div>
		<?php
		}else{ ?>
			Rolled
			<div class="box rollBox dieRolled">
				Résultat : <?=$entry->result?>			
			</div>
		<?php
		} ?>
	<?php
	} ?>

	</div>
	<div class="centering">
		<div class="diceRollDigits">
			<div class="diceRollDigit digit-roll" data-toggle="tooltip" data-placement="top" title="Résultat du lancé"><?=$entry->result?></div>
			<div class="diceRollDigit digit-carac" style="background-image: url(<?=$img->icon($entry->caracID)?>);" data-toggle="tooltip" data-placement="top" title="<?=ucfirst($entry->caracName)?> de <?=$entry->charName?>">+<?=$entry->caracVal?></div>
		<div class="diceRollDigit digit-cond <?php if($entry->caracCond>=0){echo'digit-cond-pos';}else{echo'digit-cond-neg';}?>" data-toggle="tooltip" data-placement="top" title="Condition">+<?=$entry->caracCond?></div>
			<div class="inline">
				<span style="font-weight: bolder">=</span>	
				<div class="diceRollDigit digit-resultFinal" data-toggle="tooltip" data-placement="top" title="Résultat final">
					<?=$entry->resultFinal?>
					<span class="digit-difficulty"> /<?=$entry->difficulty?></span>
					<?php if ($entry->resultFinal>=$entry->difficulty) : ?>
						<img src="<?=$img->icon('tic_yes')?>" class="diceRoll-tic">
					<?php else :?>
						<img src="<?=$img->icon('tic_no')?>" class="diceRoll-tic">
					<?php endif; ?>
				</div>
			</div>
			<div class="resultText">
				<?php
				if ($entry->resultFinal>=$entry->difficulty) {echo '<div class="yes">Réussi !</div>';}
				else{echo '<div class="no">Raté !</div>';}
				?>
			</div>
		</div>
	</div>
</div>

	
</div>
<div></div>