<?php
require_once 'db.php';
/*Если нажата кнопка на регистрацию,
/*начинаем проверку */
if (isset($_POST['submit'])) {
    //Утюжим пришедшие данные corresponding table. The ID of a bean is the primary key of the corresponding record. 
    if (empty($_POST['email']))
        $err[] = '<div class="alert alert-danger" role="alert">Поле Email не может быть пустым!</div>';
    else {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false)
            $err[] = '<div class="alert alert-danger" role="alert">Неправильно введен E-mail.</div>' . "\n";
        $user = R::findOne( 'users', ' email = ? ',  array($_POST['email']));//спорный момент
        //echo $user['email']."lkasihdgf;kashdglkusdf";
        if ($user){
            if ($user['pass'] === md5(md5($_POST['pass']))) {
                $_SESSION["email"] = $user['email'];
                $_SESSION["id"] = $user['id'];
                $_SESSION["is_admin"] = $user['is_admin'];
                $_SESSION["is_head"] = $user['is_head'];
                $_SESSION["dept_id"] = $user['dept_id'];
                header("Location: ./");
                //echo $_SESSION["email"];
                //echo "Session variables are set.";
                //echo '<div style = "color:green;">'."Success!".'</div><hr>';
            } 
            else $err[] = '<div class="alert alert-danger" role="alert">Неверный пароль.</div>' . "\n";
        }
        else $err[] = '<div class="alert alert-danger" role="alert"
        >Пользователя с вверденным E-mail не существует.</div>' . "\n";
        }
    if (empty($_POST['pass']))
        $err[] = '<div class="alert alert-danger" role="alert">Поле Пароль не может быть пустым.</div>';
    if (strlen($_POST['pass'])<8)
        $err[] = '<div class="alert alert-danger" role="alert">Пароль содержит менее 8 символов.</div>';
    if  (!empty($err)) foreach($err as $er) echo '<div style="color:red;">'.$er.'</div>';
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Log in</title>
    <link rel="stylesheet" href="./libs/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
    <a href="/">Main Page</a><br>
    <? if($_SESSION["email"]) : ?>
    <?="    You are autorized as ".$_SESSION['email'].".<br>    Go to <a href=\"/user\">Settings</a>, if you want to change something.";?>
    <?php 
    
    ?>
    <? else : ?>
    <form id="loginForm" class="form-horizontal container" action="./login" method="POST">
        <div class="input-group col-sm-4">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
            <input id="email" type="text" class="form-control" name="email" placeholder="Email">
        </div>
        <div class="input-group col-sm-4">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="pass" type="password" class="form-control" name="pass" placeholder="Password">
        </div>
        <br>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-4">
                <button type="submit" name="submit" class="btn btn-success btn-block">LogIn</button>
            </div>
        </div>
    </form>
    <? endif; ?>
</body>

</html>