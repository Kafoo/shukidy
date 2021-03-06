<div class="OW" id="GMDashBoard-menu">
	<div class="mobile">
		<div class="closingArrow"></div>
	</div>
	<h3>GM DASHBOARD</h3>
	<div class="OWContent">
		<?php
		foreach ($characters as $character) {
			if ($character->name !== "GM") { ?>
				<div class="GMDashBoard-playerChoice choice-gen button" id="<?=$character->userID?>">
					<?=$character->name?>
				</div>
			<?php
			}
		} ?>
	</div>

</div>

<!-- Pour chaque perso, on créé le dashboard correspondant -->
<?php
foreach ($characters as $character) {
	if ($character->name !== "GM") { ?>
		<div class="OW GMDashBoard" id="GMDashBoard-<?=$character->userID?>">
			<div class="mobile">
				<div class="closingArrow"></div>
			</div>
			<!-- ajax -->
			<div class="GMDashBoard-content OWContent">
				<div class="persoID-stock" hidden><?=$character->id?></div>
				<h3><?=$character->name?></h3>
				<h4>PV :</h4>
				<div class="noselect button operate_update update_lessPV">-</div>
				<img src="/public/img/rpg/pv_<?=$character->pv?>.png" pv_val="<?=$character->pv?>" class="noselect pvBar" data-toggle="tooltip" data-placement="bottom" title="<?=$character->pv?>/10 PV">
				<div class="noselect button operate_update update_morePV">+</div>
				<div> 
					<div class="inventBlock">
						<h4>Inventaire :</h4>
						<table>
							<tr><td><textarea class="inventTextArea invent1_val" placeholder="item 1"><?php if ($character->invent1 !== '-') {echo $character->invent1;} ?></textarea></td></tr>
							<tr><td><textarea class="inventTextArea invent2_val" placeholder="item 2"><?php if ($character->invent2 !== '-') {echo $character->invent2;} ?></textarea></td></tr>
							<tr><td><textarea class="inventTextArea invent3_val" placeholder="item 3"><?php if ($character->invent3 !== '-') {echo $character->invent3;} ?></textarea></td></tr>
							<tr><td><textarea class="inventTextArea invent4_val" placeholder="item 4"><?php if ($character->invent4 !== '-') {echo $character->invent4;} ?></textarea></td></tr>
							<tr><td><textarea class="inventTextArea invent5_val" placeholder="item 5"><?php if ($character->invent5 !== '-') {echo $character->invent5;} ?></textarea></td></tr>
						</table>
					</div>
					<div class="condBlock">
						<h4>Conditions :</h4>
						<table>
							<?php foreach ($character->caracs as $carac): ?>
								<tr>
									<td><?=$carac->name?> : </td>
									<td><textarea class="condTextArea c<?=$carac->id?>Cond_val"><?=$carac->cond?></textarea></td>
								</tr>
							<?php endforeach ?>

						</table>
					</div>
				</div>

				<table class="xpBlock">
					<tr>
						<td>+ <textarea class="xpTextArea">0</textarea></td>
						<td> XP</td>
					</tr>
				</table>


				<div class="updatePerso_submit button">Enregistrer<span class="updatePerso_loading"></span></div>
			</div>
		</div>
	<?php
	}
} ?>
