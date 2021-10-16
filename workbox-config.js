module.exports = {
  globDirectory: "./p/",
  globPatterns: [
    "**/*.{ico,png,jpg,jpeg,svg,gif,html,js,css,scss,woff,woff2}",
    "themes/manifest.json",
  ],
  globStrict: true,
  ignoreURLParametersMatching: [/^utm_/, /^fbclid$/],
  swDest: "./p/sw.js",
  templatedURLs: {
    "./": ["index.html"],
    "./i/": ["i/index.php"],
    "./api/": ["api/index.php"],
  },
  runtimeCaching: [
    {
      urlPattern: /\.(?:png|jpg|jpeg|svg|gif)$/,
      handler: "CacheFirst",
      options: {
        cacheName: "images",
        expiration: {
          maxEntries: 10,
        },
      },
    },
    {
      urlPattern: /\.(?:php).*$/,
      handler: "CacheFirst",
      options: {
        cacheName: "php",
        expiration: {
          maxEntries: 10,
        },
      },
    },
  ],
};
