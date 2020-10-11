export default function allogm(){

Vue.directive('tooltipmsg', function(el, binding){
    $(el).tooltip({
             title: binding.value.dat,
             placement: binding.value.placement,
             trigger: 'hover'             
         })
})

new Vue({
	el: '#alloGM',

	mounted(){
		if (!userIsGM) {
			this.update()
		}
		setInterval(()=>{this.update()}, 3000);

	},

	computed: {

	},

	methods: {

		chooseUser(userID){
			this.userID = userID
			this.update()
		},

		scrolltoLast(){

			$('.alloGM-content').animate({
			    scrollTop: 99999
			});

		},

		send(){

			let fromID
			let toID
			let content = this.messageInput
			this.messageInput = ''

			if (userIsGM) {
				fromID = this.gmID
				toID = this.userID
			}else{
				fromID = this.userID				
				toID = this.gmID
			}

			let posting = $.post('/ajax/AlloGMController/add', {				
				fromID: fromID,
				toID: toID,
				avID: avID,
				content: content
			} );

			posting.done(data => {
				this.update()
			});		

		},

		update(){

			let posting = $.post('/ajax/AlloGMController/show', {				
				userID: this.userID,
				avID: this.avID,
				gmID: this.gmID
			} );

			posting.done(data => {
				this.messages = JSON.parse(data)
	        Vue.nextTick(function () {
	            $('[data-toggle="tooltip"]').tooltip()
	        })
				this.scrolltoLast()
			});
		}
	},

	data: {

		avID : avID,
		userID : userID,
		gmID: gmID,
		messages: [],
		messageInput: ''
	}
})

}