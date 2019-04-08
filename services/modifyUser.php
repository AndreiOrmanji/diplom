<?php
require_once '../db.php';
/*Если нажата кнопка на регистрацию,
/*начинаем проверку */
$user = R::load('users', $_SESSION["id"]);
if (isset($_POST['logout'])) header("Location: ./logout");
if (isset($_POST['submit']))
    //Утюжим пришедшие данные corresponding table. The ID of a bean is the primary key of the corresponding record. 
    if (!empty($_POST['email'])){
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false)
            $err[] = '<div class="alert alert-danger" role="alert">Неправильно введен новый E-mail.</div>' . "\n";
        else {
            $user['email']=$_POST['email'];
            $_SESSION["email"]=$_POST['email'];
            R::store( $user );
            echo '<div style = "color:green;">'."E-mail was changed successfully!".'</div><hr>';    
        }
    }
        //смена пароля
    if (!empty($_POST['pass2']))
        if (strlen($_POST['pass2'])<8)
                $err[] = '<div class="alert alert-danger" role="alert">Пароль содержит менее 8 символов.</div>';
                else {
                    if (empty($_POST['pass'])) $err[] = '<div class="alert alert-danger" role="alert">
                    Введите текущий пароль для изменения пароля.</div>';
                    elseif ($user['pass'] === md5(md5($_POST['pass']))) {
                        if($_POST['pass2']===$_POST['pass3']) {
                            $user['pass']=md5(md5($_POST['pass2']));
                            R::store( $user );
                            echo '<div style = "color:green;">'."Password was changed successfully!".'</div><hr>';    
                        } 
                        else $err[] = '<div style = "color:red;">'."Passwords don't match!".'</div><hr>';    
                    // $_SESSION["email"] = $user['email'];
                    // echo $_SESSION["email"];
                    // echo "Session variables are set.";
                    } else $err[] = '<div class="alert alert-danger" role="alert">Неверный пароль.</div>' . "\n";
                }    
                    
    if  (!empty($err)) 
        foreach($err as $er) echo '<div style="color:red;">'.$er.'</div>';

?>