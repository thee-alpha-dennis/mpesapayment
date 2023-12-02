<?php
// INCLUDE THE ACCESS TOKEN FILE
include 'accesstoken.php';

date_default_timezone_set('Africa/Nairobi');

$processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

// Where the JSON response will be sent after the request (e.g., failed or canceled requests)
$callbackurl = 'https://www.buybyeq.com/buybyeqmobile/api/MPESA/callbackurl.php';

$passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$BusinessShortCode = '174379';

$Timestamp = date('YmdHis');

// Encrypt data to get the password
$Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);
$phone = '254712910072'; // Phone number to receive the STK push
$money = '1';
$PartyA = $phone;
$PartyB = '254708374149';
$AccountReference = 'KULABOX TEST ACC.';
$TransactionDesc = 'STK push test';
$Amount = $money;
$stkpushheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];

// INITIATE CURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $PartyA,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $PartyA,
    'CallBackURL' => $callbackurl,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc
]));

// Execute the cURL request and check for errors
// ... (previous code)

// Execute the cURL request and check for errors
$curl_response = curl_exec($curl);
if (curl_errno($curl)) {
    echo 'Curl error: ' . curl_error($curl);
} else {
    // Decode and process the response
    $data = json_decode($curl_response);
    
    // Debugging: Print the access token
    echo 'Access Token: ' . $access_token . PHP_EOL;

    $CheckoutRequestID = $data->CheckoutRequestID;
    $ResponseCode = $data->ResponseCode;

    // Check if the request was successful
    if ($ResponseCode == "0") {
        echo "The CheckoutRequestID for this transaction is: " . $CheckoutRequestID;
    } else {
        echo "Error: " . $data->errorMessage;
    }
}


// Close the cURL session
curl_close($curl);
?>
