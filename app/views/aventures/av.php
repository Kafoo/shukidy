<?php


$aventure = $variables['aventure'];
$posts = $variables['posts'];

$manager = \App\Manager::getInstance();
$manager->setTitle($aventure->name);
$manager->setStyle('aventures');


?>

<h1>
	<?= strtoupper($aventure->name) ?>
</h1>

<div class="av-grid">

	<?php foreach ($posts as $post): ?>

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

</div>



