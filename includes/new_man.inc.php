<?php
    session_start();
    $mid_p = $_SESSION["mid"];

    $name = $_POST["name"];
    $dealer = $_POST["dealer"];
    $login = $_POST["login"];
    $password = $_POST["password"];
    $comment = $_POST["comment"];
    $procent = $_POST["procent"] / 100;

    
    try {
    $dbh = new PDO('mysql:dbname=app_db;host=localhost', 'root', '',
        array(PDO::ATTR_PERSISTENT => true));
    //echo "Подключились\n";
    } catch (Exception $e) {
    die("Не удалось подключиться: " . $e->getMessage());
    }

    try {
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       
        
        $sql = "SELECT MAX(MAN_ID)+1 ID FROM `users`";
        $result = $dbh->query($sql);
        $man_id = $result->fetch();
        
        $dbh->beginTransaction();
        $dbh->exec("INSERT into `managers` (man_id, d_id, name, percent, hire_day, comments, parent_id) 
            values ({$man_id['ID']},'{$dealer}','{$name}' ,{$procent}, sysdate(), '{$comment}',{$mid_p})");

        
        
        $dbh->exec("INSERT into `users` (man_id, login, password)
            values ({$man_id['ID']}, '{$login}', '{$password}')");
        $dbh->commit();
        echo "Успешно!";

      } catch (Exception $e) {
        $dbh->rollBack();
        echo $e->getMessage();
      }
?>
    
