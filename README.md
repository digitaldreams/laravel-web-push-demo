# Progressive Web APP with Web Push Notifications
### Useful Resources and its links
Read this two awesome tutorial from Google about 
[PWA](https://developers.google.com/web/progressive-web-apps) and [Web Push](https://developers.google.com/web/fundamentals/push-notifications/)

Learn more about [service worker](https://developers.google.com/web/fundamentals/primers/service-workers) 
and  [Web Manifest](https://developers.google.com/web/fundamentals/web-app-manifest/) from google

[Online Web Manifest Generator](https://app-manifest.firebaseapp.com/ )

We are using [laravel-notification-channels/webpush](https://github.com/laravel-notification-channels/webpush) package behind the scene. A big thumbs up for their awesome work.

For simplicity we will split the whole process into few parts.

01. Laravel 6.2 with Default laravel auth and Notifications. [4bb9ad1](https://github.com/digitaldreams/laravel-web-push-demo/commit/4bb9ad17bdf4288b00a5529173e7c53131b4a480)
02. Web manifest and Service worker registration [16fc00d](https://github.com/digitaldreams/laravel-web-push-demo/commit/1017417cba01e110aa2756c57903a14e17adf395)
03. Subscribe To Push notification Button [bf7f539](https://github.com/digitaldreams/laravel-web-push-demo/commit/bf7f539f8f05e64fa14f7ac58893ba940e9933f7)
04. Save Endpoint and auth keys to Database [3a544db](https://github.com/digitaldreams/laravel-web-push-demo/commit/3a544dbb853d0c7e9ae0c0c50a93a8ccf1db9ba9)
05. Add Laravel Notification Channels to Existing Notification Class [49d49a5](https://github.com/digitaldreams/laravel-web-push-demo/commit/49d49a5718fc44817d8d3af863b45ffe761a726c)
06. Show Server Sent Notification via Service Worker push event [a93d1a7](https://github.com/digitaldreams/laravel-web-push-demo/commit/a93d1a7d6aa9acf8b22ca7c9bc865ffaaf2cfb76)
07. Notification Click Event [d49f92f](https://github.com/digitaldreams/laravel-web-push-demo/commit/d49f92f651731f9088e0cff552f961ab5c9c0f09)

![SlidesForWebPush](https://user-images.githubusercontent.com/6059541/72578442-480fce00-3900-11ea-9957-7906c5fea114.gif)
