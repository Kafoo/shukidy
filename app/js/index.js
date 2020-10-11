$('[data-toggle="tooltip"]').tooltip()

Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
             title: binding.value,
             placement: binding.arg,
             trigger: 'hover'             
         })
})

new Vue({
	el: '#headerDesktop',

	data: {
	},

	methods: {

		trylogin: function(){
			let posting = $.post("/ajax/AjaxController/trylogin", { username: $('#un').val(), password: $('#deux').val() } );
			posting.done(function(data) {
				if (data === '1') {
					location.reload()
				}else{
					alert(data);
				}
			});
		},

		logout: function(){
			let posting = $.post("/ajax/AjaxController/logout", function(data) {
				location.reload();
			});
		}
	}
})

var sectionHeight = $('section').height();
$('.fixInfosSlider').height(sectionHeight-200);