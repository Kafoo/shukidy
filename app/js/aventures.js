import tinymce_init from './assets/tinymce_init.js'
import textreply from './aventures/textreply.js'
import {dicereply, choose, chooseChar} from './aventures/dicereply.js'
import rollTheDice from './aventures/rollthedice.js'
import allogm from './aventures/allogm.js'
import showingOW from './assets/showingOW.js'
import GMDashboard from './aventures/GMDashboard.js'
import notes from './aventures/notes.js'


showingOW()

window.rollTheDice = rollTheDice

textreply()

dicereply()
window.choose = choose
window.chooseChar = chooseChar

allogm()
notes()
GMDashboard()



//Gère la transition de fixInfo, puisque la max-height doit être générée dynamiquement
function fixInfoDropDown(format) {
	$('.infoPerso').each(function(index){
		let dropdown = $(this).children('.infoPersoDropdown')
		let dropdownHeight = 0
		let dropdownElements = dropdown.children()
		dropdownElements.each(function(){
			dropdownHeight = dropdownHeight+$(this).height()
		})

		if (format === 'mobile') {
			dropdownHeight = 200
		}

		//Animation
		$(this).hover(function(){
			dropdown.css('max-height', dropdownHeight);
			dropdown.css('transition', 'max-height 0.3s');
		}, function(){
			dropdown.css('max-height', '0');
			dropdown.css('transition', 'max-height 0.3s');	
		})

	})
}


//Si Desktop, on affiche le classicReply par défaut
if (window.matchMedia("(min-width: 720px)").matches) {
	$('.showingOW:first').click();
}


/*----MOBILE REPLYOPTIONS----*/

$('.showingOW').click(function(e){if (isMobile) {
	//fixInfos et GMDashBoard plus grandes que les autres
	if (this == $('.showingFixInfos')[0] || this == $('.showingGMDashBoard')[0]) {
		$('.replyContainer').animate({height:'460'},100);
	}else{			
		$('.replyContainer').animate({height:'350'},100);
	}
	$('.closingArrow').show();
	$('.closingArrow').animate({height:'40'},100);
}})


$(".closingArrow").click(function(e){if (isMobile) {
	$('.replyContainer').animate({height:'0'},100);
	$('.closingArrow').animate({height:'0'},100);
	$('.closingArrow').hide();

}})

$('.infoPersoNom a').click(function(e){if (isMobile) {
	e.preventDefault();
}})



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
				tinymce_init('desktop');
				//Ajustements divers
				fixInfoDropDown('desktop')
				$(".replyOption[ow='classicReply']").click();
				$('.replyContainer').animate({height:'450'},100);
				//on redéfini les variables
				isMobile = false;
				lastFormat = 'desktop';
			}
		} else {
			if (lastFormat == 'desktop' || lastFormat == '') {
				//On supprime l'instance si on vient du desktop
				if (lastFormat == 'desktop') {tinymce.get("tinymce-classicReply").remove()};
				//tinymce Initialisation
				tinymce_init('mobile');
				//Ajustements divers
				fixInfoDropDown('mobile')
				$(".showingOW").removeClass("current");
				$('.replyContainer').height(0);
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
