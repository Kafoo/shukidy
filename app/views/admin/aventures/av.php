<?php
$avTable = $manager->getTable('aventures');

/*SUBMIT*/
if (!empty($_POST)) {
	$success = $avTable->update($_GET['avID'], [
		'name' => $_POST['name'],
		'visibility' => $_POST['visibility'],
		'access_lvl' => $_POST['access_lvl']
	]);
	if ($success) {
		$msg = 'Changements sauvegardés !';
	}
}

/*FIND*/
$av = $avTable->find($_GET['avID']);


?>

<?php if (isset($msg)): ?>
	<?= $msg ?>
<?php endif ?>


<form method="POST">
	<input type="text" name="name" value="<?=$av->name?>">
	<input type="text" name="visibility" value="<?=$av->visibility?>">
	<input type="text" name="access_lvl" value="<?=$av->access_lvl?>">
	<input type="submit" name="submit">
</form>

