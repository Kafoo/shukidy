export default function rollTheDice(e){

	let entryID = $(e).attr('entryID')
	let result = Math.ceil(Math.random()*10)

	let data = {

		entryID: entryID,	
		result : result,
	}

	let posting = $.post("/ajax/PostController/rollTheDice", {
		data:data
	} );

	posting.done(function(data) {
		if (data === '') {
			location.reload()
		}else{
			alert(data);
		}
	});
}
