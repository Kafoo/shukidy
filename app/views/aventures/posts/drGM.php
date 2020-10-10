<?php
$img = new app\Controller\ImgController;

$post = $variables['post'];
$entry = $variables['entry'];
$user = $post->userInfos;
$userChars = unserialize($_SESSION['characters']);

foreach ($userChars as $userChar) {
	if ($userChar->id === $entry->charID) {
		$charMatch = True;
	}else{
		$charMatch = False;
	}
}

?>

<div class="diceRollTitle centering">
	- <?=$entry->title?> -
</div>


<div class="diceRollBox">
	<div class="diceRollPerso">
		<div class="box">
			<b><u><?=$entry->charName?></u></b>
		</div>
		<div class="box">
			<i>(<?=ucfirst($entry->caracName)?>)</i>
		</div>

		<?php
		if ($charMatch) {
			// IF CURRENT USER
			if ($entry->rolled) { ?>
				<!-- Rolled -->
				<div class="box rollBox dieRolled">
					Résultat : <?=$entry->result?>
				</div>
			<?php
			}else{ ?>
				<!-- Not Rolled -->
				<div class="box rollBox rollTheDie button"
				onclick="rollTheDice(this)" 
				entryID="<?=$entry->id?>"
				>Lance le dé !</div>
			<?php
			}
		}else{
			// IF OTHER USER
			if ($entry->rolled) { ?>
				<!-- Rolled -->
				<div class="box rollBox dieRolled">
					Résultat : <?=$entry->result?>			
				</div>
			<?php
			}else{ ?>
				<!-- Not Rolled -->
				<div class="box rollBox">En attente</div>
			<?php
			} ?>
		<?php
		} ?>

	</div>
	<div class="centering">
		<div class="diceRollDigits">

			<div class="diceRollDigit digit-roll" data-toggle="tooltip" data-placement="top" title="Résultat du lancé">
			
				<?=$entry->result?>
					
			</div>

			<div class="diceRollDigit digit-carac" 
			<?=$img->carac($entry->caracIcon, $entry->caracColor)?> 
			data-toggle="tooltip" 
			data-placement="top" 
			title="<?=ucfirst($entry->caracName)?> de <?=$entry->charName?>">
				+<?=$entry->caracVal?>	
			</div>

			<div class="diceRollDigit digit-cond <?php if($entry->caracCond>=0){echo'digit-cond-pos';}else{echo'digit-cond-neg';}?>" 
				data-toggle="tooltip" 
				data-placement="top" 
				title="Condition">
				+<?=$entry->caracCond?>	
			</div>

			<div class="inline">
				<span style="font-weight: bolder">=</span>	
				<div class="diceRollDigit digit-resultFinal" data-toggle="tooltip" data-placement="top" title="Résultat final">

					<?php if ($entry->rolled): ?>
						<?=$entry->resultFinal?>
						<span class="digit-difficulty"> /<?=$entry->difficulty?></span>
						<?php if ($entry->success) : ?>
							<img src="<?=$img->icon('tic_yes')?>" class="diceRoll-tic">
						<?php else : ?>
							<img src="<?=$img->icon('tic_no')?>" class="diceRoll-tic">
						<?php endif; ?>
					<?php else : ?>
						---
					<?php endif ?>


				</div>
			</div>
			<div class="resultText">
				<div class="<?php if($entry->success){echo'yes';}else{echo'no';}?>">
					<?=$entry->successMsg?>
				</div>
			</div>

		</div>
	</div>
</div>

<div></div>