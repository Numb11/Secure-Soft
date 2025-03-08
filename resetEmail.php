<?php

    include("admin/config/dbCon.php");

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



    function generateCode(){
        return bin2hex(random_bytes(16));
        
    }


    function authEmail($email){
        $appUrl = "http://localhost:8080/Group%20Project%20-%20Social%20Media/Secure-Soft/resetPasshtml.php";
        $senderEmail = "tempforproject2@gmail.com";
        $uid = generateCode();

        $activationLink = $appUrl . "/?email=$email&activation_code=$uid";

        $subject = "Reset password";
        $message = <<<MESSAGE
            Please click the following link to reset your password:
            $activationLink
            MESSAGE;
        
        $header = "From:" . $senderEmail;

        

        try{
            $verification_code = hash("sha256", $uid);
            $stmt = $con->prepare("INSERT INTO `user` (`VerID`) SELECT ? FROM `user` WHERE `Username` = ? AND `Password` IS NOT NULL AND `Password` <> ''");  
            $stmt->bind_param("ss",$verification_code, $email,);      

            if ($stmt->execute()){
                if(mail($email, $subject, $message, $header)){
                    echo "Reset password email sent!";


                }else{
                    echo "Oh no, something went wrong with sending your email, please try again";

                }

            } else{
                throw new Exception($stmt->error);

            }
            $stmt -> close();
            $dbcreds->close();
            }catch (Exception $e){
                echo "Error ". $e->getMessage();

            }




        }
        
    

    $email = $_POST["email"];


    authEmail($email);

?>