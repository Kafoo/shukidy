<?php
use App\Manager;
use Core\Auth\DBAuth;
$manager = Manager::getInstance();


if (!empty($_POST)) {
	$auth = new DBAuth($manager->getDb());
	if ($auth->login($_POST['username'], $_POST['password'])){
		header('Location: admin.php');
	}else{
		$error = 'Identifiants incorrects';
	}
}
?>



<?php if (isset($error)): ?>
	<div>
		<?=$error?>
	</div>
<?php endif ?>

<form method="POST">
	<input type="text" name="username" placeholder="pseudo">
	<input type="text" name="password" placeholder="mot de passe">
	<input type="submit" name="submit">
</form>