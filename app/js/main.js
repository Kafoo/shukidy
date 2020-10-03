new Vue({
	el: '#headerDesktop',

	data: {
	},

	methods: {

		trylogin: function(){
			let posting = $.post("/ajax/trylogin", { username: $('#un').val(), password: $('#deux').val() } );
			posting.done(function(data) {
				if (data === '1') {
					location.reload()
				}else{
					alert(data);
				}
			});
		},

		logout: function(){
			let posting = $.post("/ajax/logout", function(data) {
				location.reload();
			});
		}
	}
})

var sectionHeight = $('section').height();
$('.fixInfosSlider').height(sectionHeight-200);