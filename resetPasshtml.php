<!DOCTYPE html>
<html>
    

<head>
<title> Reset Password </title>
<link rel = "stylesheet" href="log-in.css">
<link rel="icon" href="admin\config\assets\favi.png">
</head>

<body>
<h1 id = "bannerText">Reset Password</h1>
    <div class = "formArea">
        <form id = "resetPassForm" action="resetPass.php" method = "POST">
            <input type="email" placeholder = "Enter email" name="email" required>
            <br>
            <br>

            <label for="password">Password: :</label>
            <br>
            <br>
            <input type="password" placeholder = "Enter Password"  name="password" required>


            <button type = "submit" >Reset password</button>
        </form>
    </div>


</body>
</html>

<?php
    session_start();
    $_SESSION["urlUid"] = $_GET["activation_code"];
    $_SESSION["email"] =  $_GET["email"];




?>