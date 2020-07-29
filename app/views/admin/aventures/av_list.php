<?php

$aventures = $manager->getTable('aventures')->getAll();

?>

<table>
	<thead>
		<tr>
			<td>ID</td>
			<td>Nom</td>
			<td>Actions</td>
		</tr>
	</thead>
	<tbody>
		
	<?php foreach ($aventures as $av): ?>
		
	<tr>
		<td> <?=$av->id?> </td>
		<td> <?=$av->name?> </td>
		<td>
			<a class="button" href="?p=av&avID=<?=$av->id?>">éditer</a>
			<form action="admin.php?p=av.delete" method="POST">
				<input type="text" name="id" value="<?=$av->id?>" hidden>
				<input type="submit" name="delete" value="Supprimer">
			</form>
		</td>
	</tr>

	<?php endforeach ?>

	</tbody>


	


</table>