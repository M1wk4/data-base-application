<?php
    include_once "C:/xampp/htdocs/app_db/scripts/bd_Incl.php";
    session_start();
    $mid_p = $_SESSION["mid"];

    $contr = $_POST["contr"];
    $end = $_POST["end"];
    $man_id = $_POST["man_id"];

    $sql = "INSERT into `contracts`(contr_id, man_id, dayfrom, dayto) values('$contr', '$man_id' ,sysdate(),'$end')";
    
try {
    $mysqli->query($sql);
}
catch(exception $e)  {
    echo $e->getMessage();
} 

    
    include_once "C:/xampp/htdocs/app_db/scripts/bd_Incl.php";
    $sql1 = "DELETE from `delete_cont` where 
    contr_id = $contr and dayto = '$end'";
    $mysqli->query($sql1);
    $mysqli->close();
?>
    
