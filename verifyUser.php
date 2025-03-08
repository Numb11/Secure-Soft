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
        if ((time()- $_SESSION["login_time_stamp"]) > 600){ //Session should end after 50 seconds
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
        exit(" <br> <strong>Attempts remaining: " . $_SESSION["remainingAtt"] . "</strong>");

    }





        $username = $_POST["username"];
        $password = $_POST["password"];

        

        try{

                $hashPass = hash("sha256", $password);

                $stmt = $con->prepare("SELECT `Password` FROM `user` WHERE `Username` = ? AND `Password` = ?");  
                $stmt->bind_param("ss", $username, $hashPass);   
                $stmt->execute();
                $stmt->store_result();     

                if($stmt->num_rows == 1 ){
                    echo "Logged in! Landing page will be here:";



                }else{
                    echo "Incorrect log-in details :(";

                }

                $stmt -> close();
                $con->close();
                exit();


            }catch (Exception $e){

                    echo "Error, Please try again". $e->getMessage();
    
                }
            

?>


