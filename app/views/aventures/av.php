<?php
$img = new app\Controller\ImgController;

$aventure = $variables['aventure'];
$characters = $aventure->characters;
$userChar = $aventure->userChar;
$carac = $aventure->carac;
$posts = $variables['posts'];
$HTML = $variables['HTML'];
$manager = \app\Manager::getInstance();
$manager->setTitle($aventure->name);
$manager->setStyle('aventures');
$manager->setScript('aventures');

?>

<h1> <?= strtoupper($aventure->name) ?> </h1>

<?= $HTML['paging'] ?>

<?= $HTML['fixInfos'] ?>

<div class="av-grid">

	<?php foreach ($posts as $key=>$post): ?>
	
		<!-- AVATAR -->

		<?=$post->avatarHTML?>

		<!--POST-->
		
		<div class="msg msg-<?=$post->type?>">

			<?php foreach ($post->entries as $entry): ?>

				<?=$entry->HTML?>
				<!-- separation if entry is not the last of post -->
				<?php if ($entry->separation == True): ?>
					<div class="separate"></div>
				<?php endif ?>

			<?php endforeach ?>

		</div>

	<?php endforeach ?>
	
	<div></div><?= $HTML['paging'] ?>

	<div></div><div style="height: 20px" SPACER></div>
		
	<!-- SHOWING OW -->
	<div class="showingOWContainer">

		<div class="desktop" style="height: 15px" SPACER></div>

		<div class="showingOW replyOption" OW="classicReply" @click="show">
			<img src="<?=$img->icon('notes')?>">
		</div>
		<?php
		if ($aventure->lastIsUser == True) { //diceReply possible ou non?>
		<div class="showingOW replyOption" OW="diceReply">
			<img src="<?=$img->icon('d20black2')?>">
		</div>
		<?php
		} else{ ?>
		<div class="showingOW replyOption" OW="diceReply_error">
			<img src="<?=$img->icon('d20black2')?>">
		</div>
		<?php
		}
		if ($aventure->userIsGM == True) { //Si GM, choix des players?>
			<div class="showingOW replyOption showingAlloGM showingAlloGM_menu" OW="alloGM_menu">
				<img src="<?=$img->icon('allogm2')?>"><div class="unseen"></div>
			</div>
		<?php
		}
		else{ //Sinon, direct la messagerie?>
			<div class="showingOW replyOption showingAlloGM showingAlloGM_direct" OW="alloGM">
				<img src="<?=$img->icon('allogm2')?>">
			</div>
		<?php
		}?>
		<div class="showingOW replyOption showingNotes" OW="notes">
			<img src="<?=$img->icon('notes2')?>">
		</div>

		<div class="showingOW replyOption mobile showingFixInfos" OW="fixinfosMobile">
			<img src="<?=$img->icon('perso')?>">
		</div>

		<?php
		if ($aventure->userIsGM == True){ ?>
			<div class="showingOW replyOption showingGMDashBoard" OW="GMDashBoard-menu">
				<img src="<?=$img->icon('baguette')?>">
			</div>
		<?php 
		} ?>

	</div>

	<div class="OWContainer replyContainer">
		<!-- REPONSE TEXTE -->
		<form class="OW" id="classicReply" method="POST" action="">
			<div class="mobile">
				<div class="closingArrow"></div>
			</div>
			<textarea class="mytextarea" id="tinymce-classicReply" name="message"></textarea>
			<input type="text" name="persoID" value="<?=$userChar->id?>" hidden>
			<input type="submit" name="submit" value='Je réponds !'>
		</form>

		<!-- LANCER DE DES -->
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
						<div class="carac1 diceReply-carac button"
						onclick="choose('carac', '1')" data-toggle="tooltip" data-placement="top" title="<?=ucfirst($caracOfAv['c1_name'])?>"></div>
						<div class="carac2 diceReply-carac button" 
						onclick="choose('carac', '2')" data-toggle="tooltip" data-placement="top" title="<?=ucfirst($caracOfAv['c2_name'])?>"></div>
						<div class="carac3 diceReply-carac button" 
						onclick="choose('carac', '3')" data-toggle="tooltip" data-placement="top" title="<?=ucfirst($caracOfAv['c3_name'])?>"></div>
						<div class="carac4 diceReply-carac button" 
						onclick="choose('carac', '4')" data-toggle="tooltip" data-placement="top" title="<?=ucfirst($caracOfAv['c4_name'])?>"></div>
						<div class="carac5 diceReply-carac button" 
						onclick="choose('carac', '5')" data-toggle="tooltip" data-placement="top" title="<?=ucfirst($caracOfAv['c5_name'])?>"></div>
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
					<input type="text" name="persoID" value="<?=$persoID?>" hidden>
					<?php 
					$persoObjectID = 'perso'.$persoID;
					$persoObjectJson = json_encode($$persoObjectID); 
					?>
					<input type="text" name="persoObjectJson" value='<?=$persoObjectJson?>' hidden>

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


		<!-- ALLO GM -->
		<div class="OW" id="alloGM-menu">
			<div class="mobile">
				<div class="closingArrow"></div>
			</div>
			<h3>ALLO GM</h3>
			<div class="OWContent">
				<?php
				foreach ($coterie as $perso) {
					if ($perso['nom'] !== "GM") { ?>
						<div class="alloGM-playerChoice choice-gen button" id="<?=$perso['userID']?>">
							<?=$perso['nom']?>
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


		<!-- NOTES PERSOS -->
		<div class="OW" id="notes">
			<div class="mobile">
				<div class="closingArrow"></div>
			</div>
			<h3>NOTES</h3>
			<div class="OWContent">
				<div class="notesPaper">
					<div class="notesPaperStyle">
						<span class="notesContent"></span>
					</div>
				</div>
				<div class="editNotesBlock" hidden>
					<textarea class="notesPaperStyle" id="editNotesArea"></textarea>
					<div class="confirmEditNotes button">OK</div>
				</div>
			</div>
		</div>

		<!-- FIXINFOS MOBILE -->
		<div class="OW" id="fixinfosMobile">
			<div class="mobile">
				<div class="closingArrow"></div>
			</div>
			<h3>INFOS PERSOS</h3>
			<div class="OWContent">
				<?php include('content/aventures/fixinfos.php');?>
			</div>
		</div>

		<!-- GM DASHBOARD -->
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
					 <?php include ('ajax/aventures_gmdashboard.php');?>
					</div>
				</div>
			<?php
			}
		} ?>

	</div>

	<?php
	if ($aventure->writerID == '0') { ?>
		<div></div>
		<div class="centering nextBox">
			<div class="button requestNext">
				J'aimerais poster en prochain
			</div>
			<div class="help" data-toggle="tooltip" data-placement="top" title="Si tu veux poster le prochain message sans que quelqu'un d'autre ne fasse d'action qui pourrait compromettre le déroulement de l'aventure tel que tu l'as imaginé, mais que tu n'as pas le temps d'écrire tout de suite : Clique sur le bouton et les autres joueurs le verront ;-) Cependant, pense à poster rapidement pour ne pas faire attendre les autres joueurs trop longtemps !"></div>
		</div>
	<?php
	}elseif ($aventure->writerID == $_SESSION['auth']) { ?>
		<div></div>
		<div class="nextRappel">Souviens-toi que tu as signalé aux autres joueurs que tu voulais poster le prochain message !
			<div class="cancelNext">Annuler</div>
		</div>
	<?php
	}?>


	</div>




</div>





