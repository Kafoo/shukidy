<?php
use App\Controller\ImgController;

$img = new ImgController;

$post = $variables;
$user = $post->userInfos;
$character = $post->characterInfos;
?>

<div class="writerAvatarSlider">
	
	<?php if ($post->avatar): ?>
		<div class="writerAvatar" style="background-image: url(<?=$img->getAvatar($character->id)?>);">
			<div class="layer desktop">
				<b><u><?=$character->name?></u><br><br>
				<?=$user->username?></b><br>
				<?=$user->msgCount?> messages<br>
				(<?=$user->grade?>)<br><br>
				<i><?=$post->dat?><br>
				à 4h30</i>
			</div>
		</div>
	<?php endif ?>

</div>	