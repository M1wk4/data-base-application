<?php
    include_once "C:/xampp/htdocs/app_db/scripts/bd_Incl.php";
    session_start();
    $mid = $_SESSION["mid"];

    $contr = $_POST["contr"];
    $start = $_POST["start"];
    $end = $_POST["end"];

    $sql = "INSERT into `contracts`(contr_id, man_id, dayfrom, dayto) values('$contr', '$mid' ,'$start','$end')";
try {
    $mysqli->query($sql);
    echo 'Успешно!';
}
catch(exception $e)  {
    echo $e->getMessage();
} 
    $mysqli->close(); 
?>