export default function allogm(){ 
 
new Vue({ 
	el: '#notes', 
 
	mounted(){ 
		this.update()
		console.log(this)
	}, 
 
	methods: { 
 
		edit(){ 
			this.notesInput = this.notes.content.replace(/<br \/>/g,''); 
			$(".notesPaper").slideToggle(200); 
			$(".editNotesBlock").slideToggle(200, function(){ 
				$("#editNotesArea").focus(); 
			}) 
		}, 
 
		send(){ 
 			this.loading = true
			let avID = this.avID 
			let userID = this.userID 
 
			let content =  this.notesInput 
 
			let posting = $.post('/ajax/NotesController/update', {				 
				avID: avID, 
				userID: userID, 
				content: content 
			} ); 
 
			posting.done(data => { 
				this.update() 
				$(".notesPaper").slideToggle(200); 
				$(".editNotesBlock").slideToggle(200); 
			});		 
		}, 
 
		update(){ 

 			this.loading = true

			let posting = $.post('/ajax/NotesController/show', {				 
				avID: this.avID, 
				userID: this.userID 
			} ); 
 
			posting.done(data => { 
				this.notes = JSON.parse(data)
				//using .html() to avoid <br/> fuc**** issues 
				/*$('.notesContent').html(this.notes.content) */
				this.loading = false
			}); 
		} 
	}, 
 
	data: { 
 
		avID : avID, 
		userID : userID, 
		notes: '', 
		notesInput: '',
		loading: false
	} 
}) 
 
}