<div class="helper">
	<b><u>Choisis ta classe et ta première discipline !</u></b><br><br>
	<b>Une classe représente la spécialisation d'un personnage</b>, son métier en quelque sorte.<br>Chaque classe possède ses propres <b>disciplines</b>, qui sont des <b>pouvoirs actifs</b>, c'est à dire qu'ils peuvent être utilisés ponctuellement.<br>Tu n'auras qu'une discipline pour commencer, mais tu pourras en apprendre d'autres au fur et à mesure de ta progression.
</div>

<!-- CLASSE -->
<div class="ventreBox">
	<div class="classeBox">
		<h3>Classes de <?=$univers->name?> :</h3>
		<select class="selectBox selectAttribute selectNature selectClasse" select="classe"></select>
		<div class="descriptionContainer">
			<div class="natureBackground classeBackground"></div>				
			<div class="descriptionBox classeDescription"></div>
		</div>
	</div>
</div>

<!-- DISC -->
<div class="ventreBox">
	<div class="discBox">
		<h3>Ta première discipline :</h3>
		<select class="selectBox selectAttribute selectPower selectDisc" select="disc"></select>
		<div class="descriptionContainer">
			<div class="natureBackground discBackground"></div>	
			<div class="descriptionBox discDescription"></div>
		</div>
	</div>
</div>