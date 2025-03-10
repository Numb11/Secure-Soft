

<?php   
        //By Joe
        //This script handles the verification of a user attempting log-in
        //SQL injection fixed through sanitisation, validation and prepared SQL statements
        //FIle type nforcemnt does not apply here
        //CSRF TOKENS NOT ADDED, Remote file uplaod not applicable as vulnerabilit
        //User input not fully sanitised allowing XSS, to prevent, htmlspecialchars() should be used

        include("admin/config/dbCon.php"); //DB credentials


        function sanitiseString($str){ //Sanitise input
            $str = trim($str);
            $str = stripslashes($str);
            return $str;

        }

        function endSess(){
            exit(" <br> <strong>Attempts remaining: " . $_SESSION["remainingAtt"] . "</strong>");
        }

        session_start(); //Start unique session allowing for global variables

        $attempts = 5;

        if (!isset($_SESSION["logAtt"])) { 
            $_SESSION["logAtt"] = 0;
            $_SESSION["remainingAtt"] = ($attempts - $_SESSION["logAtt"]);//5 login attempts
            $_SESSION["login_time_stamp"] = time();

        }else{
            if ((time()- $_SESSION["login_time_stamp"]) > 150){ //Session should end after 5 minutes, prevention of session hijacking
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
            $_SESSION["logAtt"]++; 
            $_SESSION["remainingAtt"]--;
        }

        //Fetch data from form using the more secure non caching POST
        $username = sanitiseString($_POST["username"]);
        $password = sanitiseString($_POST["password"]);
        
        try{ //Error handle to prevent 

                    $hashPass = hash("sha256", $password);
                    $stmt = $con->prepare("SELECT `Password` FROM `user` WHERE `Username` = ? AND `Password` = ?");  
                    $stmt->bind_param("ss", $username, $hashPass);   
                    $stmt->execute();
                    $stmt->store_result();     

                    if($stmt->num_rows == 1 ){
                        $_SESSION["auth"] = True; 
                        $_SESSION["username"] = $username;
                        header("Location: ../Secure-Soft/landingPage.php");
                        

                    }else{
                        echo "Incorrect log-in details :(";
                    }

                    $stmt -> close();
                    $con->close();
                    exit();


                }catch (Exception $e){

                        echo "Oops, something catastrophic has happened :(";
        
            }
            

?>


