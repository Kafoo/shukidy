// TINYMCE INITIALISATION
function tinymceInit($format){
	if (typeof tinymce !== 'undefined') {
		if ($format == 'desktop') {
			tinymce.init({
			    selector: '.mytextarea',
			    content_css : "/public/css/_shared_/tinymce.css",
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
			    plugins: 'code image preview paste'
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
			    plugins: 'code image preview paste'
			});
		}
	}
}

tinymceInit('desktop');


$('.showingOW').click(function(e){
	var OWName = ($(e.currentTarget).attr('OW'));
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



/*ALLO GM*/

//Showing if player
$('.showingAlloGM-direct').click(function() {
	var http = new XMLHttpRequest;
    http.onreadystatechange = function() {
    	if (this.readyState < 4 ) {
    		$('.alloGM-content').html('<div class="loading"><div></div><div></div><div></div><div></div></div>');
    	}
        if (this.readyState == 4 && this.status !== 200) {
        $('.alloGM-content').html('<div class="loading-error"></div>');
       }
        if (this.readyState == 4 && this.status == 200) {
            $('.alloGM-content').html(this.responseText.trim());
            //INIT TOOLTIPS
			$(function () {
			  $('[data-toggle="tooltip"]').tooltip()
			})
       }
    };

    var userID = $('#userID').html();
    var otherID = $('#GMID').html();
    var avID = $('#avID').html();

	http.open('POST','ajax/aventures_allogm.php', true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.send("userID="+userID+"&otherID="+otherID+"&avID="+avID);
	refreshNotifUnseen(); 
});

//Showing if GM

$('.alloGM-playerChoice').click(function(e) {


	var OW = $(".OW#alloGM");
	var otherOW = OW.parent().children('.OW').not(OW);
	OW.show();
	OW.animate({opacity:"1"},100, function(){
		otherOW.animate({opacity:"0"}, 100, function(){
			otherOW.hide();
		})
	});


	var http = new XMLHttpRequest;
    http.onreadystatechange = function() {
    	if (this.readyState < 4 ) {
    		$('.alloGM-content').html('<div class="loading"><div></div><div></div><div></div><div></div></div>');
    	}
        if (this.readyState == 4 && this.status !== 200) {
        $('.alloGM-content').html('<div class="loading-error"></div>');
       }
        if (this.readyState == 4 && this.status == 200) {
			//remove unseen class
			$(e.currentTarget).removeClass("unseen2");
			//showing messages
            $('.alloGM-content').html(this.responseText.trim());
            //INIT TOOLTIPS
			$(function () {
			  $('[data-toggle="tooltip"]').tooltip()
			})
       }
    };

    var userID = $('#GMID').html();
    var otherID = $(e.currentTarget).attr('id');
    var avID = $('#avID').html();

	http.open('POST','ajax/aventures_allogm.php', true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.send("userID="+userID+"&otherID="+otherID+"&avID="+avID);  
	refreshNotifUnseen();  
});

//Stop refresh when stop showing
$('#alloGM').children(".closingCross").click(function(){
	clearInterval(alloRefreshInterval);
})


$('.replyOption:not(.showingAlloGM)').click(function(){
	if (typeof alloRefreshInterval !== 'undefined') {
    	clearInterval(alloRefreshInterval);
	}
})


//Sending

$('.alloGM-textArea').on('keypress', function (e) {
         if(e.which === 13){
         	$('.alloGM-submit').click();
         	return false;
         }
   });

$('.alloGM-submit').click(function(){

	if ($(".alloGM-textArea").val().trim() !== "") {

		var http = new XMLHttpRequest;
	    http.onreadystatechange = function() {
	    	if (this.readyState < 4 ) {
	    		$('.alloGM-submit').addClass('alloGM-loading');
	    		$('.alloGM-loading').removeClass('alloGM-submit button');
	    	}
	        if (this.readyState == 4 && this.status == 200) {
	        	$('.alloGM-loading').addClass('alloGM-submit button');
	        	$('.alloGM-submit').removeClass('alloGM-loading');
	        	if (http.responseText.includes('success')){
	        	}

	       }
	    };

	    var content = $('.alloGM-textArea').val().replace(/\\n/g, '\n');
	    var URIcontent =  encodeURIComponent(content);
	    var tempContent = '<div class="alloGM-msg msg-user temp">'+content+'</div>'
	    var userID = $('#alloGM-userID').attr('userID');
	    var otherID = $('#alloGM-otherID').attr('otherID');
	    var avID = $('#avID').html();
		http.open('POST','server/request_aventures.php', true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.send("action=alloGM&content="+URIcontent+"&userID="+userID+"&otherID="+otherID+"&avID="+avID);	

   		$('.alloGM-content').append(tempContent);
        $('.alloGM-textArea').val('');
       	$('.alloGM-content').scrollTop(9999);
	}
})
	
//Notification unseen

function refreshNotifUnseen(){

	var http_notif = new XMLHttpRequest;
	var avID = $('#avID').html();
	var userID = $('#userID').html();

    http_notif.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
	        if (http_notif.responseText == "[]") {
	        	$('.showingAlloGM').removeClass("unseen1");
	        }
	        else{
	        	var unseenArray = JSON.parse(http_notif.responseText);
	        	var i = 0;
	        	console.log(unseenArray);
	        	unseenArray.forEach(function(unseen){
	        		console.log(unseen);
	        		$('.alloGM-playerChoice').each(function(){
	        			var playerID = this.id;
	        			var playerDOM = this;
	        			if (unseen[0] == playerID) {
	        				$('.alloGM-playerChoice#'+unseen[0]).addClass('unseen2');
	        			}
	        		})
		        	i++;

	        	})
				$('.showingAlloGM').addClass("unseen1");
	        }
       }
      }

	http_notif.open('GET','server/request_aventures.php?action=notifUnseen&avID='+avID+"&userID="+userID, true);
	http_notif.send();
}


/*setInterval(refreshNotifUnseen, 10000);*/


// ---------- GM DASHBOARD ---------

//GM DASHBOARD
$('.GMDashBoard-playerChoice').click(function(e) {

	var userID = $(e.currentTarget).attr('id');
	var OW = $(".OW#GMDashBoard-"+userID);
	var otherOW = OW.parent().children('.OW').not(OW);
	OW.show();
	OW.animate({opacity:"1"},100, function(){
		otherOW.animate({opacity:"0"}, 100, function(){
			otherOW.hide();
		})
	});
});

//Change Values
$('.update_lessPV').click(function(e){
	var bar = $(e.currentTarget).parent().children('.pvBar');
	var currentValue = parseInt(bar.attr('pv_val'));
	var nexValue;
	if (currentValue>0) {
		newValue = currentValue-1;
	}else{
		newValue = currentValue;
	}
	bar.attr('pv_val', newValue);
	bar.attr('data-original-title', newValue+'/10 PV');
	bar.attr('src','/public/img/rpg/pv_'+newValue+'.png');
})

$('.update_morePV').click(function(e){
	var bar = $(e.currentTarget).parent().children('.pvBar');
	var currentValue = parseInt(bar.attr('pv_val'));
	var nexValue;
	if (currentValue<10) {
		var newValue = currentValue+1;
	}else{
		newValue = currentValue;
	}
	bar.attr('pv_val', newValue);
	bar.attr('data-original-title', newValue+'/10 PV');
	bar.attr('src','/public/img/rpg/pv_'+newValue+'.png');
})


$('.updatePerso_submit').click(function(e){
	//On défini toutes les valeurs
	var avID = $('#avID').html();
	console.log(avID);
	var parent = $(e.currentTarget).parent();

	var perso = {
		id : parent.find('.persoID-stock').html(),
		pv : parent.find('.pvBar').attr('pv_val'),
		invent1 : parent.find('.invent1_val').val().trim(),
		invent2 : parent.find('.invent2_val').val().trim(),
		invent3 : parent.find('.invent3_val').val().trim(),
		invent4 : parent.find('.invent4_val').val().trim(),
		invent5 : parent.find('.invent5_val').val().trim(),
		c1Cond : parseInt(parent.find('.c1Cond_val').val()),
		c2Cond : parseInt(parent.find('.c2Cond_val').val()),
		c3Cond : parseInt(parent.find('.c3Cond_val').val()),
		c4Cond : parseInt(parent.find('.c4Cond_val').val()),
		c5Cond : parseInt(parent.find('.c5Cond_val').val()),
		addedXP : parseInt(parent.find('.xpTextArea').val().trim())
	}
    perso = JSON.stringify(perso);

	//On les envoie au serveur pour l'update
	var loading = parent.find('.updatePerso_loading');
	var http = new XMLHttpRequest;
    http.onreadystatechange = function() {
    	if (this.readyState < 4 ) {

    		loading.addClass('littleLoading');
    	}
        if (this.readyState == 4 && this.status !== 200) {
    		loading.addClass('littleLoading');
       }
        if (this.readyState == 4 && this.status == 200) {
    		loading.removeClass('littleLoading');
    		loading.addClass('littleComplete');
       }
    };

	http.open('POST','server/updates.php', true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.send("action=updatePerso&perso="+perso+"&avID="+avID);

})




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
