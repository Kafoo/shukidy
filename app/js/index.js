$('[data-toggle="tooltip"]').tooltip()

Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
             title: binding.value,
             placement: binding.arg,
             trigger: 'hover'
         })
})

Vue.directive('loading', function(el,binding){
	if (binding == 'true') {
		$(el).html('<div class="loading"><div></div><div></div><div></div><div></div></div>')
	}
	
})

Vue.component('loading', {
    template: `<div class="loading"><div></div><div></div><div></div><div></div></div>`,

})

new Vue({
	el: '#headerDesktop',
	name:'header',
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