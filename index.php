<!DOCTYPE html>
<html>
    



<head>
<title> Connection made easier </title>
<link rel = "stylesheet" href="log-in.css">
</head>

<body>
    <h1 id = "bannerText">The Bugle</h1>
    <div class = "logInForm">
        <form action="log-in.php" method = "post">
            <label for="username">Username:</label><br>
            <input type="email" placeholder = "Enter Email" name="username"><br>

            <label for="password">Password: :</label><br>
            <input type="password" placeholder = "Enter Password"  name="password">
        </form>

        <br>

        <button type = "submit">Login</button>

        <label>
                <input type="checkbox" checked="checked" name="remember">
                Remember me  
        </label>

    

        <br></br>

        <label> <a href="signup.html">Sign-up here</a> </label>
    </div>

    <?php
        
    ?>

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

            <input type="email" placeholder = "Enter Email" name="username"><br>

            <label for="password">Password: :</label><br>
            <input type="password" placeholder = "Enter Password"  name="password">
        </form>

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

        <label> <a href="signup.html">Sign-up here</a> </label>

        <br></br>

        </form>

        </form>
    </div>


</body>
</html>