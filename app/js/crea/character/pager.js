export default function Pager(){

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