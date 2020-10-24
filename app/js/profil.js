$('.choice-delete').click(function(){

	if (confirm('La suppression est définitive, tu es sûr de vouloir supprimer ton personnage ?')) {


		let charID = $(this).attr('charID')
		let posting = $.post("/ajax/CharactersController/delete", {
			charID : charID
		} );

		posting.done(function(data) {
			location.reload()
		});

	}

})