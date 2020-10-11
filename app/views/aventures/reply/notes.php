<div class="OW" id="notes">
	<h3>NOTES</h3>
	<div class="OWContent">
		<div class="notesPaper" @click="edit()">
			<div class="notesPaperStyle">
				<span class="notesContent">
					
				</span>
			</div>
		</div>
		<div class="editNotesBlock" hidden>
			<textarea class="notesPaperStyle" id="editNotesArea" v-model="notesInput"></textarea>
			<div class="confirmEditNotes button" @click="send()">OK</div>
		</div>
	</div>
</div>