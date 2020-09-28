<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
	<?=\app\Manager::getInstance()->getDefaultStyle()?>
	<?=\app\Manager::getInstance()->getStyle()?>
	<title><?=\app\Manager::getInstance()->getTitle()?></title>

</head>
<body>



<!------- HEADER DESKTOP ------->
<header id="headerDesktop" class="desktop">
	

	<img src="/public/img/main/header_title_blanc2.png" id="branding" style="cursor: pointer;" onclick="window.location='accueil.php';">

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
<nav id="navDesktop" class="desktop">
	<div class="centering">
		<ul>
			<li><a class="nav1" href="/">ACCUEIL</a></li>|
			<li><a class="nav2" href="/aventures">AVENTURES</a></li>|
			<li><a class="nav4" href="/profil">PROFIL</a></li>|
			<li><a class="nav5" href="/help">HELP</a></li>|
			<li><a class="nav6" href="/univedit/1">EDITION FANTASY</a></li>
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


<!---- NAV MOBILE ---->
<!-- 
<div class="mobile">
	<nav id="navMobile" hidden>
		<ul>
			<li><a class="nav1" href="index.php?p=home">ACCUEIL</a></li>
			<li><a class="nav2" href="index.php?p=av_list">AVENTURES</a></li>
			<li><a class="nav4" href="index.php?p=profil">PROFIL</a></li>
			<li><a class="nav5" href="index.php?p=help">HELP</a></li>
			<li><a class="nav6" href="index.php?p=creauniv?univID=2">EDITION FANTASY</a></li>
		</ul>
	</nav>
</div> 
-->

<!---- CONNECTION MOBILE ---->
<!-- 
<div class="mobile">
	<div id="connectionMobile" hidden>

		Disconnected User
		<?php if (!isset($_SESSION['connected'])) {
			?>
			<div id="disconnectedMobile">
				<form method="POST" action="">
					<input type="text" name="pseudoConnect" placeholder="Pseudo">
					<input type="password" name="passwordConnect" placeholder="Mot de passe">
					<input type="submit" name="connectionSubmit" value="Se connecter">
					<div id="nouveau"><a href="subscribe.php">Nouveau ?</a></div>
				</form>
			</div>
		<?php } ?>

		Connected User
		<?php if (isset($_SESSION['connected'])) {
			?>
			<div id="connectedMobile"> 
				<a id="connectedPseudo" href="profil.php"><b><?=$_SESSION['pseudo']?></b></a> (<a href="SERVER_UPDATES.php?action=disconnect"><u><i>Déconnexion</i></u></a>)<br/>
				Grade : <?=$_SESSION['grade']?><br/>
				<i>[[some options]]</i>
			</div>
		<?php } ?>

	</div>
</div>
 -->

<!------ JAVASCRIPT STOCK HEADER ----->
<div id="userID" hidden><?=$_SESSION['id']?></div>
<div id="root" hidden><?=ROOT?></div>



<!-- -------- CONTENU -------- -->
<section id="app">
<?=$content?>

</section>


<?=\app\Manager::getInstance()->getDefaultScript()?>
<script src="/app/js/libraries/jquery.js"></script>
<script src="/vendor/tinymce/tinymce/tinymce.js"></script>
<script src="/node_modules/vue/dist/vue.js"></script>
<script src="/app/js/main.js"></script>
<?=\app\Manager::getInstance()->getScript()?>




<!-- 
<script type="text/javascript" src="../public/js/_shared_/pager.js"></script>
<script type="text/javascript" src="../public/js/_shared_/controller_carac.js"></script>
<script type="text/javascript" src="../public/js/main.js?v=2"></script>
<script type="text/javascript" src="../public/js/bootstrap.js"></script>
<script type="text/javascript" src="../public/js/materialize.js"></script>
<script type="text/javascript" src="../public/js/_shared_/dotdotdot.js"></script>
 -->

</body>
</html>



<!--------------- OLD START --------------->


<?php

/* ---------- REFRESH ISSUE ---------- */

/*    if(!empty($_POST) OR !empty($_FILES)){
        $_SESSION['sauvegarde'] = $_POST ;
        $_SESSION['sauvegardeFILES'] = $_FILES ;
        
        $fichierActuel = $_SERVER['PHP_SELF'] ;
        if(!empty($_SERVER['QUERY_STRING'])){
            $fichierActuel .= '?' . $_SERVER['QUERY_STRING'] ; 
        }
        
        header('Location: ' . $fichierActuel);
        exit;
    }
    if(isset($_SESSION['sauvegarde'])){
        $_POST = $_SESSION['sauvegarde'] ;
        $_FILES = $_SESSION['sauvegardeFILES'] ;
        
        unset($_SESSION['sauvegarde'], $_SESSION['sauvegardeFILES']);
    }


// ---------- USER CONNECTION ----------

if (!isset($_SESSION['connected'])) {

    //------ IF COOKIE : ------
    if (isset($_COOKIE['auth'])) {
        $auth = $_COOKIE['auth'];
        $auth = explode("---", $auth);
        $checkUser = $bdd->query("SELECT * FROM mas_users WHERE id='$auth[0]' ")->fetch();
        $key = sha1($checkUser['pseudo']);
        if ($key === $auth[1]) {
            $userID = $checkUser['id'];
            $reqUser = $bdd->query("SELECT * FROM mas_users WHERE id='$userID' ");
                $userInfo = $reqUser->fetch();
                $canSetSession = True;
        }
    }

    //------ IF CONNECTION SUBMIT : ------
    if (isset($_POST['connectionSubmit'])) {

        $pseudoConnect = htmlspecialchars($_POST['pseudoConnect']);
        $passwordConnect = sha1($_POST['passwordConnect']);

        if (!empty($_POST['pseudoConnect']) AND !empty($_POST['passwordConnect'])) {

            $reqUser = $bdd->prepare("SELECT * FROM mas_users WHERE pseudo=? AND password=?");
            $reqUser->execute(array($pseudoConnect, $passwordConnect));
            $userExist = $reqUser->rowCount();
            if ($userExist == 1) {
                $userInfo = $reqUser->fetch();
                $canSetSession = True;
                //On créé un cookie
                setcookie('auth', $userInfo['id'].'---'.sha1($userInfo['pseudo']), time()+3600*24*365, null, null, false, true);
                //On redirige vers l'accueil si on est sur une page éphémèr
                if (basename($_SERVER['PHP_SELF']) == "subscribe.php"){
                    header("Location: accueil.php");
                } 
            }
            else{
                $error = "Pseudo ou Mot de passe incorrect !";
            }
        }
        elseif (!empty($_POST['passwordConnect'])){
            $error = "Rentre ton pseudo, ça marchera mieux =P";
        }
        elseif (!empty($pseudoConnect)){
            $error = "Rentre ton mot de passe, ça marchera mieux =P";
        }
        else{
            $error = "Va falloir me donner un peu plus d'infos que ça !";
        }
    }

    //------- DECLARATION DES VARIABLES DE SESSION --------
    if (isset($canSetSession) AND $canSetSession==True) {

        //On met la liste des persoID du user dans un array de session
        $_SESSION['persosArray'] = array();
        $userID = $userInfo['id'];
        $req = $bdd->query("SELECT id
            FROM mas_persos
            WHERE userID = '$userID'");
        $res = $req->fetchall();
        foreach ($res as $perso) {
            array_push($_SESSION['persosArray'], $perso['id']);
        }

        $_SESSION['connected'] = True;
        $_SESSION['id'] = $userID;
        $_SESSION['pseudo'] = $userInfo['pseudo'];
        $_SESSION['password'] = $userInfo['password'];
        $_SESSION['grade'] = $userInfo['grade'];
        $_SESSION['nombremsg'] = $userInfo['nombremsg'];
        
        $canSetSession = False;
    }


} */  

?>