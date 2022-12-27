<?php
include_once 'scripts\bd_Incl.php';

if(isset($_POST["update"])){
    $man = $_POST["update"];
    $percent = $_POST["new_proc"] / 100;
    $sql = "UPDATE `managers` SET percent='$percent' where name='$man'";
    $mysqli->query($sql);
    header("Location: managers.php");
}
?>