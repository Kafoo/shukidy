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
$manager->addScript('node','tinymce.tinymce');
$manager->addScript('app','aventures');
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
					<hr>
				<?php endif ?>

			<?php endforeach ?>

		</div>

	<?php endforeach ?>
	
	<div></div><?= $HTML['paging'] ?>

	<div></div><div style="height: 20px" SPACER></div>
		
	<!-- SHOWING OW -->
	<div class="showingOWContainer">

		<div class="desktop" style="height: 15px" SPACER></div>

		<div class="showingOW replyOption" OW="classicReply">
			<img src="<?=$img->icon('notes')?>">
		</div>
		<?php
		if ($aventure->userIsGM === False AND $aventure->lastIsUser === False) { //diceReply possible ou non?>
		<div class="showingOW replyOption" OW="diceReply_error">
			<img src="<?=$img->icon('d20black2')?>">
		</div>
		<?php
		} else{ ?>
		<div class="showingOW replyOption" OW="diceReply">
			<img src="<?=$img->icon('d20black2')?>">
		</div>
		<?php
		} ?>

		<div class="showingOW replyOption" OW="alloGM">
			<img src="<?=$img->icon('allogm2')?>">
		</div>

		<div class="showingOW replyOption" OW="notes">
			<img src="<?=$img->icon('notes2')?>">
		</div>

		<div class="showingOW replyOption mobile" OW="fixinfosMobile">
			<img src="<?=$img->icon('perso')?>">
		</div>

		<?php
		if ($aventure->userIsGM){ ?>
			<div class="showingOW replyOption" OW="GMDashBoard-menu">
				<img src="<?=$img->icon('baguette')?>">
			</div>
		<?php 
		} ?>

	</div>


	<div class="OWContainer replyContainer">
		<!-- REPONSE TEXTE -->

		<?php require ROOT."/app/views/aventures/reply/textreply.php" ?>

		<!-- LANCER DE DES -->

		<?php require ROOT."/app/views/aventures/reply/dicereply.php" ?>

		<!-- ALLO GM -->

		<?php require ROOT."/app/views/aventures/reply/allogm.php" ?>

		<!-- NOTES PERSOS -->

		<?php require ROOT."/app/views/aventures/reply/notes.php" ?>

		<!-- FIXINFOS MOBILE -->

		<div class="OW" id="fixinfosMobile">
			<div class="mobile">
				<div class="closingArrow"></div>
			</div>
			<h3>INFOS PERSOS</h3>
			<div class="OWContent">
				
			</div>
		</div>

		<!-- GM DASHBOARD -->

		<?php include ROOT."/app/views/aventures/reply/dashboard.php" ?>


	</div>



	<!-- NEXTBOX -->

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

<script type="application/javascript">
	var avID = <?=$aventure->id?>;
	var gmID = <?=$aventure->gmID?>;
	var userIsGM = <?= $aventure->userIsGM ? '1' : '0'?>;
</script>





