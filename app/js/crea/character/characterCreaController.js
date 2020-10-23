export default function Controller_creaperso(){

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
			totalCaracBox.css("color", "green");
		}


	}

}