var app = new Vue({
  el: "#app",
	computed: {
		selectedContact () {
			return this.contacts[this.selectedContactIndex]
		},
		selectedChannel () {
			return this.contacts[this.selectedContactIndex].channels[this.contacts[this.selectedContactIndex].selectedChannelIndex]
		}
	},
	methods: {
		addContact () {
			axios.get('https://randomuser.me/api/')
				.then(response => {
					let contact = response.data.results[0]
					this.contacts.push({
						name: contact.name.first + ' ' + contact.name.last,
						profileImage: contact.picture.medium,
						userId: contact.id.value,
						newChannelInput: "",
						messageInput: "",
						makeNewChannel: false,
						selectedChannelIndex: 0,
						channels: [{
							name: "MAIN",
							color: "#09f",
							messages: []
						}]
					})
				})
		},
		addButtonClick () {
			this.selectedContact.makeNewChannel = true
			this.$nextTick(() => {
				this.$refs.newChannelInput.focus()
			})
		},
		newChannel (name) {
			if (name.length > 0) {
				this.selectedContact.channels.push({
					name: this.selectedContact.newChannelInput,
					color: "#09f",
					messages: []
				})
				this.selectedContact.newChannelInput = ""
				this.selectedContact.makeNewChannel = false
				this.selectedContact.selectedChannelIndex = this.selectedContact.channels.length - 1
				this.$refs.newMessageInput.focus()
			}
		},
		onChannelInputBlur () {
			if (this.selectedContact.newChannelInput === '') {
				this.selectedContact.makeNewChannel = false
			} else {
				this.newChannel(this.selectedContact.newChannelInput)
			}
		},
		changeChannelColor (event) {
			let newColor = window.getComputedStyle(event.target).backgroundColor
			this.selectedChannel.color = newColor
		},
		deleteCurrentChannel () {
			let channelIndex = this.contacts[this.selectedContactIndex].selectedChannelIndex
			if (channelIndex > 0) { // Can't delete the main channel
				this.selectedContact.selectedChannelIndex = 0
				this.selectedContact.channels.splice(channelIndex, 1)
				this.showOptions = false
			}
		},
		deleteCurrentContact () {
			this.contacts.splice(this.selectedContactIndex, 1)
			if (this.selectedContactIndex > 0) {
				this.selectedContactIndex--
			}
		},
		newMessage () {
			let url ='https://api.adviceslip.com/advice'
			if (this.selectedContact.messageInput.length > 0) {
				let today = new Date()
				this.selectedContact.channels[this.contacts[this.selectedContactIndex].selectedChannelIndex].messages.push({
					content: this.selectedContact.messageInput, 
					authorId: this.userId,
					time: this.getTime(),
					date: this.getDate()
				})
				this.firstMessageSent = true
				this.selectedContact.messageInput = ''
				
				if (Math.floor(Math.random() * 3) === 1) {
					axios.get(url)
						.then(response => {
							this.selectedChannel.messages.push({
								content: response.data.slip.advice, 
								authorId: this.selectedContact.userId,
								time: this.getTime(),
								date: this.getDate()
							})
						})				
				}
			}
		},
		closePopup () {
			if (this.showOptions) {
				console.log('loser')
				this.showOptions = false			
			}
		},
		getDate () {
			let date = new Date()
			return date.getFullYear() + "-" + (((date.getMonth()+1) < 10)?"0":"") + (date.getMonth()+1) + "-" + ((date.getDate() < 10)?"0":"") + date.getDate()
		},
		getTime () {
			let date = new Date()
			return ((date.getHours() < 10)?"0":"") + date.getHours() +":"+ ((date.getMinutes() < 10)?"0":"") + date.getMinutes()
		}
	},
	data: {
		"darkMode": false,
		"showUserMenu": false,
		"showOptions": false,
  	"userId": "FExpl9n",
		"firstMessageSent": false,
		"showColorPalette": false,
		"selectedContactIndex": 0,
  	"contacts": [{"name":"Adam Bush","profileImage":"https://randomuser.me/api/portraits/men/85.jpg","userId":"umYHX3R","newChannelInput":"","messageInput":"","makeNewChannel":false,"selectedChannelIndex":0,"channels":[{"name":"MAIN","color":"#09f","messages":[{"content":"Hi, how are you?","date":"2019-02-13","time":"12:34","authorId":"umYHX3R"},{"content":"Welcome to the chat app with channels!","date":"2019-02-13","time":"12:35","authorId":"umYHX3R"},{"content":"channels?","date":"2019-02-13","time":"12:38","authorId":"FExpl9n"},{"content":"yup! Sometimes when you chat with someone you'd like to talk about different topics simultaneously or save important notes or links somewhere - it's super easy with the channels","date":"2019-02-13","time":"12:39","authorId":"umYHX3R"},{"content":"sounds cool 😎","date":"2019-02-13","time":"12:40","authorId":"FExpl9n"},{"content":"it might be really useful","date":"2019-02-13","time":"12:40","authorId":"FExpl9n"},{"content":"let's try them out","date":"2019-02-13","time":"12:41","authorId":"FExpl9n"},{"content":"try to switch channels - click 'trip to Greece' ^","date":"2019-02-13","time":"12:45","authorId":"umYHX3R"}]},{"name":"trip to Greece","color":"#ff0f80","messages":[{"content":"Why would we spam our main chat, when we can plan our trip here? 🛳️","date":"2019-02-09","time":"23:34","authorId":"umYHX3R"},{"content":"yeah, the channels are excellent!","date":"2019-02-10","time":"06:15","authorId":"FExpl9n"},{"content":"I've found a lovely Airbnb on Crete","date":"2019-02-10","time":"06:15","authorId":"FExpl9n"},{"content":"link?","date":"2019-02-10","time":"06:23","authorId":"umYHX3R"}]},{"name":"homework","color":"rgb(36, 123, 160)","messages":[{"content":"what do we have to do for tommorow?","date":"2019-02-13","time":"17:34","authorId":"umYHX3R"},{"content":"maths - exercises 2.314, 2.316 abc, 2.317 d | physics - read about centripetal force","date":"2019-02-13","time":"17:55","authorId":"FExpl9n"},{"content":"thanks!","date":"2019-02-13","time":"18:23","authorId":"umYHX3R"}]},{"name":"dank memes","color":"rgb(241, 154, 62)","messages":[]}]},{"name":"Lucy Smith","userId":"jY0ty9S","newChannelInput":"","messageInput":"","makeNewChannel":false,"selectedChannelIndex":0,"profileImage":"https://randomuser.me/api/portraits/women/65.jpg","channels":[{"name":"MAIN","color":"#09f","messages":[{"content":"Heey ;)","date":"2019-02-06","time":"17:19","authorId":"jY0ty9S"}]},{"name":"random talks","color":"#09f","messages":[{"content":"I like dinosaurs","date":"2019-02-09","time":"23:34","authorId":"jY0ty9S"},{"content":"me too!","date":"2019-02-09","time":"23:35","authorId":"FExpl9n"}]},{"name":"channel3","color":"#09f","messages":[{"content":"what are we gonna use this channel for?","date":"2019-02-07","time":"14:34","authorId":"jY0ty9S"},{"content":"dunno","date":"2019-02-07","time":"14:35","authorId":"FExpl9n"},{"content":"hmm let's leave it empty","date":"2019-02-07","time":"18:56","authorId":"jY0ty9S"}]}]},{"name":"Natasha Brown","userId":"adf8iOc","newChannelInput":"","messageInput":"","makeNewChannel":false,"profileImage":"https://randomuser.me/api/portraits/women/43.jpg","selectedChannelIndex":0,"channels":[{"name":"MAIN","color":"#09f","messages":[{"content":"Lorem Ipsum dolor sit amet oh my god I have no idea what should I write here lol","date":"2018-09-12","time":"12:45","authorId":"adf8iOc"},{"content":"making fake messages might be really boring","date":"2018-09-13","time":"08:23","authorId":"FExpl9n"}]}]},{"name":"Charles Spruce","newChannelInput":"","makeNewChannel":false,"messageInput":"","profileImage":"https://avatars2.githubusercontent.com/u/1695865?s=460&v=4","userId":"thearchitect","selectedChannelIndex":0,"channels":[{"name":"MAIN","color":"#09f","messages":[{"content":"Hi! 👋 I'm the author of this chat app. If you like it, please hit the 💖 button ^ thanks!","date":"2020-03-12","time":"00:00","authorId":"thearchitect"}]}]},{"name":"babür aclan","profileImage":"https://randomuser.me/api/portraits/med/men/18.jpg","userId":null,"newChannelInput":"","messageInput":"","makeNewChannel":false,"selectedChannelIndex":0,"channels":[{"name":"MAIN","color":"#09f","messages":[]}]},{"name":"vicky brady","profileImage":"https://randomuser.me/api/portraits/med/women/91.jpg","userId":"6981389T","newChannelInput":"","messageInput":"","makeNewChannel":false,"selectedChannelIndex":0,"channels":[{"name":"MAIN","color":"#09f","messages":[]}]},{"name":"enver gottschlich","profileImage":"https://randomuser.me/api/portraits/med/men/22.jpg","userId":null,"newChannelInput":"","messageInput":"","makeNewChannel":false,"selectedChannelIndex":0,"channels":[{"name":"MAIN","color":"#09f","messages":[]}]},{"name":"abbie richardson","profileImage":"https://randomuser.me/api/portraits/med/women/58.jpg","userId":"ES 63 66 39 F","newChannelInput":"","messageInput":"","makeNewChannel":false,"selectedChannelIndex":0,"channels":[{"name":"MAIN","color":"#09f","messages":[]}]},{"name":"debra foster","profileImage":"https://randomuser.me/api/portraits/med/women/84.jpg","userId":"EW 54 98 10 P","newChannelInput":"","messageInput":"","makeNewChannel":false,"selectedChannelIndex":0,"channels":[{"name":"MAIN","color":"#09f","messages":[]}]},{"name":"rena beer","profileImage":"https://randomuser.me/api/portraits/med/women/12.jpg","userId":null,"newChannelInput":"","messageInput":"","makeNewChannel":false,"selectedChannelIndex":0,"channels":[{"name":"MAIN","color":"#09f","messages":[]}]},{"name":"nicklas netland","profileImage":"https://randomuser.me/api/portraits/med/men/4.jpg","userId":"02105748674","newChannelInput":"","messageInput":"","makeNewChannel":false,"selectedChannelIndex":0,"channels":[{"name":"MAIN","color":"#09f","messages":[]}]},{"name":"alma møller","profileImage":"https://randomuser.me/api/portraits/med/women/45.jpg","userId":"953147-1893","newChannelInput":"","messageInput":"","makeNewChannel":false,"selectedChannelIndex":0,"channels":[{"name":"MAIN","color":"#09f","messages":[]}]},{"name":"paige fox","profileImage":"https://randomuser.me/api/portraits/med/women/5.jpg","userId":"4371535T","newChannelInput":"","messageInput":"","makeNewChannel":false,"selectedChannelIndex":0,"channels":[{"name":"MAIN","color":"#09f","messages":[]}]}]
	}
})