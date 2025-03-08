
<?php
    include("admin/config/dbCon.php");

    $UrlUid = hash("sha256", $_GET["activation_code"]); //Hash UID given for verification email and stored in url

    $UrlEmail = $_GET["email"] ;//hash email in url too




    try{
        if ($UrlUid){

            if ($stmt = $con -> prepare("SELECT `VerID` FROM `user` WHERE `Email` = ? AND `VerID` = ? LIMIT 1")) //fetch UID from db
                {
                    $stmt -> bind_param("ss", $email, $UrlUid); 
                    $stmt -> execute();
                    $stmt -> store_result();
                    $stmt -> bind_result($DbUID);

                    if (strcmp($DbUID,$UrlUid))
                        {
                            echo "Verified! Please return to the sign-up page";
                            session_start();

                            $stmt = $dbcreds->prepare("UPDATE `user` SET Ver = TRUE");
                            $stmt -> execute();
                            




                        }else{
                            echo "Somehting went wrong, this is not the code we sent you!";


                        
                    }

                }
            }
    }catch (Exception $e){
        echo "Error: ". $e->getMessage();
    }
?>



