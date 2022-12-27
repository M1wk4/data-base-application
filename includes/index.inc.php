<?php
include_once "C:/xampp/htdocs/app_db/scripts/bd_Incl.php";
session_start();
if (isset($_POST["login"]) && isset($_POST["password"])){
    $login = $_POST["login"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM `users` WHERE LOGIN = '$login' AND PASSWORD = '$password'";
    $search = $mysqli->query($sql);
    $user = $search->fetch_assoc();
    if (isset($user['LOGIN']) && isset($user['PASSWORD']))
    {
      if ($user['LOGIN'] != NULL && $user['PASSWORD'] != NULL){
        $_SESSION['login'] =  $login;
        $_SESSION['mid'] = $user['MAN_ID'];
        
        //header("Location: account.php");
        exit();
      }
      else echo "1";
    }
    else echo "1";
  } 
?>