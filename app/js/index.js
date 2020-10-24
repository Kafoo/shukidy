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
	el: '#bigHeader',
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



/*NAVIGATION DEROULANTE MOBILE*/

$('#navLogo').click(function(){
	$('#navDesktop').slideToggle(200);
	$("#navLogo").hide();
	$('#croixNav').show();
});


/*CONNEXION DEROULANTE MOBILE*/

$('#connectionLogo').click(function(){
	$('#connectionDesktop').slideToggle(200);
	$("#connectionLogo").hide();
	$('#croixConnection').show();
});






// Fonction exécutée au redimensionnement, contenu executé seulement au passage mobile/desktop et desktop/mobile
var isMobile;
var lastFormat='';
function redimensionnement(e) {
	if("matchMedia" in window) {
		if(window.matchMedia("(min-width:720px)").matches) {
			if (lastFormat == 'mobile' || lastFormat == '') {
				//on redéfini les variables
				isMobile = false;
				lastFormat = 'desktop';
			}
		} else {
			if (lastFormat == 'desktop' || lastFormat == '') {				
				/*----HIDE&SHOW HEADER ON SCROLL----*/

				function slideUpHeader(){
					$('#navDesktop').hide(150);
					$('#connectionDesktop').hide(150);
					$('#headerMobile').slideUp(300,function(){
						$('#navLogo').show();
						$('#connectionLogo').show();
						$('#croixNav').hide();
						$('#croixConnection').hide();		
					});

				}

				var position = $(window).scrollTop(); 
				var iScrollPos = 0;
				var lastSlide = 0;
				var intervalSlide = 50;


				$(window).scroll(function slideHeaderMobile() {
					var currentSlide = Date.now();
				    var iCurScrollPos = $(this).scrollTop();
				    if (currentSlide > lastSlide + intervalSlide) {    	
					    if (iCurScrollPos > iScrollPos) {
					        slideUpHeader();
					    } else {
					       $('#headerMobile').slideDown(300);
					    }
				    }
				    lastSlide = currentSlide;
				    iScrollPos = iCurScrollPos;
				});
				//On cache le nav ou la co si on clique ailleurs
				$(document).mouseup(function(e) {
				    var navMobile = $("#navDesktop");
				    if (!navMobile.is(e.target) && navMobile.has(e.target).length === 0) {
				        navMobile.slideUp(200);
						$('#navLogo').show();
						$('#croixNav').hide();
				    }
				    var connectionDesktop = $("#connectionDesktop");
				    if (!connectionDesktop.is(e.target) && connectionDesktop.has(e.target).length === 0) {
				        connectionDesktop.slideUp(200);
						$('#connectionLogo').show();
						$('#croixConnection').hide();
				    }
				});
				//on redéfini les variables
				isMobile = true;
				lastFormat = 'mobile';
			}
		}
	}
}
// On lie l'événement resize à la fonction
window.addEventListener('resize', redimensionnement, false);
// Exécution de cette même fonction au démarrage pour avoir un retour initial
redimensionnement();
