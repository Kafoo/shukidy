let path = require('path')

module.exports = {

	entry: {
		index: './app/js/index.js',
	},
	watch: true,
	output: {
		path: path.resolve('./app/js'),
		filename: 'dist.js'
	},

    resolve: {
        alias: {
            vue: 'vue/dist/vue.js'
        }
    }
}