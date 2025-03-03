<!DOCTYPE html>
<html>
    

<head>
<title> FakeBook </title>
<link rel = "stylesheet" href="log-in.css">


<link rel="icon" href="favi.png">
</head>


<body>
    <h1 id = "bannerText"> You're Verified! </h1>
    <div class = "signUpFormArea">

        <form action="signUp.php" id="signUpForm" method = "POST">
        <label for="email">Email: </label> <br>
            <input type = "email" placeholder = "Enter email" name="email"><br>
            <br>

            <label for="username">Username: </label> <br>
            <input type = "username" placeholder = "Enter username" name="username"><br>
            <br>

            <label for="password">password: </label> <br>
            <input type = "password" placeholder = "Enter password" name="password"><br>


            <button type = "submit" id = "verButt">Log-in</button> 
            <br>
            <label> <a href="index.php">Log-in here!</a> </label>

        <br></br>

        </form>

        <form action = "" id = ""
    </div>

    <?php


$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];


if(strlen($email) < 1 || strlen($email) > 100)
{
    if (strlen($email) < 1)
      echo "email length too short";
    else
      echo "email length too long";

     exit();
}
else if (strpos($email,'@') == false)
{
   echo "email syntax invalid";
   exit();
}
else if (strlen($password) < 8)
{
  echo "Password length too short";
   exit();
}
else if ($password !== $repeat)
{
  echo "your passwords don't match up";
  exit();
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$dbcreds = new mysqli('localhost', 'root', '', 'users');

if ($stmt = dbcreds -> prepare("INSERT INTO 'users' ('email','password') VALUES (?,?)"))
{
   $stmt -> bind_param("ss", $email, $hash);
   $stmt -> execute();

 if  ($stmt -> insert_id == 0)
  {
     echo "Database error";
     exit();
  }
   
  $stmt -> close();

 }
?>


</body>
</html>