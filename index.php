<!DOCTYPE html>
<html>
    

<head>
<title> FakeBook </title>
<link rel = "stylesheet" href="log-in.css">
<link rel="icon" href="favi.png">
</head>

<body>
    <h1 id = "bannerText">Connection made easier </h1>
    <div class = "logInForm">
        <form action="verifyUser.php" method = "POST">
            <label for="username">Username:</label><br>

            <input type="text" placeholder = "Enter Username" name="username" required><br>

            <label for="password">Password: :</label><br>
            <input type="password" placeholder = "Enter Password"  name="password" required>


        <br>

        <button type = "submit">Login</button>

        <label>
                <input type="checkbox" checked="checked" name="remember">
                Remember me  
        </label>

    

        <br></br>

        <label> <a href="signup.php">Sign-up here</a> </label>

        <br></br>

        </form>

        </form>
    </div>


</body>
</html>