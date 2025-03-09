

<?php
    //Resets a users password through email

    $UrlUid = hash("sha256", $_GET["activation_code"]); //Hash UID given for verification email and stored in url

    $UrlEmail = $_GET["email"];
    $password = $_POST["password"];
    $hashPass = hash("sha256", $password);


    try{
        include("admin/config/dbCon.php");
        if ($UrlUid){

            if ($stmt = $con -> prepare("SELECT `VerID` FROM `user` WHERE `Email` = ? AND `VerID` = ? LIMIT 1")) //fetch UID from db
                {
                    $stmt -> bind_param("ss", $email, $UrlUid); 
                    $stmt -> execute();
                    $stmt -> store_result();
                    $stmt -> bind_result($DbUID);

                    if (strcmp($DbUID,$UrlUid))
                        {    
                            session_start();

                            $uPassSQL = $con->prepare("UPDATE `user` SET `Password` = ?");
                            $uPassSQL->bind_param("s", $hashPass);
                            $uPassSQL -> execute();
                            echo "Password changed, please return to the log-in page :)";

                        }else{
                            echo "Somehting went wrong, this is not the code we sent you!";


                        
                    }


                }
            }else {
                echo "Something, went wrong: Please try again";
                exit();


            }
    }catch (Exception $e){
        echo "Error: ". $e->getMessage();
    }
    
                        //UPDATE DB NOW REMOVE VERIFIED 
                        //Redirect to login page
    
?>
