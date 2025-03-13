

<?php
    function sanitiseString($str){ //Sanitise input
        $str = trim($str);
        $str = stripslashes($str);
        return $str;

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


            try{
                include("admin/config/dbCon.php");
                $verification_code = hash("sha256", $uid);

                $stmt = $con->prepare("SELECT `UserID` FROM `user` WHERE `Email` = ?");  
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0 ) {
                    echo "Something went wrong : (";
                    exit();
                }


                $stmt = $con->prepare("INSERT INTO `user` (`Email`,`VerID`) VALUES (?,?)");  
                $stmt->bind_param("ss", $email,$verification_code);      
    
                if ($stmt->execute()){
                    echo "UID updated";
                    if(mail($email, $subject, $message, $header)){
                        echo "Verification email sent!, please return to login page after verifying :-)";


                    }else{
                        echo "Oh no, something went wrong with sending your email, please try again";

                    }
    
                } else{
                    throw new Exception($stmt->error);
    
                }
                $stmt -> close();
                $con->close();
            }catch (Exception $e){
                if (strpos($e->getMessage(), "Duplicate entry") !== false){
                    echo "You have already attempted verification with ".  $email ." , please check your inbox";
                    

    
                } else{
                    echo "Error, Please retry";
    
                }
            }
        $_SESSION["email"] = $email;
    }




    //Handles sending of verification email
    // Prevent Brute Force through attempt limit, could IP ban
    if (!isset($attempts)) {
        $attempts = 50; //change to adjust login attempt
    } 
    session_start(); //Start unique session

    if (!isset($_SESSION["login_time_stamp"])) {        
        $_SESSION["login_time_stamp"] = time();
    }else{
        if ((time()- $_SESSION["login_time_stamp"]) > 600){ //Session should end after 50 seconds
            echo "Session timeout, please refresh";
            session_unset();
            session_destroy();
            exit();

        }

    }

    $email = sanitiseString($_POST["email"]);
    authEmail($email);

?>