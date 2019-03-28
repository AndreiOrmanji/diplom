<?php
	require 'db.php';
?>
<html>
<title>Welcome</title>

<body>
    <a href="./login">Autorization</a>
    <a href="./signup">Registration</a>
    <br>
    <?php
		if ($_SESSION["email"]){
			$autorized='<li><a href="./user">User Settings</a></li>
						<li><a href="./logout">Logout</a></li>';
			echo "Hello, ". $_SESSION["email"] . "!<br>";
			echo "If want to change your settings, go to <a href=\"./user\">User Settings page,</a>";
			echo "or you can <a href=\"./logout\">logout,</a> if you are done for today.";
		}
		else {
				echo "Welcome, Guest. We are happy to see you here!";
		}
	?>
    <ul>
        <li><a href="./login">Autorization</a></li>
        <li><a href="./signup">Registration</a></li>
        <li><a href="./tasks">Tasks</a></li>
        <?php  
        	echo "$autorized";
        ?>
    </ul>
    <script>
    for (var i = 0; i < document.body.childNodes.length; i++) {
        //alert(document.body.childNodes[i]); // Text, DIV, Text, UL, ..., SCRIPT
        document.write(document.body.childNodes[i]);
        //document.write("</br>");
    }
    </script>
</body>

</html>