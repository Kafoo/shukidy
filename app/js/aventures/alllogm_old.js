export default function allogm(){


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

}