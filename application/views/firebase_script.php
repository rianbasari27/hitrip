<script>
var firebaseConfig = {
    apiKey: "AIzaSyB-6_F42LEc7yhYxrtwIbVM3YSGMpCO8cU",
    authDomain: "my-app-bd747.firebaseapp.com",
    projectId: "my-app-bd747",
    storageBucket: "my-app-bd747.appspot.com",
    messagingSenderId: "1049171222616",
    appId: "1:1049171222616:web:c39c8d86bb9dba8a04ea2d",
    measurementId: "G-LTP6XBLHHH"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
messaging
    .requestPermission()
    .then(function() {
        console.log("Notification permission granted.");
        // get the token in the form of promise
        return messaging.getToken()
    })
    .then(function(token) {
        $.getJSON("<?php echo base_url() . 'call_notification/getToken';?>", {
                token: token,
                id_member: "<?php echo $_SESSION['id_member'];?>"
            }).done(function(json) {
                console.log('Berhasil tambah token');
            })
            .fail(function(jqxhr, textStatus, error) {
                console.log('Token Sudah ada');
            });
        console.log("Device token is : " + token)
    })
    .catch(function(err) {
        // ErrElem.innerHTML = ErrElem.innerHTML + "; " + err
        console.log("Unable to get permission to notify.", err);
    });
</script>