<?php
require_once 'db.php';
/*Если нажата кнопка на регистрацию,
/*начинаем проверку */
$users = R::getAll('SELECT email, id FROM users');
$depts = R::getAll('SELECT dept_name, id FROM depts');
if (isset($_POST['submit'])) {
    // проверка email
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false)
        $err[] = '<div class="alert alert-danger" role="alert">Неправильно введен E-mail.</div>' . "\n";
    if (!empty((R::findOne('users', ' email = ? ', [$_POST['email']]))))
        $err[] = '<div class="alert alert-danger" role="alert">Введенный e-mail используется другим пользователем.</div>';
    if (strlen($_POST['pass']) < 8)
        $err[] = '<div class="alert alert-danger" role="alert">Пароль менее 8 символов.</div>';
    if ($_POST['pass2'] !== $_POST['pass'])
        $err[] = '<div class="alert alert-danger" role="alert">Пароли не совпадают.</div>';
    if (empty($err)) {
        try {   
            $user = R::dispense('users');
            if (!empty($_POST['is_admin'])) $user->dept = $_POST['dept'];
            $user->is_admin = $_POST['is_admin'];
            $user->email = $_POST['email'];
            $user->pass = md5(md5($_POST['pass']));
            R::store($user);
            echo '<div style = "color:green;">' . "Registered!" . '</div><hr>';
        } catch (Exception $e) {
            echo "$e";
        }
    } else {
        foreach ($err as $er) echo '<div style="color:red;">' . $er . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Signup</title>
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
    <form id="loginForm" class="form-horizontal container" action="./signup" method="POST">
        <div class="form-group">
        <?php
        if (empty($users)){
            echo '<p>You will be registered as administrator</p>
            <span name="is_admin" style="display: none">1</span>';
        }
        else{
            if (empty($depts)) {
                echo '<p>No departments exists. Contact your administrator to add information about existing departments.</p>';
            } else {
                echo '<label for="dept">Department:</label>';
                echo '<select name="dept">
                <label for="dept">Your department:</label>';
                foreach ($depts as $dept) {
                    echo '<option>#' . $dept['id'] . ' |' . $dept['dept_name'] . '</option>';
                }
                echo '</select>';
            }
        }
        ?>
        </div>

        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">E-mail:</label>
            <div class="col-sm-10">
                <input class="form-control" type="email" id="email" name="email" placeholder="E-mail:" required>
            </div>
        </div>



        <div class="form-group">
            <label for="pass" class="col-sm-2 control-label">Пароль:</label>
            <div class="col-sm-10">
                <input class="form-control" type="password" id="pass" name="pass" placeholder="Пароль" required>
            </div>
        </div>
        <div class="form-group">
            <label for="pass2" class="col-sm-4 control-label">Повторно введите пароль:</label>
            <div class="col-sm-10">
                <input class="form-control" type="password" id="pass2" name="pass2" placeholder="Пароль" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block">Зарегистроваться</button>
            </div>
        </div>
    </form>
</body>

</html>