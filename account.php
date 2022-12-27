<?php
	include_once "scripts\bd_incl.php";
  include_once 'header.php';
?>


<div class="card mb-3 position-absolute top-50 start-50 translate-middle   " style="max-width: 940px;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="img\no_name.jpg" class="img-fluid rounded-start" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body">

        <h5 class="card-title text-center">Личный кабинет</h5>
        <?php
          $login = $_SESSION['login'];
          echo
            "<p class='card-text'> Логин: ".$login."</p>";
        ?>
        <?php
          $login = $_SESSION['login'];
            if (isset($login)){
              $sql = "SELECT name FROM `man_with_login` WHERE login = '$login'";
              $res = $mysqli->query($sql);
              $data = $res->fetch_assoc();
            }
          echo
            "<p class='card-text'> Имя : ".$data["name"]."</p>";
        ?>
        <?php
          $login = $_SESSION['login'];
            if (isset($login)){
              $sql = "SELECT hire_day FROM `man_with_login` WHERE login = '$login'";
              $res = $mysqli->query($sql);
              $data = $res->fetch_assoc();
            }
          echo
            "<p class='card-text'> Дата приема на работу: ".$data["hire_day"]."</p>";
        ?>
        
        <?php
          $login = $_SESSION['login'];
          $job_post = " ";
            if (isset($login)){
              $sql = "SELECT parent_id FROM `man_with_login` WHERE login = '$login'";
              $res = $mysqli->query($sql);
              $data = $res->fetch_assoc();
            }
            if ($data["parent_id"] == null) {
              $job_post = "Главный менеджер";
            }
            else $job_post = "Менеджер";
          echo
            "<p class='card-text'> Должность : ".$job_post."</p>";
        ?>
        <?php
          $login = $_SESSION['login'];
          $mid = $_SESSION['mid'];
            if (isset($login)){
             
              $mysqli->query("SET @p0='".$mid."'");
              $res = $mysqli->query("SELECT `close_contr`(@p0) AS `close_contr`");
              $data = $res->fetch_assoc();
            }
          echo
            "<p class='card-text'> Количество закрытых контрактов: : ".$data['close_contr']."</p>";
        ?>
        <?php
          $login = $_SESSION['login'];
          $mid = $_SESSION['mid'];
            if (isset($login)){
             
              $mysqli->query("SET @p0='".$mid."'");
              $res = $mysqli->query("SELECT `open_contr`(@p0) AS `open_contr`");
              $data = $res->fetch_assoc();
            }
          echo
            "<p class='card-text'> Количество открытых контрактов: : ".$data['open_contr']."</p>";
        ?>
        <form method="post">
          <button type="submit" class="btn btn-warning" name="exit">Выход</button>
        </form>
      </div>
    </div>
  </div>
</div>


<?php
  if (isset($_POST["exit"])) {
    session_destroy();
    header("Location: index.php");
  }
?>