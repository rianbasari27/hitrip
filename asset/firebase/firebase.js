importScripts("https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js");

    var firebaseConfig = {
      apiKey: "AIzaSyDiV2nwzDe9zfnvh049wVt-tePXIgMQPS8",
      authDomain: "ventour-mobile.firebaseapp.com",
      projectId: "ventour-mobile",
      storageBucket: "ventour-mobile.appspot.com",
      messagingSenderId: "929793919900",
      appId: "1:929793919900:web:a10e300bbd7a66cc011659"
    };

    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();
      messaging
        .requestPermission()
        .then(function () {
          console.log("Notification permission granted.");

          // get the token in the form of promise
          return messaging.getToken()
        })
        .then(function(token) {
          // print the token on the HTML page
          TokenElem.innerHTML = "Device token is : <br>" + token
          console.log("Device token is : " + token)
        })
        .catch(function (err) {
        ErrElem.innerHTML = ErrElem.innerHTML + "; " + err
        console.log("Unable to get permission to notify.", err);
      });
