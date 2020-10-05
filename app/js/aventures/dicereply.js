export function dicereply() {

	$('#diceReply form').submit(function(){

		let title = $('input[name="diceReply-title"]').val();
		let caracID = $('input[name="diceReply-carac"]').val();
		let diff = $('input[name="diceReply-diff"]').val();
		let avID = $('input[name="diceReply-avID"]').val();
		let charID = $('input[name="diceReply-charID"]').val();		
		let result = Math.ceil(Math.random()*10);
		let GM = 0;

		if (title.trim() !== '') {
			if (caracID) {
				if (diff) {

					alert('Tu as fait '+ result +' à ton jet ! ;-)');
			
					let posting = $.post("/ajax/PostController/dicereply", {
						title: title,
						caracID: caracID,
						diff: diff,
						avID: avID,
						charID: charID,
						result: result,
						GM: GM
					} );

					posting.done(function(data) {
						if (data === '') {
							location.reload()
						}else{
							alert(data);
						}
					});

				}else{
					alert('tu dois choisir une difficulté')
				}
			}else{
				alert('tu dois choisir une caractéristique')
			}
		}else{
			alert('tu dois écrire un titre')
		}


	})
}

export function choose(what, choice){
	$(".diceReply-"+what).removeClass('current');
	$(".diceReply-"+what+"."+what+choice).addClass('current');
	$('#'+what+'Stock')[0].setAttribute("value", choice);
}