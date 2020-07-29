$('#disconnectedDesktop [type="submit"]').click(function(){
	alert('ALEEERTE GENERAAALE');
})

new Vue({
	el: '#connectionDesktop',

	data: {
	},

	methods: {
		connect: function(){
			alert('<?php echo "yop", ?>')
		}
	}

})