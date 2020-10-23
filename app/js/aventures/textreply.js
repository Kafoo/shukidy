export default function textreply() {

	$('#classicReply').submit(function(){
		let content = tinymce.get("tinymce-classicReply").getContent()
		let withoutSpace = content.replaceAll('&nbsp;', ' ').trim()

		let charID = $('input[name="charID"]').val();
		let avID = $('input[name="avID"]').val();

		if (content || withoutSpace !== '') {

			let posting = $.post("/ajax/PostController/post", {
				content: content,
				charID: charID,
				avID: avID

			} );
			posting.done(function(data) {
				if (data === '') {
					window.location = window.location.href.split("?")[0];
				}else{
					alert(data);
				}
			});

		}else{
			//Il faut écrire un message !
		}
		
	})

}