module.exports = {
  globDirectory: "./p/",
  globPatterns: ["**/*.{ico,html,js,css,scss,woff,woff2}"],
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
      urlPattern: /\.(?:json)$/,
      handler: "CacheFirst",
      options: {
        cacheName: "manifests",
      },
    },
    {
      urlPattern: /\.(?:png|jpg|jpeg|svg|gif)$/,
      handler: "CacheFirst",
      options: {
        cacheName: "images",
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
