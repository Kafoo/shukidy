<?php
$img = new app\Controller\ImgController;

$post = $variables;
$user = $post->userInfos;
$character = $post->characterInfos;

?>

<div class="writerAvatarSlider">
	
	<div class="writerAvatar GM" style="background-image: url(<?=$img->avatar('GM')?>);">
		<div class="layer desktop">
			<b><u><?=$character->name?></u><br><br>
			<?=$user->username?></b><br>
			<?=$user->msgCount?> messages<br>
			(<?=$user->grade?>)<br><br>
			<i>le 3 mars<br>
			à 4h30</i>
		</div>
	</div>


</div>	