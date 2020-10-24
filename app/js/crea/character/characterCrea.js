/*------ INITIALIZE ------*/

/*import Pager from './pager.js'
import CharacterCreaController from './characterCreaController.js'*/

function Pager(){

	let totalPages = $('.pageContainer').length
	let previousPage = 1
	let currentPage = 1
	
	var pagesBigContainer = $('.pagesBigContainer')
	var firstPageContainer = $('.pageContainer[page="1"]')


	var goFirstPage = function(){
		set_bigContainerHeight(1)
		updateNav(1)
		$('.pageContainer').css("left","1000%")
		firstPageContainer.css("left","0")
	}


	var updateNav = function(page){
		//On change le titre
		$('.pageCount').html(page+'/'+totalPages)
		$('.pageName').html(getPageName(page))
		//On change la navigation des pages
		if (page > 1) {
			$('.pagerPrev').show()
			$('.pagerPrev').html('<- '+getPageName(page-1))
		}else{ //On cache le premier si besoin
			$('.pagerPrev').hide()
		}
		if (page < totalPages) {
			$('.pagerSubmit').hide()
			$('.pagerNext').show()
			$('.pagerNext').html(getPageName(page+1)+' ->')		
		}else{ //On affiche le submit en dernière page
			$('.pagerNext').hide()			
			$('.pagerSubmit').show()
		}
	}

	var set_bigContainerHeight = function(page){
		let pageHeight = $('.pageContainer[page="'+page+'"]').height()
		pagesBigContainer.height(pageHeight)
	}

	var getPageName = function(page){
		let pageName = $('.pageContainer[page="'+page+'"]').attr('pageName')
		return pageName
	}

	var showError = function(msg){
		$('.pagerError').html('Attention ;-)<br>'+msg)
		$('.pagerErrorContainer').slideDown(100)
		$('.pagerErrorContainer').animate({opacity:"1"}, 100)
	}

	var hideError = function(){
		$('.pagerErrorContainer').animate({opacity:"0"}, {"duration":100, "queue": false})
		$('.pagerErrorContainer').slideUp(100)
	}

	$(".closingError").click(function(e){
		hideError()
	});

	var changePage = (previousPage, nextPage)=>{
		//On enlève les erreurs
		hideError()
		//On change la navigation
		updateNav(nextPage)
		//On affiche la bonne page
		let nextPageContainer = $('.pageContainer[page="'+nextPage+'"]')
		let previousPageContainer = $('.pageContainer[page="'+previousPage+'"]')
		set_bigContainerHeight(nextPage)
		//On fait glisser a gauche ou à droite
		if (previousPage < nextPage) {
			previousPageContainer.animate({left:'-100%'}, 200)
		}else{
			previousPageContainer.animate({left:'200%'}, 200)
		}
		nextPageContainer.animate({left:'0'}, {"duration":200, "queue": false})
		//On ramène le scroll au title
		this.scrollToTitle()
	}

	this.getCurrentPage = function(){
		return currentPage;
	}

	this.scrollToTitle = function(){

		let currentScrollTop = $("html, body").scrollTop()
		let pagerScrollTop = $('.pagerTitle').offset().top - 50 // marge de 50 pour le sticky nav
		//Si on est plus bas, on monte.
		if (currentScrollTop > pagerScrollTop) {
 			$("html, body").stop().animate( { scrollTop: pagerScrollTop },300);
		}
	}


	this.goPrevPage = function(){
		if (currentPage > 1) {
			previousPage = currentPage			
			currentPage--
			changePage(previousPage, currentPage)
		}
	}

	this.goNextPage = function(){
		if (currentPage < totalPages) {			
			//Si il y a un checker, on check les conditions de la page
			if (typeof checkPager !== 'undefined') {
				let check = checkPager(currentPage)
				//Conditions ok : page suivante
				if (check == true) {
					previousPage = currentPage
					currentPage++
					changePage(previousPage, currentPage)
				}else{
					showError(check)
				}
				//Dans tous les cas on remonte
				this.scrollToTitle()
			//Si pas de checker : page suivante directement
			}else{
				previousPage = currentPage
				currentPage++
				changePage(previousPage, currentPage)
			}
		}
	}

	//USER BEHAVIOR
	$('.pagerPrev').click(()=>{
		this.goPrevPage()
	})

	$('.pagerNext').click(()=>{
		this.goNextPage()
	})

	//INITIALIZE
	goFirstPage()

}

function Controller_creaperso(){

	this.totalCarac = 5

	this.changeCaracDisplay = function(caracID, caracVal){

		var that = this

		$('.displayCarac-value[carac="'+caracID+'"]').html(caracVal)


		//Compte le total des carac et l'affiche dans total
		var totalCaracBox = $(".totalCarac")
		var arrayCarac = $(".displayCarac-value");
		var count = 0;
		for (var i = 0; i < arrayCarac.length; i++) {
			var add = arrayCarac[i].innerHTML;
			count = count + Number(add);
		}
		totalCaracBox.html(count);
		this.totalCarac = count
		//Change la couleur du total en fonction de l'objectif
		var objectif = arrayCarac.length*5; 
		if (count < objectif) {
			totalCaracBox.css("color", "blue");
		}
		if (count > objectif) {
			totalCaracBox.css("color", "red");
		}
		if (count == objectif) {
			totalCaracBox.css({"color": "#00ff00","font-weight":"bold"});
		}


	}

}

const pager = new Pager()
const controller = new Controller_creaperso()

/*------ REFRESH ------*/


function refresh(what, natureID = 0){
	var univID = $('.univID-stock').html()
	var What = what[0].toUpperCase() + what.substring(1)
	//On définit "type" comme un "what" qui aurait toutes ses lettres
	var type;
	if (what == 'capa') {type = 'capacité'}
	else if (what == 'disc') {type = 'discipline'}
	else {type = what}
	//Loading
	$('.select'+What).html('<option>...</option>');
	$('.'+what+'Description').html('<p class="saving"><span>.</span><span>.</span><span>.</span></p>');
	$('.'+what+'Background').css('background-image','')	
	let posting = $.post('/ajax/UniversController/getInfos', {				 
		univID : univID,
		what : what,
		natureID : natureID
	} ); 

	posting.done(data => { 
		let parsedata = JSON.parse(data)
		//On vide les choix et la description
		$('.select'+What).html('');
		$('.'+what+'Description').html('');
		//S'il n'y a pas encore d'attribut existant
		if (parsedata.length == 0) {
			$('.select'+What).html('<option>---</option>');
			$('.'+what+'Description').html('pas encore de '+type);
			$('.edit_'+what).hide();
			$('.delete_'+what).hide();			
		}else{
			//On refresh les pouvoirs correspondants à la nature
			if (what == 'race') {refresh('capa', parsedata[0]['id'])}
			if (what == 'classe') {refresh('disc', parsedata[0]['id'])}
			//Pour chaque attribut, on l'ajoute aux choix
			$.each(parsedata, function(key, value){
				//(on met la description du premier et son icon)
				if (key == 0) {
					$('.'+what+'Description').html(value['description'])
					$('.'+what+'Background').css('background-image','url(../../public/img/gameicons/'+value['icon']+')')		
				}
				$('.select'+What).append("<option value='"+value['description']+"' id='"+value['id']+"' icon='"+value['icon']+"'>"+value['name']+"</option>")
			})
			//On affiche les boutons d'édition et suppression
			$('.edit_'+what).show();
			$('.delete_'+what).show();				
		}
	}); 

}

// On initialise tout au chargement
refresh('race')
refresh('classe')


$('input[type=range]').on('input', function () {
	let caracID = $(this).attr('carac')
	let caracVal = $(this).val()
	controller.changeCaracDisplay(caracID, caracVal)
});


/*------ CHECK CONDITIONS PAGE ------*/

function checkPager(page){
	
	let success = 1
	let msg

	//CARAC CONDITIONS
	if (page == 3) {

		let caracGoal = $('.caracBox').length*5
		let totalCarac = controller.totalCarac

		if (totalCarac !== caracGoal) {
			debugger
			msg = 'Le total des valeurs de tes caractéristiques doit être de '+caracGoal
			success = 0
		}
	}

	//Si les conditions ne sont pas respectées, on retourne l'erreur
	if (success == 0) {
		return msg
	//Sinon on continue
	}else{
		return true
	}

}



//On affiche la description correspondante à n'importe quel changement
$('.selectAttribute').change(function(){
	var what = $(this).attr('select')
	var description = this.value
	$('.'+what+'Description').html(description)
	//On change le background pour les natures
	if (what == 'race' || what == 'classe') {
		let icon = $('option:selected', this).attr('icon')
		$('.'+what+'Background').css('background-image','url(../../public/img/gameicons/'+icon+')')
	}
})

//On refresh les pouvoirs lorsqu'on change de nature
$('.selectNature').change(function(){
	var natureID = $(this).attr('id')
	var natureID = $('option:selected', this).attr('id');
	if ($(this).hasClass('selectRace') ) {
		refresh('capa', natureID)
	}
	if ($(this).hasClass('selectClasse') ) {
		refresh('disc', natureID)
	}
})



//SUBMIT
$('.pagerSubmit').click(function(){

	let caracs = {}
	let caracElements = $('.caracBox .slider')
	caracElements.each(function(index){
		let caracID = $(this).attr("caracID")
		caracs[caracID] = $(this).val()
	})

	console.log(caracs)

	let data = {
		userID : userID,
		univID : $('.univID-stock').html(),
		raceID : $('.selectRace').find(":selected")[0].id,
		capaID : $('.selectCapa').find(":selected")[0].id,
		classeID : $('.selectClasse').find(":selected")[0].id,
		discID : $('.selectDisc').find(":selected")[0].id,
		caracs : caracs,
		name : $('input[name="charName"]').val(),
		nature : $('input[name="charNature"]').val(),
		attitude : $('input[name="charAttitude"]').val(),
		concept : $('input[name="charConcept"]').val(),
		defaut : $('input[name="charDefaut"]').val(),
		lore : $('textarea[name="charLore"]').val(),
	}


	if (data.name.trim() !== '' ) {
		if (data.nature.trim() !== '') {
			if (data.attitude.trim() !== '') {
				if (data.concept.trim() !== '') {
					if (data.defaut.trim() !== '') {
						if (data.lore.trim() !== '') {

							let confirmMsg = 'Es-tu certains des caractéristiques de '+data.name+' ? ;-)'

							if (confirm(confirmMsg)) {
								let posting = $.post("/ajax/CharactersController/create", {
									data:data
								} );

								posting.done(function(data) {

									window.location = '/sheet/'+data

								});
							}else{
							
							}
						}else{
							alert('Il faut un lore')
						}
					}else{
						alert('Il faut un défaut')
					}
				}else{
					alert('Il faut un concept')
				}
			}else{
				alert('Il faut une attitude')
			}
		}else{
			alert('Il faut une nature')
		}
	}else{
		alert('Il faut un nom')
	}

})




//------------------TES6-----------


// Fonction exécutée au redimensionnement, contenu executé seulement au passage mobile/desktop et desktop/mobile
var isMobile;
var lastFormat='';
function redimensionnement(e) {
	if("matchMedia" in window) {
		var currentPage = pager.getCurrentPage()
		let pageHeight = $('.pageContainer[page="'+currentPage+'"]').height()
		var pagesBigContainer = $('.pagesBigContainer')
		pagesBigContainer.height(pageHeight)
	}
}
// On lie l'événement resize à la fonction
window.addEventListener('resize', redimensionnement, false);
// Exécution de cette même fonction au démarrage pour avoir un retour initial
redimensionnement();
