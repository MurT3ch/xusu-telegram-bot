<?php
if (empty($_GET['token'])) die();
$message = json_decode(file_get_contents("php://input"),true)['message'];
if ($message['chat']['type'] != 'private') die();

curlRequest("https://api.telegram.org/bot{$_GET['token']}/sendMessage", [
    'chat_id' => $message['from']['id'],
    'text' => json_decode(curlRequest("https://xu.su/api/send", json_encode([
        'uid' => null,
        'bot' => 'kristina',
        'text' => $message['text'] ?? ""
    ])),true)['text']
]);

function curlRequest($url, $data){
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}