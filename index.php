<?php
require 'db.php';
?>
<html>
<title>Welcome</title>

<body>
    <?php
    if ($_SESSION["email"]) {
        // $autorized = '<li><a href="./user">User Settings</a></li>
        // 				<li><a href="./logout">Logout</a></li>';
        echo "Hello, " . $_SESSION["email"] . "!<br>";
        echo "If want to change your settings, go to <a href=\"./user\">User Settings page,</a>";
        echo "or you can <a href=\"./logout\">logout,</a> if you are done for today.";
        echo "<ul>";
    } else {
        echo "Welcome, Guest. We are happy to see you here!";
        echo "<ul>";
        echo '<li><a href="./login">Autorization</a></li>
        <li><a href="./signup">Registration</a></li>';
    }
    ?>
    <li><a href="./tasks2">Tasks</a></li>
    <li><a href="./stats">Stats</a></li>
    </ul>
</body>

</html>