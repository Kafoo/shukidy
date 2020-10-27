new Vue({
	el: '#av-list',
	name:'av-list',

	data: {
		charList : false,
		characters : [],
		avID : ''
	},

	computed: {
	},

	methods: {

		join: function(charID){

			console.log(charID)

			let posting = $.post("/ajax/CharactersController/addToAv", {
				charID,
				avID : this.avID
			},"json")	

 			posting.done((data)=>{

				if (data === '1') {
					window.location = '/aventures/'+this.avID
				}else{
					alert('Oups, petit problème, désolé.')
					this.list_close()
				}
 			})

		},

		list_close: ()=>{
			$('.custConf').animate({opacity:0}, 200, function(){
				this.characters = []
			})
		},

		tryJoin: function(e){
			e.preventDefault()
			this.avID = $(e.currentTarget).attr('avID')
			console.log(this.avID)
			let url = $(e.currentTarget).attr('href')
			let worldID = $(e.currentTarget).attr("worldID")
			let posting = $.post("/ajax/CharactersController/listByAv", {
				userID, 
				worldID
			}, (data)=>{

				this.charList = true

				this.characters = data
				Vue.nextTick(function(){
					$('.custConf').animate({'opacity':1}, 200)
				})


			},"json")
		}

	}
})