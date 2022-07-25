// //BADGE INFO
// if( "setAppBadge" in navigator && "clearAppBadge" in navigator){
//     alert('use the native badge API')
// }
//
// navigator.setAppBadge(badgeCount).catch((error) => {
//     alert('Do something with the error')
// });
//
// navigator.clearAppBadge().catch((error) => {
//     alert('Do something with the error.')
// });
// //BADGE INFO END


self.addEventListener("install", function (event) {
    event.waitUntil(preLoad());
});

var filesToCache = [
    '/',
    '/dashboard',
    '/offline.html'
];

var preLoad = function () {
    return caches.open("offline").then(function (cache) {
        // caching index and important routes
        return cache.addAll(filesToCache);
    });
};

self.addEventListener("fetch", function (event) {
    event.respondWith(checkResponse(event.request).catch(function () {
        return returnFromCache(event.request);
    }));
    event.waitUntil(addToCache(event.request));
});

var checkResponse = function (request) {
    return new Promise(function (fulfill, reject) {
        fetch(request).then(function (response) {
            if (response.status !== 404) {
                fulfill(response);
            } else {
                reject();
            }
        }, reject);
    });
};

var addToCache = function (request) {
    return caches.open("offline").then(function (cache) {
        return fetch(request).then(function (response) {
            return cache.put(request, response);
        });
    });
};

var returnFromCache = function (request) {
    return caches.open("offline").then(function (cache) {
        return cache.match(request).then(function (matching) {
            if (!matching || matching.status == 404) {
                return cache.match("offline.html");
            } else {
                return matching;
            }
        });
    });
};
//
// Notification.requestPermission(status => {
//     console.log('Notification Permission Status:'+ status);
// });
//
// const options = {
//     body: 'here is a notification body',
//     icon:'favicon.png',
//     vibrate: [100,50,100],
//     data: {
//         primaryKey: 1
//     }
// }

// {
//     "body": "Did you make a $1,000,000 purchase at Dr. Evil...",
//     "icon": "images/ccard.png",
//     "vibrate": [200, 100, 200, 100, 200, 100, 400],
//     "tag": "request",
//     "actions": [
//     { "action": "yes", "title": "Yes", "icon": "images/yes.png" },
//     { "action": "no", "title": "No", "icon": "images/no.png" }
// ]
// }
//

// function displayNotification() {
//     if (Notification.permission === 'granted'){
//         navigator.serviceWorker.getRegistration().then(reg => {
//             reg.showNotification('Hello World',options);
//         });
//     }
// }
//
// displayNotification();
