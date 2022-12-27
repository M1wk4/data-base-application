<?php
    include_once 'scripts\bd_Incl.php';
    include_once 'header.php';
?>


<div class="container col-4 position-absolute top-50 start-50 translate-middle">
<h1 class="text-center">Авторизация</h1>
    <div class="algin-items-center">
        <form class="text-center" method='post'> 
            <input type="login" class="form-control" id="loginInput" placeholder="Login" name="login" required> <br>
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required> <br>
            <button type="submit" class="btn btn-success" id="log"name="log"> Авторизация </button>
        </form>   
    </div>
</div>
<script src="js\index_aut.js"> </script>
