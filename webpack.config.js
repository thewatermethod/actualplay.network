// path is a built in node.js helper that helps us with the file system
const path = require("path");

// this is what we need to get those vue components working
const VueLoaderPlugin = require('vue-loader/lib/plugin')

// webpack accepts a module as a configuration object
// See: https://webpack.js.org/configuration/ for more information about the parameters

module.exports = {

    // you can switch this up by uncommenting, commenting these lines
    //mode: "production", 
    mode: "development",

    //the main file of our app
    entry: "./admin/statistics/app.js",

    // the output directory
    output: {
        // path: path.resolve( __dirname, "/dist"),
        filename: "bundle.js",
    },

    resolve: {
        alias: {
          vue: 'vue/dist/vue.js'
        }
    },

    module: {
        rules: [
            { /*  Loads CSS files (ignoring relative url) */
                test: /\.css$/,
                use: [
                { loader: 'style-loader' },
                {
                    loader: 'css-loader',
                    options: {
                        modules: true,
                        url: false,
                    }
                }                
                ]
            },
            { /* this handles the fonts in css files */
                test   : /\.(ttf|eot|svg|woff(2)?)(\?[a-z0-9=&.]+)?$/,
                loader : 'file-loader',
            },
            { /* this is for the vue files */
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                  loaders: {                  
                    'scss': [
                      'vue-style-loader',
                      'css-loader',
                      'sass-loader'
                    ],
                    'sass': [
                      'vue-style-loader',
                      'css-loader',
                      'sass-loader?indentedSyntax'
                    ]                   
                  },
                }
              },
              { /* this handles the images */
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'file-loader',
                options: {
                  name: '[name].[ext]?[hash]'
                }
            }
        ]           
    },
    plugins: [
        new VueLoaderPlugin()
    ]
}