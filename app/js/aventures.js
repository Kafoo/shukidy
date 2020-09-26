// TINYMCE INITIALISATION
function tinymceInit($format){
	if (typeof tinymce !== 'undefined') {
		if ($format == 'desktop') {
			tinymce.init({
			    selector: '.mytextarea',
			    content_css : "style/_shared_/tinymce.css",
			    height: 340,
			    menubar: false,
			    forced_root_block : "",
			    statusbar : false,
			    toolbar_drawer : 'floating',
			    paste_auto_cleanup_on_paste : true,
			    paste_remove_styles: true,
			    paste_remove_styles_if_webkit: true,
			    paste_strip_class_attributes: true,
			    fontsize_formats: "6pt 8pt 11pt 14pt 18pt",
			    toolbar: 'undo redo | bold italic | link image | forecolor backcolor | fontsizeselect | code',
			    plugins: 'code image textcolor preview paste'
			});
		}
		if ($format == 'mobile') {
			tinymce.init({
			    selector: '.mytextarea',
			    content_css : "style/_shared_/tinymce.css",
			    height: 184,
			    menubar: false,
			    forced_root_block : "",
			    statusbar : false,
			    toolbar_drawer : 'floating',
			    paste_auto_cleanup_on_paste : true,
			    paste_remove_styles: true,
			    paste_remove_styles_if_webkit: true,
			    paste_strip_class_attributes: true,
			    fontsize_formats: "6pt 8pt 11pt 14pt 18pt",
			    toolbar: 'bold italic | forecolor fontsizeselect',
			    plugins: 'code image textcolor preview paste'
			});
		}
	}
}

tinymceInit('desktop');


$('.showingOW').click(function(e){
	var OWName = ($(e.currentTarget).attr('OW'));

/*
	show = $.post(ROOT+"/ajax/showPV", { partialView: OWName, password: $('#deux').val() } );
	show.done(function(data) {
		if (data === "loggedin") {
			location.reload()
		}else{
			alert(data);
		}
	});
*/


	var OW = $(".OW#"+OWName);
	var otherOW = OW.parent().children('.OW').not(OW);
	OW.show();
	OW.animate({opacity:"1"},100, function(){
		otherOW.animate({opacity:"0"}, 100, function(){
			otherOW.hide();
		})
	});

	//current
	var showingOW = $(e.currentTarget)
	var allShowingOW = $(e.currentTarget).parent().children(".showingOW");
	allShowingOW.removeClass("current");
	showingOW.addClass("current");

});

$(".closingCross,.closingArrow").click(function(e){
	$(e.currentTarget).parent().parent().animate({opacity:"0"}, 100, function(){
		$(e.currentTarget).parent().parent().hide();
	})
});


//Si Desktop, on affiche le classicReply par défaut
if (window.matchMedia("(min-width: 720px)").matches) {
	$('.showingOW:first').click();
}



// Fonction exécutée au redimensionnement, contenu executé seulement au passage mobile/desktop et desktop/mobile
var isMobile;
var lastFormat='';
function redimensionnement(e) {
	if("matchMedia" in window) {
		if(window.matchMedia("(min-width:720px)").matches) {
			if (lastFormat == 'mobile' || lastFormat == '') {
				//On supprime l'instance si on vient du mobile
				if (lastFormat == 'mobile') {tinymce.get("tinymce-classicReply").remove()};
				//tinymce Initialisation
				tinymceInit('desktop');
				//Ajustements divers
				$(".replyOption[ow='classicReply']").click();
				$('#replyContainer').animate({height:'400'},100);
				//on redéfini les variables
				isMobile = false;
				lastFormat = 'desktop';
			}
		} else {
			if (lastFormat == 'desktop' || lastFormat == '') {
				//On supprime l'instance si on vient du desktop
				if (lastFormat == 'desktop') {tinymce.get("tinymce-classicReply").remove()};
				//tinymce Initialisation
				tinymceInit('mobile');
				//Ajustements divers
				$(".showingOW").removeClass("current");
				$('#replyContainer').height(0);
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
