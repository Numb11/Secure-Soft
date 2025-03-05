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



    function generateCode(){
        return bin2hex(random_bytes(16));
        
    }


    function authEmail($email){
        $appUrl = "http://localhost:8080/Group%20Project%20-%20Social%20Media/Secure-Soft/verified.php";
        $senderEmail = "tempforproject2@gmail.com";
        $uid = generateCode();

        $activationLink = $appUrl . "/?email=$email&activation_code=$uid";

        $subject = "Activate your account";
        $message = <<<MESSAGE
            Please click the following link to activate your account:
            $activationLink
            MESSAGE;
        
        $header = "From:" . $senderEmail;

        if(mail($email, $subject, $message, $header)){

            try{
                $dbcreds = new mysqli('127.0.0.1', 'root','root','fakebook'); //Define DB credentials
                $verification_code = hash("sha256", $uid);

                $stmt = $dbcreds->prepare("INSERT INTO 'user' ('Email','VerID') VALUES (?,?)");  
                $stmt->bind_param("ss", $email,$verification_code);      
    
                if ($stmt->execute()){
                    echo "UID updated";
    
                } else{
                    throw new Exception($stmt->error);
    
                }
                $stmt -> close();
                $dbcreds->close();
            }catch (Exception $e){
                if (strpos($e->getMessage(), "Duplicate entry") !== false){
                    echo "Error: User wirh emial or verification code exists";
                    
    
                } else{
                    echo "Error ". $e->getMessage();
    
                }
    
    
    
    
            }
    




        }
        
        $_SESSION["email"] = $email;

    }
    

    $email = $_POST["email"];


    authEmail($email);

?>