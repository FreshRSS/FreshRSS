// This is the service worker with the Advanced caching

// Add this below content to your HTML page inside a <script type="module"></script> tag, or add the js file to your page at the very top to register service worker
// If you get an error about not being able to import, double check that you have type="module" on your <script /> tag

/*
 This code uses the pwa-update web component https://github.com/pwa-builder/pwa-update to register your service worker,
 tell the user when there is an update available and let the user know when your PWA is ready to use offline.
*/

import './vendor/pwaupdate.min.js';

const el = document.createElement('pwa-update');
el.swpath = '../sw.js';
document.body.appendChild(el);