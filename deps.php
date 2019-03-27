<?php
require 'db.php';
/*Если нажата кнопка на регистрацию,
/*начинаем проверку */
        $user = R::dispense ('deps');
        $user->name = 'Resurse umane';
        $user->leader_id = 1;
        $test= R::store( $user );
        if ($test) {}
?>
