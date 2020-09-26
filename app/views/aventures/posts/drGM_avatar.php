<?php
$img = new app\Controller\ImgController;

$post = $variables;
$user = $post->userInfos;
$character = $post->characterInfos;
?>

<div class="writerAvatarSlider">
	
	<img src="<?=$img->icon('jet_white')?>"
	class="diceRoll_icon desktop">

</div>	