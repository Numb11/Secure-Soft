


<?php
    //Handles a emial verification link
    include("admin/config/dbCon.php");

    $UrlUid = hash("sha256", $_GET["activation_code"]); //Hash UID given for verification email and stored in url

    $UrlEmail = $_GET["email"] ;//hash email in url too




    try{

                    $stmt = $con -> prepare("SELECT `VerID` FROM `user` WHERE `Email` = ? AND `VerID` = ?"); //fetch UID from db
                    $stmt -> bind_param("ss", $UrlEmail, $UrlUid); 
                    $stmt -> execute();
                    $stmt -> store_result();
                    $stmt -> bind_result($DbUID);
                    $stmt->fetch();
                
                    if (strcasecmp($DbUID,$UrlUid) == 0)
                        {
                            echo "Verified! Please return to the sign-up page, <a href='../signUphtml.php'>Click here</a>";
                            session_start();

                            $stmt = $con->prepare("UPDATE `user` SET Ver = TRUE");
                            $stmt -> execute();
                            




                        }else{
                            echo "Somehting went wrong, this is not the code we sent you!";


                        
                    }

                
            
    }catch (Exception $e){
        echo "Error: ". $e->getMessage();
    }
?>



