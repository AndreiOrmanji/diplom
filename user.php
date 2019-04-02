<?php
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Log in Diplom</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
    body,
    html {
        margin: 0px;
        padding: 0px;
    }

    #loginForm {
        margin-top: 5%;
        margin-bottom: 25%;
        height: 30%;
    }
    </style>
</head>

<body>
    <a href="./">Main Page</a><br>
    <? if($_SESSION["email"]) : ?>
    <?="You are using, ". $_SESSION["email"] . " as your e-mail adress."; ?>
    <form id="UserForm" class="form-horizontal container" action="./services/modifyUser" method="POST">
        <div class="form-group">
            <label for="email" class="col-sm-4 control-label">Введите новый E-mail:</label>
            <div class="col-sm-10">
                <input class="form-control" type="email" id="email" name="email" placeholder="E-mail:">
            </div>
        </div>
        <div class="form-group">
            <label for="pass" class="col-sm-4 control-label">Введите ТЕКУЩИЙ пароль:</label>
            <div class="col-sm-10">
                <input class="form-control" type="password" id="pass" name="pass" placeholder="Пароль">
            </div>
        </div>
        <div class="form-group">
            <label for="pass" class="col-sm-4 control-label">Введите НОВЫЙ пароль:</label>
            <div class="col-sm-10">
                <input class="form-control" type="password" id="pass2" name="pass2" placeholder="Новый пароль">
            </div>
        </div>
        </div>
        <div class="form-group">
            <label for="pass" class="col-sm-4 control-label">Повторите ввод НОВОГО пароль:</label>
            <div class="col-sm-10">
                <input class="form-control" type="password" id="pass3" name="pass3" placeholder="Новый пароль">
            </div>
        </div>
        <div class="container">
            <div class="col-sm-10">
                <button type="submit" name="submit" class="btn btn-lg btn-success btn-block">Save</button>
                <button type="logout" name="logout" class="btn btn-lg btn-primary btn-block">LogOut</button>
            </div>
        </div>
    </form>
    <? else : ?>
    <?="You are not autorized. Go to <a href=\"./login\">Login Page.</a> ";?>
    <div>You'll be redirected to the main page after
        <span id="timer"></span> seconds. If it didn't happend, press <a href="./login">Login Page</a> link.</div>
    <script type="text/javascript">
    <!--
    var t = 2; /* Даём 2 секунды */
    function refr_time() {
        if (t > 0) {
            t--;
            document.getElementById('timer').innerHTML = t;
        } else {
            clearInterval(tm);
            location.href = '/';
        }
    }
    var tm = setInterval('refr_time();', 1000);
    -->
    </script>
    <? endif; ?>
</body>

</html>