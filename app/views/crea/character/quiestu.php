
<div class="ventreBox">
	<h3>Informations générales</h3>
	<table id="formBases">
		<tr>
			<td><label for="charName"><b>Nom :</b></label></td>
			<td><input type="text" name="charName" placeholder="Nom du perso" maxlength="20" value="<?php if (isset($_POST['charName'])){echo $_POST['charName'];}else{echo'';}?>"></td>
			<td></td>
		</tr>
		<tr>
			<td><label for="charNature">Nature :</label></td>
			<td><input type="text" name="charNature" placeholder="1 adjectif" maxlength="20" value="<?php if (isset($_POST['charNature'])){echo $_POST['charNature'];}else{echo'';}?>"></td>
			<td>
				<div class="helpDiv" id="helpNature" hidden>La nature d'un personnage est sa véritable personnalité, ce qu'il est fondamentalement. <br/><i>Exemples : simplet, démoniaque, passionné, intéressé, altruiste, pervers...</i></div>
			</td>
		</tr>
		<tr>
			<td><label for="charAttitude">Attitude :</label></td>
			<td><input type="text" name="charAttitude" placeholder="1 adjectif" maxlength="20" value="<?php if (isset($_POST['charAttitude'])){echo $_POST['charAttitude'];}else{echo'';}?>"></td>
			<td>
				<div class="helpDiv" id="helpAttitude" hidden>L'attitude d'un personnage est ce qu'il montre de sa personnalité. Plus elle est contraire à sa nature, plus le personnage cache son jeu.<br/><i>Exemples : simplet, démoniaque, passionné, intéressé, altruiste, pervers...</i></div>
			</td>
		</tr>
		<tr>
			<td><label for="charConcept">Concept :</label></td>
			<td><input type="text" name="charConcept" placeholder="1 concept" maxlength="20" value="<?php if (isset($_POST['charConcept'])){echo $_POST['charConcept'];}else{echo'';}?>"></td>
			<td>
				<div class="helpDiv" id="helpConcept" hidden>Le concept d'un personnage est ce qui prépondère le plus dans sa vie d'humain (avant l'Etreinte) : son métier, sa passion, ou encore sa position sociale.<br/><i>Exemples : drogue addict, charpentier, boxer, hermite...</i></div>
			</td>
		</tr>
		<tr>
			<td><label for="charDefaut">Défaut :</label></td>
			<td><input type="text" name="charDefaut" placeholder="Ton défaut" maxlength="30" value="<?php if (isset($_POST['charDefaut'])){echo $_POST['charDefaut'];}else{echo'';}?>"></td>

			<td>
				<div class="helpDiv" id="helpDefaut" hidden>Un petit défaut de ton choix, pour donner un peu de réalisme à ton perso !</i></div>
			</td>
		</tr>
		<tr>
			<td><label for="charPhysique">Physique :</label></td>
			<td><textarea name="charPhysique" placeholder="Ton physique"><?php if (isset($_POST['charPhysique'])){echo $_POST['charPhysique'];}else{echo'';}?></textarea></td>

			<td>
				<div class="helpDiv" id="helpPhysique" hidden>Le physique de ton personnage</i></div>
			</td>
		</tr>
	</table>
</div>

<div class="ventreBox">
	<h3>QUEL EST TON HISTOIRE ?</h3>
	<div class="helper">
		<b>C'est ici que tu vas décrire librement ton personnage, ce qu'il a vécu, ce qui fait ce qu'il est aujourd'hui, son physique.</b><br><br>Quel âge a-t-il ? A-t-il un travail, de la famille, des amis ? Est-qu'une cicatrice lui fend le visage, aime-t-il rester seul plutôt qu'entouré ?<br><br>Libre à toi d'écrire 3 lignes, ou un bouquin ;-)
	</div>
	<textarea name="charLore" placeholder="Allez, raconte-nous tout."><?php if (isset($_POST['charLore'])){echo $_POST['charLore'];}else{echo'';}?></textarea>
</div>