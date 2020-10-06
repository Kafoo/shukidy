<div class="OW" id="diceReply">
	<div class="mobile">
		<div class="closingArrow"></div>
	</div>
	<h3>LANCE DE DES</h3>
	<div class="OWContent">
		<form method="POST" onsubmit="return false">

			<h4>Titre</h4>

			<input type="text" name="diceReply-GM" value="<?php if($aventure->userIsGM){echo 1;}else{echo 0;}?>" hidden>

			<input type="text" name="diceReply-title" placeholder="titre du lancé">

			<?php if ($aventure->userIsGM): ?>

				<h4>Personnages</h4>

				<?php foreach ($aventure->characters as $key => $character): ?>

					<div class="char<?=$character->id?> diceReply-char choice-gen button inline"
					onclick="chooseChar('char', <?=$character->id?>)"
					value="<?=$character->id?>"
					><?=$character->name?></div>

				<?php endforeach ?>

			<?php endif ?>

			<h4>Caractéristique</h4>
			<div class="diceReply-caracContainer container centering">	

				<?php foreach ($carac as $key => $carac) : ?>
					<div class="carac<?=$carac->id?> diceReply-carac button"
					onclick="choose('carac', <?=$carac->id?>)" 
					data-toggle="tooltip" 
					data-placement="top" 
					title="<?=ucfirst($carac->name)?>"
					style="
					background-image: url('<?=$img->gameicon($carac->icon)?>');
					background-color: <?=$carac->color?>;
					"></div>
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

			<input type="text" name="diceReply-avID" value="<?=$aventure->id?>" hidden>
			<input type="text" name="diceReply-charID" value="<?=$userChar->id?>" hidden>

			<input id="diceReply-submit"  
			type="submit" 
			name="diceReply-submit" 
			value="<?php if ($aventure->userIsGM){echo'Je demande un lancer';}else{echo'Je lance mon dé !';}?>">

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