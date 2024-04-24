<?php 

$serverKey = "AAAA2HwJS5w:APA91bEL6Sj2V7eAOfIKHDWiolwMSGJdgUPP4SWuAvqNVX63MCj8UCFPuQPROt51di-ODzprMb01DSoY4FV6WotRHHWML-uZSaEN259_-PXJjuuKjy3Fgn_PYPoq4meKBCIgu9k-xWbK";
$deviceToken = "f1mg7jRNnVt7cp4FVctHR4:APA91bF4ow5bXevVFGsUrQ4ODhkQ8tuP8tyG0Mf7_bJZt3E6ZKIATnA4q8pQ0IrnsI8ELSRQazmIRAiW4fYKhLTdkm3CyZiGBj3mGvk50CfvNc6t9m4Pm7Nbf-_aEPrtZzjNLe4yyoVw";

$url = 'https://fcm.googleapis.com/fcm/send';

$headers = array(
    'Authorization: key=' . $serverKey,
    'Content-Type: application/json'
);

$data = array(
    'data' => array(
        'notification' => array(
            'title' => 'FCM Message',
            'body' => 'This is an FCM Message'
        )
    ),
    'to' => $deviceToken
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if ($response === false) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    echo 'FCM response: ' . $response;
}

curl_close($ch);
?>
