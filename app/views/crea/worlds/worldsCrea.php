<?php
$manager = \app\Manager::getInstance();
$img = new app\Controller\ImgController;

$manager->setTitle('Création d\'univers');
$manager->setStyle('worldsCrea');

$manager->addScript('app','crea.worlds.worldsCrea');

$world = $variables;
?>



<?php if (isset($_GET['p']) AND $_GET['p'] > 0 AND $_GET['p'] < 5): ?>
	
	<div class="p-stock" hidden><?=$_GET['p']?></div>

<?php endif ?>

<div class="worldID-stock" hidden><?=$world->id?></div>

<h1>EDITION<br>"<?= strtoupper($world->name)?>"</h1>


<div class="button selectBigContainer current" bigContainer="description">DESCRIPTION</div>	
<div class="button selectBigContainer" bigContainer="carac">CARACTERISTIQUES</div>	
<div class="button selectBigContainer" bigContainer="races">RACES</div>	
<div class="button selectBigContainer" bigContainer="classes">CLASSES</div>	
<div class="button selectBigContainer" bigContainer="regles">REGLES SPECIALES</div>


<!-------------- DESCRIPTION UNIV -------------->
<div class="bigContainer descriptionBigContainer">
	<h2>DESCRIPTION</h2>

	<div class="helper">Tu peux ici décrire ton univers, de son environnement naturel aux les êtres qui y évoluent, en passant par sa politique, ses conflits, son ambiance, ses couleurs et ses odeurs. Fais-toi plaisir, tu feras plaisir à tes joueurs !</div>


	<div class="univDescription"><?=nl2br($world->description)?></div>
	<div class="button form_button edit_univ" edit="univ">éditer la description</div>
</div>

<!-------------- CARACTERISTIQUES -------------->
<div class="bigContainer caracBigContainer" hidden>
	<h2>CARACTERISTIQUES</h2>

	<div class="helper" id="helper">Ces caractéristiques définiront les attributs des personnages de ton univers. Chaque caractéristique sera représentée par une valeur entre 1 et 10 pour chaque personnage, cette valeur sera choisie par le joueur lors de la création de son personnage.</div>

	<div class="ventreBox caracBox">

			<?php 


			foreach ($world->caracs as $key => $carac) { $key++;?>
				
				<div class="caracContainer"
				carac="<?=$key?>"
				caracID="<?=$carac->id?>"
				<?php 
				if ($carac->name == '' AND $carac->icon == '' AND $carac->color == '#858585'):?>
					hidden
				<?php endif ?>
				>


					<div class="button chooseIcon chooseCaracIcon" carac="<?=$key?>" icon="<?=$carac->icon?>"
					style="background-color: <?=$carac->color?>;<?php
					if ($carac->icon !== '') { ?>
						background-image: url(<?=$img->gameicon($carac->icon)?>);<?php
					}?>
					">
						<?php
						if ($carac->icon == ''){echo"?";}
						?>
					</div>
					<div class="caracContainer-center">
						<input type="text" class="caracName" placeholder="Nom" value="<?=ucfirst($carac->name)?>" maxlength="20"><br>
						<select class="selectIconColor" carac="<?=$key?>">
							<option value="#858585" <?php if($carac->color == '#858585'){echo"selected";} ?>>Gris</option>
							<option value="#ffffff" <?php if($carac->color == '#ffffff'){echo"selected";} ?>>Blanc</option>
							<option value="#F44336" <?php if($carac->color == '#F44336'){echo"selected";} ?>>Rouge</option>
							<option value="#4CAF50" <?php if($carac->color == '#4CAF50'){echo"selected";} ?>>Vert</option>
							<option value="#3a53dd" <?php if($carac->color == '#3a53dd'){echo"selected";} ?>>Bleu</option>
							<option value="#9C27B0" <?php if($carac->color == '#9C27B0'){echo"selected";} ?>>Violet</option>
							<option value="#FF9800" <?php if($carac->color == '#FF9800'){echo"selected";} ?>>Orange</option>
							<option value="#FFEB3B" <?php if($carac->color == '#FFEB3B'){echo"selected";} ?>>Jaune</option>
							<option value="#795548" <?php if($carac->color == '#795548'){echo"selected";} ?>>Marron</option>
							<option value="#ff64a6" <?php if($carac->color == '#ff64a6'){echo"selected";} ?>>Rose</option>
							<option value="#00caca" <?php if($carac->color == '#00caca'){echo"selected";} ?>>Cyan</option>
						</select>
					</div>
					<div class="button delete" carac="<?=$key?>"></div>
				</div>
			<?php
			} ?>
		</div>

		<div class="button form_button addCarac">Ajouter une caractéristique</div>
		<div class="button form_button cancel_carac">Annuler les changements</div>
		<div class="button form_button edit_carac">Valider les changements</div>
	</div>
</div>

<!-------------- RACES -------------->
<div class="bigContainer racesBigContainer" hidden>
	<h2>RACES</h2>
	<div class="helper"><b>Une race représente la nature biologique profonde d'un personnage</b>, c'est à dire l'espèce animal/végétal/monstrueuse/etc à laquelle il appartient.<br><!-- 
	-->Chaque race possède ses propres <b>capacités</b>, qui sont des <b>pouvoirs passifs</b>. Par exemple, un elfe peut avoir la capacité de voir très loin. Cette capacité pourrait s'appeler "longue vue" et fait partie de la nature du personnage</div>

	<div class="ventreBox">
		<div class="raceBox">
			<h3>Races disponibles :</h3>
			<select class="selectBox selectAttribute selectNature selectRace" select="race"></select>
			<div class="raceDescriptions" hidden></div>
			<div class="descriptionContainer">
				<div class="natureBackground raceBackground"></div>				
				<div class="descriptionBox raceDescription"></div>
			</div>
			<div class="button chooseIcon chooseNatureIcon-hidden chooseRaceIcon"></div>
			<div class="button form_button edit_attribute edit_race" edit="race" hidden>éditer cette race</div>
			<div class="button form_button delete_button delete_nature delete_race" natureType="race" hidden>supprimer cette race</div>
		</div>

		<!------ ADD RACE ------>
		<div class="addBox addRace">
			<div class="addTitle">
				<div class="addIcone"></div>
				<div class="addLabel">
				Ajouter une race
				</div>
				<div class="addIcone"></div>
			</div>

			<div class="addContainer" hidden>
				<label>nom :</label><br>
				<input class="race_name" type="text" maxlength="20"><br>


				<label>Description :</label><br>
				<textarea class="race_description"></textarea><br>
				<label>logo :</label><br>
				<div class="button chooseIcon chooseNewNatureIcon chooseNewRaceIcon">?</div><br>
				<input type="submit" class="button nature_submit" nature_type="race" value="Créer cette race">
			</div>
		</div>

	</div>

	<!-------------- CAPACITES DE LA RACE -------------->
	<div class="ventreBox">
		<div class="capaBox">
			<h3>Capacités de la race :</h3>
			<select class="selectBox selectAttribute selectPower selectCapa" select="capa"><option>---</option></select>
			<div class="capaDescriptions" hidden></div>
			<div class="descriptionContainer">
				<div class="natureBackground capaBackground"></div>	
				<div class="descriptionBox capaDescription">pas encore de capacité pour cette race</div>
			</div>
			<div class="button form_button edit_attribute edit_capa" edit="capa" hidden>éditer cette capacité</div>	
			<div class="button form_button delete_button delete_power delete_capa" powerType="capa" hidden>supprimer cette capacité</div>	
		</div>

		<!------ ADD CAPA ------>
		<div class="addBox addCapa">
			<div class="addTitle">
				<div class="addIcone"></div>
				<div class="addLabel">Ajouter une capacité pour cette race</div>
				<div class="addIcone"></div>
			</div>

			<div class="addContainer" hidden>
				<label>nom :</label><br>
				<input class="capa_name" type="text" maxlength="20"><br>


				<label>Description :</label><br>
				<textarea class="capa_description"></textarea><br>

				<input type="submit" class="button power_submit" power_type='capa' value="Créer cette capacité">
			</div>
		</div>
	</div>
</div>

<!-------------- CLASSES -------------->
<div class="bigContainer classesBigContainer" hidden>
	<h2>CLASSES</h2>
	<div class="helper"><b>Une classe représente la spécialisation d'un personnage</b>, son métier en quelque sorte.<br><!-- 
	-->Chaque classe possède ses propres <b>disciplines</b>, qui sont des <b>pouvoirs actifs</b>, c'est à dire qu'ils peuvent être utilisés ponctuellement. Par exemple, un mage peut avoir la discipline "Boule de feu" et l'utiliser aussi souvent que ce que le niveau de cette discipline le permet.</div>

	<div class="ventreBox">
		<div class="classeBox">
			<h3>Classes disponibles :</h3>
			<select class="selectBox selectAttribute selectNature selectClasse" select="classe"></select>
			<div class="classeDescriptions" hidden></div>
			<div class="descriptionContainer">
				<div class="natureBackground classeBackground"></div>	
				<div class="descriptionBox classeDescription"></div>
			</div>

			<div class="button chooseIcon chooseNatureIcon-hidden chooseClasseIcon"></div>

			<div class="button form_button edit_attribute edit_classe" edit="classe" hidden>éditer cette classe</div>
			<div class="button form_button delete_button delete_nature delete_classe" natureType="classe" hidden>supprimer cette classe</div>
		</div>

		<!------ ADD CLASSE ------>
		<div class="addBox addClasse">
			<div class="addTitle">
				<div class="addIcone"></div>
				<div class="addLabel">Ajouter une classe</div>
				<div class="addIcone"></div>
			</div>

			<div class="addContainer" hidden>
				<label>nom :</label><br>
				<input class="classe_name" type="text" maxlength="20"><br>


				<label>Description :</label><br>
				<textarea class="classe_description"></textarea><br>
				<label>logo :</label><br>
				<div class="button chooseIcon chooseNewNatureIcon chooseNewClasseIcon">?</div><br>
				<input type="submit" class="button nature_submit" nature_type="classe" value="Créer cette classe">
			</div>
		</div>

	</div>
	<div class="ventreBox">
	<!-------------- DISCIPLINES DE LA CLASSE -------------->

		<div class="discBox">
			<h3>Disciplines de la classe :</h3>
			<select class="selectBox selectAttribute selectPower selectDisc" select="disc"><option>---</option></select>
			<div class="discDescriptions" hidden></div>
			<div class="descriptionContainer">
				<div class="natureBackground discBackground"></div>	
				<div class="descriptionBox discDescription">Pas encore de discipline pour cette classe</div>
			</div>
			<div class="button form_button edit_attribute edit_disc" edit="disc" hidden>éditer cette discipline</div>
			<div class="button form_button delete_button delete_power delete_disc" powerType="disc" hidden>supprimer cette discipline</div>		
		</div>

		<!------ ADD DISC ------>
		<div class="addBox addDisc">
			<div class="addTitle">
				<div class="addIcone"></div>
				<div class="addLabel">Ajouter une discipline pour cette classe</div>
				<div class="addIcone"></div>
			</div>

			<div class="addContainer" hidden>
				<label>nom :</label><br>
				<input class="disc_name" type="text" maxlength="20"><br>


				<label>Description :</label><br>
				<textarea class="disc_description"></textarea><br>

				<input type="submit" class="button power_submit" power_type='disc' value="Créer cette discipline">
			</div>
		</div>
	</div>
</div>


<!-------------- REGLES SPECIALES -------------->
<div class="bigContainer reglesBigContainer" hidden>
	<h2>REGLES SPECIALES</h2>

	<div class="helper">Tu peux définir des règles de jeu associé à cet univers. <br>Par exemple, tu peux vouloir que tout le monde écrive à la 3e personne, ou que les joueurs n'utilisent une caractéristique que dans un cas bien particulier.</div>

	<div class="regles"><?=$world->regles?></div>
	<div class="button form_button edit_regles" edit="regles">éditer les règles</div>
</div>
