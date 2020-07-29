<?php
$entry = $variables['entry'];
$post = $variables['post'];
$user = $post->userInfos;
$character = $post->characterInfos;
$entry->resultFinal = floatval($entry->result)+floatval($entry->caracVal)+floatval($entry->caracCond);

?>

<div class="diceRollTitle-player">- <?=$entry->title?> -</div>
<div class="diceRollBox">
	<div class="centering">
		<div class="diceRollDigits">
			<div class="diceRollDigit digit-roll" data-toggle="tooltip" data-placement="top" title="Résultat du lancé"><?=$entry->result?></div>
			<div class="diceRollDigit digit-carac" style="background-image: url(img/icones/carac/<?=$entry->caracID?>_color.png);" data-toggle="tooltip" data-placement="top" title="<?=ucfirst($entry->caracName)?> de <?=$character->name?>">+<?=$entry->caracVal?></div>
			<div class="diceRollDigit digit-cond <?php if($entry->caracCond>=0){echo'digit-cond-pos';}else{echo'digit-cond-neg';}?>" data-toggle="tooltip" data-placement="top" title="Condition">
				<?php if($entry->caracCond>=0){echo'+'.$entry->caracCond;}else{echo $entry->caracCond;}?>
			</div>
			<div class="inline">
				<span style="font-weight: bolder">=</span>
				<div class="diceRollDigit digit-resultFinal" data-toggle="tooltip" data-placement="top" title="Résultat final">
					<?=$entry->resultFinal?>
					<span class="digit-difficulty"> /<?=$entry->difficulty?></span>
					<?php
					if ($entry->resultFinal>=$entry->difficulty) {
						echo '<img src="./img/icones/tic_yes.png" class="diceRoll-tic">';
					}else{
						echo '<img src="./img/icones/tic_no.png" class="diceRoll-tic">';
					}?>
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