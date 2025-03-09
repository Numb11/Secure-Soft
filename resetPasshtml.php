<!DOCTYPE html>
<html>
    

<head>
<title> Reset Password </title>
<link rel = "stylesheet" href="log-in.css">
<link rel="icon" href="admin\config\assets\favi.png">
</head>

<body>
<h1 id = "bannerText">FakeBook</h1>
    <div class = "formArea">
        <form id = "resetPassForm" action="resetPass.php" method = "POST">
            <input type="email" placeholder = "Enter email" name="email" required><br>

            <label for="password">Password: :</label><br>
            <input type="password" placeholder = "Enter Password"  name="password" required>


            <button type = "submit" >Reset password</button>
        </form>
    </div>


</body>
</html>