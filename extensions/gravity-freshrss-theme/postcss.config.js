module.exports = {
  map: {
    annotation: true,
    inline: false
  },
  plugins: [
    require('postcss-pxtorem')({
      rootValue: 16,
      propList: ['*'],
      mediaQuery: true,
      selectorBlackList: [/^html$/, /^body$/]
    }),
    require('autoprefixer')()
  ]
}
