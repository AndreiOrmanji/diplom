<?php 
session_start();
require 'rb.php';
R::setup( 'mysql:host=localhost;dbname=users',
        'root', '123456' ); //for both mysql or mariaDB
?>