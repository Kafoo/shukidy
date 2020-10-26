
<div class="OW" id="notes">
	<div class="mobile">
		<div class="closingArrow"></div>
	</div>
	<h3>NOTES</h3>
	<div class="OWContent">
		<div class="notesPaper" @click="edit()">
			<div class="notesPaperStyle">
				<loading v-if="loading"></loading>
				<div v-else v-html="notes.content" class="notesContent">
				</div>
			</div>

		</div>
		<div class="editNotesBlock" hidden>
			<textarea class="notesPaperStyle" id="editNotesArea" v-model="notesInput"></textarea>

			<div v-if="!loading" class="confirmEditNotes button" @click="send()">
				<span>OK</span>
			</div>
		</div>
	</div>
</div>
