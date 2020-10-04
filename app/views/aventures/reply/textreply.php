		<form class="OW" id="classicReply" 
		method="POST" 
		onsubmit="return false">
			<div class="mobile">
				<div class="closingArrow"></div>
			</div>
			<textarea class="mytextarea" id="tinymce-classicReply" name="message"></textarea>
			<input type="text" name="charID" value="<?=$userChar->id?>" hidden>
			<input type="text" name="avID" value="<?=$aventure->id?>" hidden>
			<input type="submit" name="submit" value='Je réponds !'>
		</form>