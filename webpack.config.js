module.exports = {
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader"
        }
      },
      {
        /*  Loads CSS files (ignoring relative url) */
        test: /\.css$/,
        use: [
          { loader: "style-loader" },
          {
            loader: "css-loader",
            options: {
              modules: true,
              url: false,
              localIdentName: "[name]__[local]___[hash:base64:5]"
            }
          }
        ]
      }
    ]
  }
};
