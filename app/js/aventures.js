import tinymce_init from './assets/tinymce_init.js'
import textreply from './aventures/textreply.js'
import {dicereply, choose, chooseChar} from './aventures/dicereply.js'
import allogm from './aventures/allogm.js'
import showingOW from './assets/showingOW.js'
import GMDashboard from './aventures/GMDashboard.js'


tinymce_init('desktop')
showingOW()

textreply();
dicereply();
window.choose = choose
window.chooseChar = chooseChar

allogm()
GMDashboard()


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
				tinymce_init('desktop');
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
				tinymce_init('mobile');
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
