<?php 
session_start();
require_once 'rb.php';
R::setup( 'mysql:host=localhost;dbname=users',
        'root', '123456' ); //for both mysql or mariaDB
?>