<!DOCTYPE html>
<html>
<head>

	<?php
	$img = new app\Controller\ImgController;
	?>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, shrink-to-fit=no">
	<?=\app\Manager::getInstance()->getDefaultStyle()?>
	<?=\app\Manager::getInstance()->getStyle()?>
	<title><?=\app\Manager::getInstance()->getTitle()?></title>
</head>
<body>

<div id="bigHeader">
	

	<!------- HEADER DESKTOP ------->
	<header id="headerDesktop" class="desktop">
		

		<img src="/public/img/main/header_title_blanc2.png" id="branding" style="cursor: pointer;" onclick="window.location='accueil.php';">


	</header>

		<!---- CONNECTION DESKTOP ---->
		<div id="connectionDesktop" class="desktop">
			<!-- Disconnected User -->
			<?php if (!isset($_SESSION['connected'])) { ?>
				<div id="disconnectedDesktop">
					<form method="POST" onsubmit="return false">
						<input type="text" name="pseudoConnect" placeholder="Pseudo" id ="un">
						<input type="password" name="passwordConnect" placeholder="Mot de passe" id ="deux">
						<input type="submit" value="Se connecter" @click=trylogin()>
						<div id="nouveau">Nouveau ?</div>
					</form>
				</div>
			<?php } ?>

			<!-- Connected User -->
			<?php if (isset($_SESSION['connected'])) {
				?>
				<div id="connectedDesktop">
					<a id="connectedPseudo" href="profil.php"><b><?=$_SESSION['username']?></b></a> (<a @click=logout()><i><u>Déconnexion</u></i></a>)<br/>
					Grade : <?=$_SESSION['grade']?><br/>
					<i>[[some options]]</i>
				</div>
			<?php } ?>

		</div>

	<!----- NAV DESKTOP ----->
	<nav id="navDesktop" class="desktop">
		<div class="centering">
			<ul>
				<li><a class="nav1" href="/">ACCUEIL</a></li>
				<li><a class="nav2" href="/aventures">AVENTURES</a></li>
				<li><a class="nav3" href="/univers">UNIVERS</a></li>
				<li><a class="nav4" href="/profil">PROFIL</a></li>
				<li><a class="nav5" href="/help">HELP</a></li>
			</ul>
		</div>
	</nav>


	<!------- HEADER MOBILE ------->
	<div class="mobile">
		<header id="headerMobile">
			<img id="navLogo" src="<?=$img->icon('mobile.menu')?>">
			<img id="croixNav" src="<?=$img->icon('mobile.croix')?>" hidden>
			<img id="croixConnection" src="<?=$img->icon('mobile.croix')?>" hidden>
			<img id="connectionLogo" src="<?=$img->icon('mobile.userlogo')?>">
		</header>
	</div>

	<!---- TOOLTIPS MOBILE ---->

	<div class="mobile">
		<div id="topMenuMobile" hidden>
			<div class="arrowUP"></div>
		</div>
	</div>
</div>



<!------ JAVASCRIPT STOCK ----->
<script type="text/JavaScript"> 
  var userID = <?= $_SESSION['auth'] ?>
</script>
<div id="root" hidden><?=ROOT?></div>



<!-- -------- CONTENU -------- -->
<section id="app">
<?=$content?>

</section>


<script src="/node_modules/jquery/dist/jquery.js"></script>
<script src="/app/js/assets/bootstrap.js"></script>
<?php if ($_SESSION['isLocal']): ?>
	<script src="/node_modules/vue/dist/vue.js"></script>
<?php else : ?>
	<script src="/node_modules/vue/dist/vue.min.js"></script>	
<?php endif; ?>
<?=\app\Manager::getInstance()->getDefaultScript()?>
<?=\app\Manager::getInstance()->getScripts()?>


</body>
</html>

?>