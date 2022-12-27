<?php
    include_once "C:/xampp/htdocs/app_db/scripts/bd_Incl.php";
    session_start();
    
    $mid = $_SESSION["mid"];
    $man_id = $_POST["man_id"];
    $dealer = $_POST["dealer"];
    $name = $_POST["name"];
    $comments = $_POST["comments"];
    $procent = $_POST["procent"] / 100;
    $sql = "UPDATE `managers` 
                set name = '{$name}', 
                    percent = {$procent},
                    d_id = {$dealer},
                    comments = '{$comments}'
                where parent_id = {$mid} and man_id = {$man_id} ";
    $mysqli->query($sql);
    $mysqli->close(); 
    
?>