export default function GMDashboard() {

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
			//Faire plutôt un foreach cond, suivant la nouvelle archi bdd
			/*c1Cond : parseInt(parent.find('.c1Cond_val').val()),
			c2Cond : parseInt(parent.find('.c2Cond_val').val()),
			c3Cond : parseInt(parent.find('.c3Cond_val').val()),
			c4Cond : parseInt(parent.find('.c4Cond_val').val()),
			c5Cond : parseInt(parent.find('.c5Cond_val').val()),*/
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

}