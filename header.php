<?php
  session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
    
  </head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>    
<a class="navbar-brand" href="#"> Торговое предприятие </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Переключатель навигации">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" href="index.php">Авторизация</a>
        <?php

          

          if (isset($_SESSION['login'])) {

            echo "<a class='nav-link' href='account.php'> Личный кабинет</a>";
            echo "<a class='nav-link' href='contracts.php'> Контракты </a>";
          if ($_SESSION['mid'] == 1) {
            echo "<a class='nav-link' href='managers.php'> Менеджеры </a>";
            echo "<a class='nav-link' href='stat.php'> Статистика </a>";
            echo "<a class='nav-link' href='archive.php'> Архив контрактов </a>";
          }
          }
          
            
            
            
            
          
          
        ?>
      </div>  
    </div>
  </div>
  </nav>

