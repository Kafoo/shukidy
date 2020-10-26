<?php

$iconsCats = scandir('../../../public/img/gameicons');
?>
<!-- AFFICHAGE DES CATEGORIES D'ICONES -->
<div class="iconsCatBox">
	<?php
	foreach ($iconsCats as $key => $iconsCat) { 
		//Les 2 premiers résultats de scandir ne servent pas
		if ($key > 1){?>
			<div class="button iconsCat <?php if ($key == 2) {echo "current";}?>" cat="<?=$iconsCat?>">
				<?=ucfirst($iconsCat)?>
			</div>
		<?php
		}
	} ?>
</div>

<!-- AFFICHAGE DES ICONES -->
<?php
foreach ($iconsCats as $key => $iconsCat) { 
	//Les 2 premiers résultats de scandir ne servent pas
	if ($key > 1){ ?>

		<div class="iconsContainer" cat="<?=$iconsCat?>" <?php if ($key > 2) {echo "hidden";}?> >

			<?php
			//On scan le dossier correspondant à la catégorie
			$icons = scandir('../../../public/img/gameicons/'.$iconsCat);

			foreach ($icons as $key => $icon) {
				if ($key > 1) { ?>
					<div class="button icon" 
					style="background-image: url('../../../public/img/gameicons/<?=$iconsCat?>/<?=$icon?>');"
					icon="<?=$icon?>"
					cat="<?=$iconsCat?>">
					</div>
				<?php
				}
			} ?>
		</div>
	<?php
	}
} ?>

<?php

	if ($key > 1){?>
	<?php
	}



?>