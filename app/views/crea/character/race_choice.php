
<div class="helper">
	<b><u>Choisis ta race et ta première capacité !</u></b><br><br>
	<b>La race représente la nature biologique profonde de ton personnage</b>, c'est à dire l'espèce animal/végétal/monstrueuse/etc à laquelle il appartient.<br>Chaque race possède ses propres <b>capacités</b>, qui sont des <b>pouvoirs passifs</b> (c'est à dire qu'il n'ont pas besoin d'être "lancés")<br>Tu n'auras qu'une capacité pour commencer, mais tu pourras en apprendre d'autres au fur et à mesure de ta progression.
</div>

<!-- RACE -->
<div class="ventreBox">
	<div class="raceBox">
		<h3>Races de <?=$world->name?> :</h3>
		<select class="selectBox selectAttribute selectNature selectRace" select="race"></select>
		<div class="descriptionContainer">
			<div class="natureBackground raceBackground"></div>				
			<div class="descriptionBox raceDescription"></div>
		</div>
	</div>
</div>

<!-- CAPA -->
<div class="ventreBox">
	<div class="capaBox">
		<h3>Ta première capacité :</h3>
		<select class="selectBox selectAttribute selectPower selectCapa" select="capa"></select>
		<div class="descriptionContainer">
			<div class="natureBackground capaBackground"></div>	
			<div class="descriptionBox capaDescription"></div>
		</div>
	</div>
</div>