var path = require('path');

module.exports = {
    context: __dirname,
    resolve: {
        extensions: ['.js', '.vue', '.json'],
            alias: {
            'vue$': 'vue/dist/vue.esm.js',
                '@': path.resolve(__dirname,'resources/js/src')
        },
    }
};