<?php
<<<<<<< HEAD


    // Prevent Brute Force through attempt limit, could IP ban
    if (!isset($attempts)) {
        $attempts = 50; //change to adjust login attempt
    } 
    session_start();
    if (!isset($_SESSION["logAtt"])) {
        $_SESSION["logAtt"] = 0;
    } 
    elseif ($_SESSION["logAtt"] >= $attempts){
        echo "Access Denied, too many attempts";
        exit();
    }else{
        $_SESSION["logAtt"]++; //change for unlimited attempt
    }

    $remainingAtt = $attempts - $_SESSION["logAtt"]
    function validateCred($username, $password)
        {

        $passPatt = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{14,50}$/"; //geeksForGeeks


        if (strlen($username) < 2 || strlen($username) > 25)
            {
                echo "Error, username too" . (($username > 2) ? " short":" long") . " please retry";
                exit("Attempts remaining: ". $attempts - $_SESSION["logAtt"]);
            } 
        elseif (strlen($password) < 12 || strlen($password) > 50)
            {
                echo "Error, password too" . (($username > 12) ? " short":" long") . " please retry";
                exit("Attempts remaining: ". $attempts - $_SESSION["logAtt"]);
            }
        elseif (!(preg_match($passPatt,$password, $matches))){
            echo "Password error, a password should contain the following <br> 1. Length between 14 and 50 <br> 2. At least one digit/special character <br> 3. At least one uppercase/lowercase character <br> ";
            exit("Attempts remaining: " . $attempts - $_SESSION["logAtt"]);
        }
        }


    $username = $_POST["username"];
    $password = $_POST["password"];

    validateCred($username, $password)
=======
<<<<<<< Updated upstream
    $email = $_POST['username'];
    $password = $_POST['password'];

    echo $email
    echo $password
=======
    $email = $_POST["username"];
    $password = $_POST["password"];

    echo "password and username entered :)"
>>>>>>> Stashed changes
>>>>>>> 36077c83f4180679ddd38095a9405467621cdb25














<<<<<<< HEAD
?>
=======
<<<<<<< Updated upstream
>
=======
?>
>>>>>>> Stashed changes
>>>>>>> 36077c83f4180679ddd38095a9405467621cdb25
