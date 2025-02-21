<?php

    // Prevent Brute Force through attempt limit, could IP ban
    if (!isset($attempts)) {
        $attempts = 3; //change to adjust login attempt
    } 


    session_start(); //Start unique session

    if (!isset($_SESSION["logAtt"])) {         
        $_SESSION["logAtt"] = 0;
        $_SESSION["remainingAtt"] = ($attempts - $_SESSION["logAtt"]);
        $_SESSION["login_time_stamp"] = time();
    }else{
        if ((time()- $_SESSION["login_time_stamp"]) > 50){ //Session should end after 50 seconds
            echo "Session timeout, please refresh";
            session_unset();
            session_destroy();
            exit();

        }

    }
    if ($_SESSION["logAtt"] >= $attempts){
        echo "Access Denied, too many attempts";
        exit();
    }else{
        $_SESSION["logAtt"]++; //change for unlimited attempt
        $_SESSION["remainingAtt"]--;
    }


    function endSess(){
        exit("Attempts remaining: " . $_SESSION["remainingAtt"]);

    }



    
    function validateCred($username, $password)
        {

        $passPatt = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{14,50}$/"; //geeksForGeeks


        if (strlen($username) < 2 || strlen($username) > 25)
            {
                echo "Error, username too" . (($username > 2) ? " short":" long") . " please retry";
                endSess();

            } 
        elseif (strlen($password) < 12 || strlen($password) > 50)
            {
                echo "Error, password too" . (($username > 12) ? " short":" long") . " please retry";
                endSess();
            }
        elseif (!(preg_match($passPatt,$password, $matches))){
            echo "Password error, a password should contain the following <br> 1. Length between 14 and 50 <br> 2. At least one digit/special character <br> 3. At least one uppercase/lowercase character <br> ";
            endSess();
            
        }
        }


    $username = $_POST["username"];
    $password = $_POST["password"];



    validateCred($username, $password);

?>