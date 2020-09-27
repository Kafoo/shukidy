<div class="OW" id="alloGM_menu">
	<div class="mobile">
		<div class="closingArrow"></div>
	</div>
	<h3>ALLO GM</h3>
	<div class="OWContent">
		<?php
		foreach ($aventure->characters as $character) {
			if ($character->name !== "GM") { ?>
				<div class="alloGM-playerChoice choice-gen button" id="<?=$character->userID?>">
					<?=$character->name?>
				</div>
			<?php
			}
		}
		?>
	</div>
</div>


<div class="OW" id="alloGM">
	<div class="mobile">
		<div class="closingArrow"></div>
	</div>
	<h3>ALLO GM</h3>
	<div class="OWContent">
		<!-- ajax -->
		<div class="alloGM-content">
		</div>
		<textarea class="alloGM-textArea"></textarea>
		<div class="alloGM-submit button"></div>
	</div>
</div>