<?php


$apple_data = base64_encode($_GET['apple_data']);
$apple_signature = base64_encode($_GET['apple_signature']);
$apple_transactionId = $_GET['apple_transactionId'];
$apple_ephemeralPublicKey = base64_encode($_GET['apple_ephemeralPublicKey']);
$apple_publicKeyHash = base64_encode($_GET['apple_publicKeyHash']);
$apple_displayName = $_GET['apple_displayName'];
$apple_network = $_GET['apple_network'];
$apple_type = $_GET['apple_type'];
$amount = $_GET['amount'];
$merchant_reference = rand(0, getrandmax());
$SHA_Request_Phrase = '65TNlKz4amrEH9TVJkIzEJ_?';
$arrData = array(

    'access_code' => '3SVETdHDjxuJrhF099qX',
    'amount' => $amount,
    'apple_data'            => $apple_data,
    'apple_signature'       => $apple_signature,
    'apple_header'          => [
        'apple_transactionId' => $apple_transactionId,
        'apple_ephemeralPublicKey' => $apple_ephemeralPublicKey,
        'apple_publicKeyHash' => $apple_publicKeyHash,
    ],
    'apple_paymentMethod'   => [
        'apple_displayName' => $apple_displayName,
        'apple_network' => $apple_network,
        'apple_type' => $apple_type,
    ],
    'command' => 'PURCHASE',
    'currency' => 'SAR',
    'customer_email' => "a6e6s1@gmail.com",
    'customer_name' => "Ahmed Elmahdy",
    'digital_wallet' => 'APPLE_PAY',
    'language' => 'en',
    'merchant_identifier' => 'reBWkbQY',
    'merchant_reference' => $merchant_reference,
    'order_description' => 'Package payment',
    'phone_number' => '23232322',
    'return_url' => 'https://namaa.sa/payfort/success.php',
);
$shaString = '';
ksort($arrData);
foreach ($arrData as $key => $value) {
    if (is_array($value)) {
        $shaSubString = '{';
        foreach ($value as $k => $v) {
            $shaSubString .= "$k=$v, ";
        }
        $shaSubString = substr($shaSubString, 0, -2) . '}';
        $shaString .= "$key=$shaSubString";
    } else {
        $shaString .= "$key=$value";
    }
}
$shaString = $SHA_Request_Phrase . $shaString . $SHA_Request_Phrase;
$signature = hash('sha256', $shaString);
$arrData['signature'] = $signature;
$arrData = json_encode($arrData);
$url = "https://sbpaymentservices.payfort.com/FortAPI/paymentApi";
// create a new cURL resource
$ch = curl_init();
$headers = array("Content-Type: application/json");
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $arrData);
if (curl_exec($ch) === false) {
    echo '{"curlError":"' . curl_error($ch) . '"}';
}
// close cURL resource, and free up system resources
curl_close($ch);
