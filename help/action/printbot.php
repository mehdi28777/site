<?php
$ipFile = '../!#/bot.txt';
$ipList = file($ipFile, FILE_IGNORE_NEW_LINES);
$ipList = array_reverse($ipList);
$i = 0;
?>

  <?php foreach ($ipList as $ipItem) {
    $i += 1;
    if ($i <= 5) {
        
    
    $ipData = explode(" - ", $ipItem);
    $ip = $ipData[0];
    $date = $ipData[1];
    $reason = $ipData[2];
  ?>
   <tr class="text-gray-700 dark:text-gray-400">
        <td class="px-4 py-3 text-sm"> <?php echo $ip; ?> </td>
        <td class="px-4 py-3 text-sm"> <?php echo $reason; ?> </td>
        <td class="px-4 py-3 text-xs">
            <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100"> Blocked </span>
        </td>
        <td class="px-4 py-3 text-sm"> <?php echo $date; ?> </td>
    </tr>
  <?php 
  }else{
    break;
  }} ?>
