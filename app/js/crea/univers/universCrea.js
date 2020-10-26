/*CHOOSE ICONE*/

//Fonction principale
function chooseIcon(target, callBack){

	let iconsBox = $('<div class="iconsBox"></div>')
	$('body').append(iconsBox)
	iconsBox.animate({opacity:1}, 200)
	iconsBox.html('<p class="saving"><span>.</span><span>.</span><span>.</span></p>')
	iconsBox.load('/app/views/templates/icons.php', function(){

		//Comportements dans le pop-up, une fois que son contenu est chargé
		$('.iconsCat').click(function(){
			$('.iconsCat').removeClass('current')
			$(this).addClass('current')
			let cat = $(this).attr('cat')
			$('.iconsContainer').hide();
			$('.iconsContainer[cat="'+cat+'"]').show()
		})

		$('.icon').click(function(){
			let icon = $(this).attr('icon')
			let cat = $(this).attr('cat')
			iconsBox.animate({opacity:0}, 200, function(){
				iconsBox.remove()
			})
			callBack(cat, icon)
		})

		//On enlève la box si on clique ailleurs
		$(document).mouseup(function(e){
		    // If the target of the click isn't the iconsBox
		    if(!iconsBox.is(e.target) && iconsBox.has(e.target).length === 0){
				iconsBox.animate({opacity:0}, 200, function(){
					iconsBox.remove()
				})
		    }
		});

	})
}

function CaracControl(){

	this.addCarac = function(){
		if ($('.caracContainer:not([hidden])').length == 8) {
			$('.addCarac').hide(100);
		}

		$('.caracContainer[hidden]').first().show(200).removeAttr('hidden')

	}

	this.removeCarac = function(caracKey){
		//On affiche le addCarac button
		$('.addCarac').show(100)
		//On cache la carac
		let caracContainer = $('.caracContainer[carac='+caracKey+']')
		caracContainer.hide(200, function(){
			caracContainer.attr("hidden", true)
			//On vide son nom
			caracContainer.find('.caracName').val('')
			//On vide son icone
			caracContainer.find('.chooseCaracIcon').css({'background':''}).html('?')
			caracContainer.find('.chooseCaracIcon').attr("icon", '')
			//On met la couleur sur Gris
			caracContainer.find('.selectIconColor option').first().attr("selected",'selected')
			//On la met au bout des choix de carac
			$('.caracBox').append(caracContainer)
		})
	}


}

var caracControl = new CaracControl()

//--------- SELECT BIG CONTAINER ---------

$('.selectBigContainer').click(function(){
	var what = $(this).attr("bigContainer")
	$('.selectBigContainer').removeClass('current');
	$(this).addClass('current')
	$('.bigContainer').hide(0, function(){
	$('.'+what+'BigContainer').show();
	});
})


//--------- CARAC ICONES ---------

$('.chooseIcon').click(function(){
	let target = $(this)
	chooseIcon(
		target, 
		function(cat, icon){
			target.html('')
			target.attr("icon", cat+'/'+icon)
			target.css('background-image','url(../../public/img/gameicons/'+cat+'/'+icon+')'); 
	})
})

$('.selectIconColor').change(function(){

	let option = $('option:selected', this)

	if (option.value !== 'Couleur') {
		let color = option.val()
		let carac = $(this).attr("carac")
		let chooseIconBox = $('.chooseCaracIcon[carac="'+carac+'"]')
		chooseIconBox.css('background-color',color)
	}
	
})


//--------- ADD CARAC ---------

$('.addCarac').click(function(){
	caracControl.addCarac()
})

//--------- REMOVE CARAC ---------

$('.caracContainer .delete').click(function(){
	let caracKey = $(this).attr("carac")
	caracControl.removeCarac(caracKey)
})

//--------- CANCEL CARACS ---------

$('.cancel_carac').click(function(){
	var univID = $('.univID-stock').html()
	window.location = '/crea/univ/'+univID+'?p=2'
})

//--------- CONFIRM CARACS ---------

$('.edit_carac').click(function(e){

	let caracs = {}
	//On récupère toutes les carac
	var caracContainer = $('.caracContainer')

	for (var i = 0; i <= caracContainer.length-1; i++) {
		let caracBox = $(caracContainer[i])
		let caracX = 'carac'+(i+1)
		//On défini les choix
		let name = caracBox.find('.caracName').val()
		let color = caracBox.find('option:selected', '.selectIconColor').val()
		let icon = caracBox.find('.chooseCaracIcon').attr("icon")
		let id = caracBox.attr("caracID")
		let num = i+1
		//On les ajoute dans un objet, qui sera lui même dans l'objet caracs
		caracs[caracX] = JSON.stringify({'num':num, 'icon':icon, 'name':name, 'color':color, 'id':id})
	}
	console.log(caracs);

	//Loading
	$('.edit_carac').html('...')
	$.post({
		url: '/ajax/UniversController/editCaracs',
		data: {
			caracs: caracs
		},
  		dataType: 'html',

  		success: function(data, statut){
  			if (data == '') {			
	  			$('.edit_carac').html('C\'est validé !')
	  			setTimeout(function(){
	  				$('.edit_carac').html('Valider les caractéristiques')
	  			}, 2000)
  			}
  		},
	})	


})


//--------- REFRESH NATURE OR POWER ---------

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
	//On vide les descriptions en stock
	$('.'+what+'Descriptions').empty()

	let posting = $.post('/ajax/UniversController/getInfos', {				 
		univID : univID,
		what : what,
		natureID : natureID
	} ); 

	posting.done(data => {
		data = JSON.parse(data)
		//On vide les choix et la description
		$('.select'+What).html('');
		$('.'+what+'Description').html('');
		//S'il n'y a pas encore d'attribut existant
		if (data.length == 0) {
			$('.select'+What).html('<option>---</option>');
			$('.'+what+'Description').html('pas encore de '+type);
			$('.edit_'+what).hide();
			$('.delete_'+what).hide();			
		}else{
			//On refresh les pouvoirs correspondants à la nature
			if (what == 'race') {refresh('capa', data[0]['id'])}
			if (what == 'classe') {refresh('disc', data[0]['id'])}
			//Pour chaque attribut, on l'ajoute aux choix
			$.each(data, function(key, value){
				//Et on met la description du premier et son icon
				if (key == 0) {
					$('.'+what+'Description').html(value['description'].replace(/(?:\r\n|\r|\n)/g, '<br>'))
					if (what === 'race' || what === 'classe') {
						$('.'+what+'Background').css('background-image','url(../../public/img/gameicons/'+value['icon']+')')		
					}
				}
				$('.select'+What).append("<option id='"+value['id']+"' icon='"+value['icon']+"'>"+value['name']+"</option>")
				$('.'+what+'Descriptions').append('<div class="'+what+'Description-stock" attrID="'+value['id']+'">'+value["description"]+'</div>')
			})
			//On affiche les boutons d'édition et suppression
			$('.edit_'+what).show();
			$('.delete_'+what).show();				
		}
	})


}
//On affiche la description correspondante à n'importe quel changement
$('.selectAttribute').change(function(){
	var what = $(this).attr("select")
	let id = $('option:selected', this).attr("id")
	var description = $('.'+what+'Description-stock[attrID="'+id+'"]').html().replace(/(?:\r\n|\r|\n)/g, '<br>')
	$('.'+what+'Description').html(description)
	//On change le background pour les natures
	if (what == 'race' || what == 'classe') {
		let icon = $('option:selected', this).attr("icon")
		$('.'+what+'Background').css('background-image','url(../../public/img/gameicons/'+icon+')')
	}
})

//On refresh les pouvoirs lorsqu'on change de nature
$('.selectNature').change(function(){
	var natureID = $(this).attr("id")
	var natureID = $('option:selected', this).attr("id");
	if ($(this).hasClass('selectRace') ) {
		refresh('capa', natureID)
	}
	if ($(this).hasClass('selectClasse') ) {
		refresh('disc', natureID)
	}
})

// On initialise tout au chargement
refresh('race')
refresh('classe')


//--------- EDIT DESCRIPTION ---------

function editUniv(){
	let descriptionBox = $('.univDescription')
	var description_old = descriptionBox.html()
	var format_description = description_old.replace(/\<br>/g, '');
	descriptionBox.replaceWith('<textarea class="editArea univDescription">'+format_description+'</textarea>')
	let descriptionBox_new = $('.univDescription')
	descriptionBox_new.focus()
    var v = descriptionBox_new.html();
    descriptionBox_new.html('');
    descriptionBox_new.html(v);
    descriptionBox_new.scrollTop(2000); 
	$(this).replaceWith('<div class="button form_button confirm_button confirm_univ">valider</div>')
	$('.confirm_univ').one("click", confirm_editUniv);
}

function confirm_editUniv(){

	var univID = $('.univID-stock').html();
	var submit = $(this)
	var descriptionBox = $('.univDescription');
	var description_new = descriptionBox.val();
	descriptionBox.replaceWith('<div class="univDescription"></div>')
	$(this).replaceWith('<div class="button form_button edit_univ" edit="univ">éditer la description</div>')

    $('.edit_univ').one("click", editUniv);


	//Loading

	$('.univDescription').html('<p class="saving"><span>.</span><span>.</span><span>.</span></p>');

	$.post({
		url: '/ajax/UniversController/edit',
		data: {
			what: 'description',
			univID: univID,
			value: description_new
		},
  		dataType: 'html',

  		success: function(data){
  				$('.univDescription').html(description_new.replace(/(?:\r\n|\r|\n)/g, '<br>'))
  		},
	})


}

$('.edit_univ').one("click", editUniv);



//--------- EDIT REGLES ---------

function editRegles(){
	let reglesBox = $('.regles')
	var regles_old = reglesBox.html()
	var format_regles = regles_old.replace(/\<br>/g, '');
	reglesBox.replaceWith('<textarea class="editArea regles">'+format_regles+'</textarea>')
	let reglesBox_new = $('.regles')
	reglesBox_new.focus()
    var v = reglesBox_new.html();
    reglesBox_new.html('');
    reglesBox_new.html(v);
    reglesBox_new.scrollTop(2000); 
	$(this).replaceWith('<div class="button form_button confirm_button confirm_regles">valider</div>')
	$('.confirm_regles').one("click", confirm_editRegles);
}

function confirm_editRegles(){

	var univID = $('.univID-stock').html();
	var submit = $(this)
	var reglesBox = $('.regles');
	var regles_new = reglesBox.val();
	reglesBox.replaceWith('<div class="regles"></div>')
	$(this).replaceWith('<div class="button form_button edit_regles" edit="univ">éditer les regles</div>')

    $('.edit_regles').one("click", editRegles);


	//Loading

	$('.regles').html('<p class="saving"><span>.</span><span>.</span><span>.</span></p>');

	$.post({
		url: '/ajax/UniversController/edit',
		data: {
			what: 'regles',
			univID: univID,
			value: regles_new
		},
  		dataType: 'html',

  		success: function(data, statut){

  			$('.regles').html(regles_new.replace(/(?:\r\n|\r|\n)/g, '<br>'))
  		},
	})

}

$('.edit_regles').one("click", editRegles);




//--------- EDIT ATTRIBUTE ---------

function edit(){
	var what = $(this).attr("edit");
	var What = what[0].toUpperCase() + what.substring(1)
	var descriptionBox = $('.'+what+'Description')
	var selectBox = $('.select'+What)
	var name_old = $('option:selected', '.select'+What).html();
	if (name_old.length > 1) {		
		var Name_old = name_old[0].toUpperCase() + name_old.substring(1)
	}else{
		Name_old = name_old.toUpperCase();
	}
	var description_old = descriptionBox.html();
	var format_description = description_old.replace(/\<br>/g, '');

	selectBox.after('<input type="text" class="editArea selectBox select'+What+'" maxlength="20" value="'+Name_old+'">')
	selectBox.hide();
	descriptionBox.replaceWith('<textarea class="editArea descriptionBox '+what+'Description">'+format_description+'</textarea>')
	let descriptionBox_new = $('.'+what+'Description')
	descriptionBox_new.focus()
    var v = descriptionBox_new.html();
    descriptionBox_new.html('');
    descriptionBox_new.html(v);
    descriptionBox_new.scrollTop(2000);
    let chooseIconBox = $('.choose'+What+'Icon')
	let icon
	let chooseIcon
	if (what === 'race' || what === 'classe') {

		icon = $('option:selected', '.select'+What).attr("icon") 
	}
	chooseIconBox.css('background-image','url(../../public/img/gameicons/'+icon+')').attr("icon",icon)
	chooseIconBox.removeClass('chooseNatureIcon-hidden')
	chooseIconBox.addClass('chooseNatureIcon')
	$(this).replaceWith('<div class="button form_button confirm_button confirm_'+what+'" edit="'+what+'">valider</div>')
	$('.delete_'+what).hide();
	$('.confirm_'+what).click(confirm_edit);
}

function confirm_edit(){
	var submit = $(this)
	var what = $(this).attr("edit");
	var What = what[0].toUpperCase() + what.substring(1)
	//On définit "type" comme un "what" qui aurait toutes ses lettres
	var type;
	var icon;
	var natureID;
    let chooseIconBox = $('.choose'+What+'Icon')
	if (what == 'capa') {
		type = 'capacité'
		natureID = $('option:selected', '.selectRace').attr("id");
	}
	else if (what == 'disc') {
		type = 'discipline'
		natureID = $('option:selected', '.selectClasse').attr("id");
	}else{
		type = what
		icon = chooseIconBox.attr("icon")
	}
	var descriptionBox = $('.'+what+'Description')
	var selectBox = $("select.select"+What)
	var editArea = $("input.select"+What)
	var description_new = descriptionBox.val().trim();
	var name_new = editArea.val().trim();
	var id = $('option:selected', '.select'+What).attr("id");
	var icon = 	chooseIconBox.attr("icon")

    if (name_new !== '') {
    	if (description_new !== '') {
			descriptionBox.replaceWith('<div class="descriptionBox '+what+'Description"></div>')
			selectBox.show();
			editArea.remove();
			chooseIconBox.removeClass('chooseNatureIcon')
			chooseIconBox.addClass('chooseNatureIcon-hidden')
			$(this).replaceWith('<div class="button form_button edit_button edit_'+what+'" edit="'+what+'">éditer cette '+type+'</div>')
		    $('.edit_'+what).hide();
		    $('.edit_'+what).one("click", edit);
			//Loading
			$('.select'+What).html('<option>...</option>');
			$('.'+what+'Description').html('<p class="saving"><span>.</span><span>.</span><span>.</span></p>');
			$('.'+what+'Background').css('background-image','')
			let attribute = {"id": id, "icon": icon, "name": name_new, "description": description_new}	
			$.post({
				url: '/ajax/UniversController/editAttribute',
				data: {
					what: what,
					attribute: JSON.stringify(attribute)
				},
		  		dataType: 'html',

		  		success: function(data, statut){
		  			$('.'+type+'_name').val('');
		  			$('.'+type+'_description').val('');
		  			refresh(what, natureID)
		  		},
			})
    	}else{
    		alert('Il faut écrire une description ;-)')
    	}
    }else{
    	alert('il faut écrire un nom ;-)')
    }



}

$('.edit_attribute').click(edit);


//--------- CREATE SLIDE ---------


$('.addTitle').click(function(e){
	$(this).siblings('.addContainer').slideToggle();
	if ($(this).children('.addIcone').length > 0){
		$(this).children('.addIcone').replaceWith('<div class="upArrow"></div>')
	}else{
		$(this).children('.upArrow').replaceWith('<div class="addIcone"></div>')
	}
})


//--------- CREATE NATURE ---------

$('.nature_submit').click(function(){
	var submit = $(this)
	var univID = $('.univID-stock').html();
	var what = submit.attr("nature_type");
	var What = what[0].toUpperCase() + what.substring(1)
	var nature_name = $('.'+what+'_name').val().trim();
	var nature_description = $('.'+what+'_description').val().trim();
	let chooseIconBox = $('.chooseNew'+What+'Icon')
	var icon = chooseIconBox.attr("icon")

    if (nature_name !== '') {
    	if (nature_description !== '') {
    		if (typeof icon !== 'undefined') {
				$('.add'+What+' .addTitle').click()
				//Loading
				$('.select'+What).html('<option>...</option>');
				$('.'+what+'Description').html('<p class="saving"><span>.</span><span>.</span><span>.</span></p>');
				$('.'+what+'Background').css('background-image','')	
				let nature = {"name": nature_name,"type": what, "description": nature_description, "icon": icon}

				$.post({
					url: '/ajax/UniversController/createNature',
					data: {
						univID: univID,
						nature: JSON.stringify(nature)
					},
			  		dataType: 'json',

			  		success: function(data, statut){
			  			if (data['success'] === 0) {
			  				alert(data['msg'])
			  				refresh(what)
			  			}else{
				  			$('.'+what+'_name').val('');
				  			$('.'+what+'_description').val('');
				  			refresh(what);
			  			}
			  		}
				})

    		}else{
    			alert('Il faut choisir une icone ;-)')
    		}
    	}else{
    		alert('Il faut écrire une description ;-)')
    	}
    }else{
    	alert('il faut écrire un nom ;-)')
    }
})

//--------- DELETE NATURE ---------

$('.delete_nature').click(function(e){

	var what = $(e.currentTarget).attr("natureType");

	customConfirm(
		//msg
		'Tu es sûr de vouloir supprimer cette '+what+' ?',
		//yesMsg
		'Carrément !',
		//noMsg
		'Euh en fait non',
		//yesCallBack
		function(){
			var univID = $('.univID-stock').html();
			var What = what[0].toUpperCase() + what.substring(1);
			var natureID = $('option:selected', '.select'+What).attr("id");
			//Loading
			$('.select'+What).html('<option>...</option>');
			$('.'+what+'Description').html('<p class="saving"><span>.</span><span>.</span><span>.</span></p>');
			$('.'+what+'Background').css('background-image','')	

			$.post({
				url: '/ajax/UniversController/deleteNature',
				data: {
					natureID: natureID,
				},
		  		dataType: 'json',

		  		success: function(data, statut){
		  			if (data['success'] === 0) {
		  				alert(data['msg'])
		  				refresh(what)
		  			}else{
		  				refresh(what)
		  			}
		  		}
			})
		},
		//noCallBack
		function(){
		})
})


//--------- CREATE POWER ---------

$('.power_submit').click(function(e){
	var submit = $(this)
	var univID = $('.univID-stock').html();
	var what = submit.attr("power_type");
	var What = what[0].toUpperCase() + what.substring(1)
	var NatureType;
	if (what == 'capa') {NatureType = 'Race'}
	else if (what == 'disc') {NatureType = 'Classe'}
	var natureID = $('option:selected', '.select'+NatureType).attr("id");
	var name = $('.'+what+'_name').val().trim();
	var description = $('.'+what+'_description').val().trim();
    if (name !== '') {
    	if (description !== '') {

			$('.add'+What+' .addTitle').click()
			//Loading
			$('.select'+What).html('<option>...</option>');
			$('.'+what+'Description').html('<p class="saving"><span>.</span><span>.</span><span>.</span></p>');	
			let power = {"name": name,"type": what, "description": description, "lvl":1}

			$.post({
				url: '/ajax/UniversController/createPower',
				data: {
					univID: univID,
					natureID: natureID,
					power: JSON.stringify(power)
				},
		  		dataType: 'json',

		  		success: function(data, statut){
		  			if (data['success'] === 0) {
		  				alert(data['msg'])
		  				refresh(what, natureID)
		  			}else{
			  			$('.'+what+'_name').val('');
			  			$('.'+what+'_description').val('');
			  			refresh(what, natureID)
		  			}
		  		}
			})
    	}else{
    		alert('Il faut écrire une description ;-)')
    	}
    }else{
    	alert('il faut écrire un nom ;-)')
    }
})

//--------- DELETE POWER ---------

$('.delete_power').click(function(e){
	customConfirm(
		//msg
		'Tu es sûr de vouloir supprimer ce pouvoir ?',
		//yesMsg
		'Oui !',
		//noMsg
		'Ah non, en fait non...',
		function(){			
		//yesCallBack
			var univID = $('.univID-stock').html();
			var what = $(e.currentTarget).attr("powerType");
			var NatureType;
			if (what == 'capa') {NatureType = 'Race'}
			else if (what == 'disc') {NatureType = 'Classe'}
			var natureID = $('option:selected', '.select'+NatureType).attr("id");
			var What = what[0].toUpperCase() + what.substring(1);
			var powerID = $('option:selected', '.select'+What).attr("id");
			//Loading
			$('.select'+What).html('<option>...</option>');
			$('.'+what+'Description').html('<p class="saving"><span>.</span><span>.</span><span>.</span></p>');

			$.post({
				url: '/ajax/UniversController/deletePower',
				data: {
					powerID: powerID,
				},
		  		dataType: 'json',

		  		success: function(data, statut){
		  			if (data['success'] === 0) {
		  				alert(data['msg'])
		  				refresh(what, natureID)
		  			}else{
			  			refresh(what, natureID)
		  			}
		  		},
			})
		},
		function(){
		//noCallBack
		})

})

//COSTUM CONFIRM
function customConfirm(msg, yesMsg, noMsg, yesCallBack, noCallBack){

	let confirmBox = $('<div class="custConf"></div>')
	let msgBox = $('<div class="custConf_msg">'+msg+'</div>')
	let choicesBox = $('<div class="custConf_choices"></div>')
	let yesBox = $('<div class="button custConf_yes">'+yesMsg+'</div>')
	let noBox = $('<div class="button custConf_no">'+noMsg+'</div>')

	choicesBox.append(yesBox, noBox)
	confirmBox.append(msgBox, choicesBox)
	$('body').append(confirmBox)
	$('.custConf').animate({opacity:1}, 200)

	$('.custConf_yes').click(function(){
		yesCallBack()
		$('.custConf').animate({opacity:0}, 200, function(){
			$('.custConf').remove()		
		})
	})
	$('.custConf_no').click(function(){
		noCallBack()
		$('.custConf').animate({opacity:0}, 200, function(){
			$('.custConf').remove()		
		})
	})	
}


//CHANGE PAGE
if ($('.p-stock').html() !== undefined){
	let page = $('.p-stock').html()
	$('.selectBigContainer')[page-1].click()
}