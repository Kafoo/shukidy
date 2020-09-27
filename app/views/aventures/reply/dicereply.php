<div class="OW" id="diceReply">
	<div class="mobile">
		<div class="closingArrow"></div>
	</div>
	<h3>LANCE DE DES</h3>
	<div class="OWContent">
		<form method="POST" action="">

			<h4>Titre</h4>
			<input type="text" name="diceReply-title" placeholder="titre du lancé">
			<h4>Caractéristique</h4>
			<div class="diceReply-caracContainer container centering">	

				<?php foreach ($carac as $key => $carac) : ?>
					<div class="carac<?=$key+1?> diceReply-carac button"
					onclick="choose('carac', <?=$key+1?>)" data-toggle="tooltip" data-placement="top" title="<?=ucfirst($carac->name)?>"></div>
				<?php endforeach ?>

			</div>
			<input id="caracStock" type="text" name="diceReply-carac" hidden>

			<h4>Difficulté</h4>
			<div class="diff8 diceReply-diff button"
			onclick="choose('diff','8')">Facile</div>
			<div class="diff10 diceReply-diff button"
			onclick="choose('diff','10')">Normal</div>
			<div class="diff12 diceReply-diff button"
			onclick="choose('diff','12')">Difficile</div>
			<input id="diffStock" type="text" name="diceReply-diff" hidden>
			
			<br>
			<input id="resultStock" type="text" name="diceReply-result" hidden>
			<input type="text" name="persoID" value="<?=$userChar->id?>" hidden>
			<?php 
			$persoObjectID = 'perso'.$userChar->id;
			?>

			<input id="diceReply-submit"  type="submit" name="diceReply-submit" value="Je lance mon dé !">
		</form>
	</div>
</div>
<div class="OW" id="diceReply_error">
	<div class="mobile">
		<div class="closingArrow"></div>
	</div>
	<h3>LANCE DE DES</h3>
	<div class="OWContent">
		<br>
		Avant de lancer un dé, tu dois écrire et poster un message qui décrit ton action ! ;-)
	</div>
</div>