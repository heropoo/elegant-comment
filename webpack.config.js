const path = require('path');

module.exports = {
    mode: 'development',
    entry: './static/src/index.js',
    output: {
        path: path.resolve(__dirname, 'public/dist'),
        filename: 'pretty-comment.js'
    },
    module: {
        rules: [
            {
                test: /\.css$/, use: [
                    {loader: "style-loader"},
                    {loader: "css-loader"}
                ]
            },
            {test: /\.txt$/, use: 'raw-loader'}
        ]
    }
};