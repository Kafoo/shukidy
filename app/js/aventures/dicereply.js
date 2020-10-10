export function dicereply() {

	$('#diceReply form').submit(function(){

		let postOne = function(charID){

			let data = {

				title: title,
				caracID: caracID,
				diff: diff,
				avID: avID,
				charID: charID,		
				result : result,
				GM: GM
			}

			let posting = $.post("/ajax/PostController/dicereply", {
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


		let title = $('input[name="diceReply-title"]').val()
		let caracID = $('input[name="diceReply-carac"]').val()
		let diff = $('input[name="diceReply-diff"]').val()
		let avID = $('input[name="diceReply-avID"]').val()
		let charID = $('input[name="diceReply-charID"]').val()
		let GM = $('input[name="diceReply-GM"]').val()
		let result

		if (GM === '1') {
			result = '?'
		}else{
			result = Math.ceil(Math.random()*10)
		}

		let charDom = $('.diceReply-char.choice-gen.current')

		if (GM === '1' && charDom.length > 0 
			|| GM === '0') {

			if (title.trim() !== '') {

				if (caracID) {

					if (diff) {

						if (GM === '1') {
							charDom.each(function(index){
								console.log($(this))
								console.log($(charDom[index]))
								charID = $(this).attr('value')
								postOne(charID)
							})
						}else{

							charID = $('input[name="diceReply-charID"]').val()
							postOne(charID)
						}

					}else{
						alert('tu dois choisir une difficulté')
					}
				}else{
					alert('tu dois choisir une caractéristique')
				}
			}else{
				alert('tu dois écrire un titre')
			}
		}else{
			alert('tu dois choisir au moins un personnage')
		}


	})
}

export function choose(what, choice){
	$(".diceReply-"+what).removeClass('current');
	$(".diceReply-"+what+"."+what+choice).addClass('current');
	$('#'+what+'Stock')[0].setAttribute("value", choice);
}

export function chooseChar(what, choice){
	$(".diceReply-"+what+"."+what+choice).toggleClass('current');
}
