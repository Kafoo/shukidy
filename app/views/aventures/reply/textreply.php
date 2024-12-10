		<form class="OW" id="classicReply" 
		method="POST" 
		onsubmit="return false">
			<div class="mobile">
				<div class="closingArrow"></div>
			</div>
			<div class="loading"><div></div><div></div><div></div><div></div></div>
			<textarea class="mytextarea" id="tinymce-classicReply" name="message"></textarea>
			<input type="text" name="charID" value="<?=$userChar->id?>" hidden>
			<input type="text" name="avID" value="<?=$aventure->id?>" hidden>
			<input type="submit" name="submit" value='Je réponds !'>
			<?php if ($aventure->writerID != '0' AND $aventure->writerID !== $_SESSION['auth']): ?>
				<div class="nextWriter">
					<b><i><?=$aventure->writerName?></i></b> aimerait être le prochain à écrire
					<div class="removeDisclaimer">Je veux poster quand même</div>
				</div>
			<?php endif ?>
		</form>