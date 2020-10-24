<?php
$img = new app\Controller\ImgController;

$post = $variables;
$user = $post->userInfos;
$character = $post->characterInfos;
?>

<div class="writerAvatarSlider">
	<div class="writerAvatar" 
	style="background-image: url(<?=$img->avatar($character->id, '.min')?>);"
	onclick="window.location = '/sheet/<?=$character->id?>'">
		<div class="layer desktop">
			<b><u><?=$character->name?></u><br><br>
			<?=$user->username?></b><br>
			<?=$user->msgCount?> messages<br>
			(<?=$user->grade?>)<br><br>
			<i>le <?=$post->date?><br>
			à <?=$post->time?></i>
		</div>
	</div>
</div>	