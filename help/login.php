<?php
include '!#/base.php';

if (isset($_POST['password'])) {
    if (password_verify($_POST['password'], $password)) {
        $_SESSION['loged_in'] = true;
        header('location: index.php');
    }else if($password == '' && $_POST['password'] == '') {
        $_SESSION['loged_in'] = true;
        header('location: index.php');
    }else{
        $_SESSION['loged_in'] = false;
    }
}
?>
<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fluent Portal - Connexion</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="./assets/js/init-alpine.js"></script>
  </head>
  <body>
    <form id="formp" method="post">
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
      <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
        <div class="flex flex-col overflow-y-auto md:flex-row">
          <div class="flex items-center justify-center p-12 sm:p-12" style="width: 100%;">
            <div class="w-full">
              <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200"> Connexion </h1>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Mot de passe</span>
                <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="password" placeholder="***************" type="password" />
              </label>
              <a onclick="document.getElementById('formp').submit()" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" href="#"> Log in </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    </form>
  </body>
</html>