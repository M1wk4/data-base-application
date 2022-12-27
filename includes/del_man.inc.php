<?php
    include_once "C:/xampp/htdocs/app_db/scripts/bd_Incl.php";
    session_start();

    $mid_p = $_SESSION["mid"];
    $id = $_POST["id"];
    $sql = "DELETE from `managers` 
                where man_id = $id";
try {
    $mysqli->query($sql);
    echo 'Успешно!';
}
catch(exception $e)  {
    echo $e->getMessage();
} 
    $mysqli->close(); 
?>