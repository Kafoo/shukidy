const ROOT = $('#root').html();

new Vue({
	el: '#headerDesktop',

	data: {
	},

	methods: {

		trylogin: function(){
			posting = $.post( ROOT+"/ajax/trylogin", { username: $('#un').val(), password: $('#deux').val() } );
			posting.done(function(data) {
				if (data === "loggedin") {
					location.reload()
				}else{
					alert(data);
				}
			});
		},

		logout: function(){
			posting = $.post( ROOT+"/ajax/logout", function(data) {
				location.reload();
			});
		}
	}
})
