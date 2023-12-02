<?php
// YOU MPESA API KEYS
$consumerKey = "LG47D4AouNz2rR9Iz5KAlxVPJ1jvAuhU";
$consumerSecret = "HgxqHVPC3d4aGSWA";

// ACCESS TOKEN URL
$access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

// INITIATE A CURL REQUEST
$headers = ['Content-Type:application/json; charset=utf8'];
$curl = curl_init($access_token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HEADER, FALSE);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

// RESPONSE
$result = json_decode($result);

// Echo the access token
//echo $result->access_token;
$access_token = $result->access_token;

// Close the cURL session
curl_close($curl);
?>
