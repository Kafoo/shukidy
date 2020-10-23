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
			this.loading = true
			this.update()
		}
		setInterval(()=>{this.update()}, 10000);

	},

	methods: {

		chooseUser(userID){
			this.userID = userID
			this.loading = true
			this.update()
		},

		scrolltoLast(){

			$('.alloGM-content').animate({
			    scrollTop: 99999
			});

			console.log('scrolled')

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

				let oldCount = Object.keys(this.messages).length

				this.messages = JSON.parse(data)

				let newCount = Object.keys(this.messages).length


		        Vue.nextTick(() => {

					if (oldCount !== newCount) {
						this.scrolltoLast()
					}

		        	this.loading = false

		            $('.alloGM-content[data-toggle="tooltip"]').tooltip()
		        })
			});
		}
	},

	data: {
		avID,
		userID,
		gmID,
		messages: [],
		messageInput: '',
		loading: false
	}
})


}