<div class="ventreBox">

	<h3>Caractéristiques</h3>
	<div class="helper"><b>Ces caractéristiques définissent les attributs de ton personnage.</b> Elles sont propres à chaque univers, et te serviront lorsque tu voudras que ton personnage fasse une action qu'il n'est pas certain de réussir.<br>A ce moment là, tu pourras lancer un dé dont le résultat confirmera ou non la réussite de l'action. <br>La caractéristique associée à l'action nuancera le résultat du dé.</div>

	<table>

		<?php 

		$caracCount = 0;
		foreach ($world->caracs as $key => $carac) { $key++;
		if ($carac->name !== ''){
			$caracCount++;
			?>
			
			<tr class="caracBox">
				<td>
					<label><?=$carac->name?></label>
				</td>
				<td>
					<div class="displayCarac-container">
						<div class="displayCarac-icon" style="background-image: url(<?=$img->gameicon($carac->icon)?>);background-color: <?=$carac->color?>" ></div>
						<div class="displayCarac-value" carac="<?=$key?>">1</div>
					</div>
				</td>
				<td>
					<input class="slider" 
					type="range" 
					min="1" max="10" value="1" 
					name="c<?=$key?>_value" 
					carac="<?=$key?>"
					caracID="<?=$carac->id?>">
				</td>
			</tr>

		<?php
		}} ?>
		<tr style="height: 60px;">
			<td></td>
			<td style="text-align: center; font-weight: bold;"> Total :</td>
			<td class="totalCarac">5</td>
			<td>/<?=$caracCount*5?></td>
		</tr>
	</table>

</div>