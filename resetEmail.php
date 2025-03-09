

<?php
    //By Joe
    //This is part of the forgot password functionality
    //Sends an email to users saved email contianing a unique URL
    //Only sends an email if the user has created an account

    //SQL injection rpevented through prepared statements, sanitised and verified input data
    //CSRF and Remote File upload left alongside XSS, no tokens used or enforcement of cleansing special characters


    function sanitiseString($str){ //Sanitise input to prevent SQL injection
        $str = trim($str);
        $str = stripslashes($str);
        return $str;

    }

    function generateCode(){
        return bin2hex(random_bytes(16)); //Generate a unique value
    }

    function authEmail($email){
        
        $appUrl = "http://localhost:8080/Group%20Project%20-%20Social%20Media/Secure-Soft/resetPasshtml.php";

        $senderEmail = "tempforproject2@gmail.com";
        $uid = hash("sha256", bin2hex(random_bytes(16))); 
        $activationLink =  $appUrl . "?email=$email&activation_code=$uid";

        $subject = "Reset password";
        $message = <<<MESSAGE
            Please click the following link to reset your password:
            $activationLink
            MESSAGE;
        
        $header = "From:" . $senderEmail;

        

        try{

            include("admin/config/dbCon.php"); //Prepared statements prevent SQL injection
            $stmt = $con->prepare("UPDATE `user` SET `VerID` = ? WHERE `Email` = ? AND `Ver` = 1 AND `Password` IS NOT NULL AND `Password` <> '' ");  
            $stmt->bind_param("ss",$uid, $email);      

            if ($stmt->execute()){
                if(mail($email, $subject, $message, $header)){
                    echo "<b>Reset password email sent!</b>";


                }else{
                    echo "Oh no, something went wrong with sending your email, please try again";

                }

            } else{
                throw new Exception($stmt->error);

            }
            $stmt -> close();
            $con->close();
            }catch (Exception $e){
                echo "Oops, theres been a huge error :("; //Keep errors ambigious on purpose
            }
        }
        


        // Prevent Brute Force through attempt limit, could IP ban
    if (!isset($attempts)) {
        $attempts = 5; //change to adjust login attempt
    } 


    session_start(); //Start unique session

    if (!isset($_SESSION["logAtt"])) {   //Prevent a DOS attack with constant email requests    
        $_SESSION["logAtt"] = 0;
        $_SESSION["remainingAtt"] = ($attempts - $_SESSION["logAtt"]);
        $_SESSION["login_time_stamp"] = time();
    }else{
        if ((time()- $_SESSION["login_time_stamp"]) > 300){ //Session should end after 5 minutes
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



    $email = sanitiseString($_POST["email"]);
    authEmail($email);

?>