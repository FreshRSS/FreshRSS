module.exports = {
  globDirectory: "./p/",
  globPatterns: [
    "**/*.{ico,html,js}",
    "themes/*.{png,jpg,jpeg,svg,gif,css}",
    "themes/base-theme/*.{png,jpg,jpeg,svg,gif,css}",
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
      urlPattern: /\.(?:woff|woff2)$/,
      handler: "CacheFirst",
      options: {
        cacheName: "fonts",
        expiration: {
          maxEntries: 10,
        },
      },
    },
    {
      urlPattern: /\.(?:css)$/,
      handler: "CacheFirst",
      options: {
        cacheName: "styles",
        expiration: {
          maxEntries: 10,
        },
      },
    },
    {
      urlPattern: /\.(?:js)$/,
      handler: "CacheFirst",
      options: {
        cacheName: "scripts",
        expiration: {
          maxEntries: 10,
        },
      },
    },
    {
      urlPattern: /\.(?:php|html).*$/,
      handler: "CacheFirst",
      options: {
        cacheName: "index",
        expiration: {
          maxEntries: 10,
        },
      },
    },
  ],
};
