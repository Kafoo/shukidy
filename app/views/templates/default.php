<!DOCTYPE html>
<html>
<head>

	<?php
	$img = new app\Controller\ImgController;
	?>

	<meta charset="utf-8">
	<meta name="viewport" content="height=device-height, 
	                      width=device-width, initial-scale=1.0, 
	                      minimum-scale=1.0, maximum-scale=1.0, 
	                      user-scalable=no">
	<?=\app\Manager::getInstance()->getDefaultStyle()?>
	<?=\app\Manager::getInstance()->getStyle()?>
	<title><?=\app\Manager::getInstance()->getTitle()?></title>
</head>
<body>

	

<!------- HEADER DESKTOP ------->
<header id="header">
	

	<img class='desktop' src="/public/img/main/header_title_blanc2.png" id="branding" style="cursor: pointer;" onclick="window.location='accueil.php';">



	<!---- CONNECTION DESKTOP ---->
	<div id="connectionDesktop">
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

</header>

<!----- NAV DESKTOP ----->
<nav id="navDesktop">
	<div class="centering">
		<ul>
			<li><a class="nav1" href="/">ACCUEIL</a></li>
			<li><a class="nav2" href="/aventures">AVENTURES</a></li>
			<li><a class="nav3" href="/worlds">UNIVERS</a></li>
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



<!------ JAVASCRIPT STOCK ----->
<script type="text/JavaScript"> 
  var userID = <?php if (isset($_SESSION['auth'])){echo $_SESSION['auth'];}else{echo 0;} ?>
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