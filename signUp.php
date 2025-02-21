<!DOCTYPE html>
<html>
    

<head>
<title> FakeBook </title>
<link rel = "stylesheet" href="log-in.css">
<script src="main.js"></script></HEAD>
<link rel="icon" href="favi.png">
</head>

<body>
    <h1 id = "bannerText"> Sign-Up </h1>
    <div class = "signUpForm">

        <form action="createAcc.php" method = "POST">
            <label for="email">Email: </label> <br>
            <input type = "email" placeholder = "Enter Email" name="email" required><br>

            <label for="username">Username: </label><br>

            <input type="text" placeholder = "Enter Username" name="username" required><br>
            

            <label for="password">Password: </label><br>

            <input type="password" placeholder = "Enter Password"  name="password" required><br>

            <label for="repPassword">Re-Type Password  </label><br>

            <input type="password" placeholder = "Enter Password"  name="repPassword" required><br>

        <br>

        <button type = "submit">Sign-up</button>

    

        <br></br>

        <label> <a href="signup.html">Sign-up here</a> </label>

        <br></br>

        </form>

        </form>
    </div>


</body>
</html>