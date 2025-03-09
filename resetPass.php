

<?php
    //Resets a users password through email
    session_start();
    if (!isset($_SESSION["urlUid"])){
        echo "Oops, something went wrong :(";
        session_unset();
        exit();

    }
    $uid =  $_SESSION["urlUid"];
    $urlUid = $uid;
    $urlEmail = $_SESSION["email"];

    $password = $_POST["password"];
    $hashPass = hash("sha256", $password);

    try{
        include("admin/config/dbCon.php");
        if ($urlUid){

                    $stmt = $con -> prepare("SELECT `VerID` FROM `user` WHERE `Email` = ?"); //fetch UID from db
                    $stmt -> bind_param("s", $urlEmail); 
                    $stmt -> execute();
                    $stmt -> store_result();
                    $stmt -> bind_result($DbUID);
                    if ($stmt->num_rows > 0){
                        $stmt->fetch();
                    }
                    if (strcasecmp($DbUID,$urlUid) == 0)
                        {    

                            $uPassSQL = $con->prepare("UPDATE `user` SET `VerID` = ? WHERE `Email` = ? AND `Ver` = 1 AND `Password` IS NOT NULL AND `Password` <> '' ");
                            $replaceUID = hash("sha256", bin2hex(random_bytes(16)));
                            $uPassSQL->bind_param("ss", $replaceUID,$urlEmail);
                            $uPassSQL -> execute();
                            echo "Password changed, please return to the log-in page :)";

                        }else{
                            echo "Somehting went wrong, this is not the code we sent you!";
                    }
        }
    }catch (Exception $e){
        echo "Error: Please try again, ". $e->getMessage();
        exit();
    }
    
                        //UPDATE DB NOW REMOVE VERIFIED 
                        //Redirect to login page
    
?>
