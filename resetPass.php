

<?php
    //By Joe
    //This is part of the forgot password functionality
    //Uses get to retreive informaiton from unique URL
    //Using unique id in the URL it is comapred to make sure that this request is coming from the right email
    //SQL inejction rpevented through prepared statements, sanitised and verified input data
    //CSRF and Remote File upload left alongside XSS, no tokens used or enforcement of cleansing special characters



    //Resets a users password through email



    function sanitiseString($str){ //Sanitise input
        $str = trim($str);
        $str = stripslashes($str);
        return $str;

    }


    session_start();
    if (!isset($_SESSION["urlUid"])){
        echo "Oops, something went wrong :(";
        session_unset();
        exit();

    }


    $urlUid =  sanitiseString($_SESSION["urlUid"]);
    $urlEmail = sanitiseString($_SESSION["email"]);

    $password = $_POST["password"];
    $hashPass = hash("sha256", sanitiseString($password));

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

                            $replaceUID = $con->prepare("UPDATE `user` SET `VerID` = ? WHERE `Email` = ? AND `Ver` = 1 AND `Password` IS NOT NULL AND `Password` <> '' ");
                            $newUID = hash("sha256", bin2hex(random_bytes(16)));
                            $replaceUID->bind_param("ss", $newUID,$urlEmail);
                            $replaceUID -> execute();


                            $uPassSQL = $con->prepare("UPDATE `user` SET `Password` = ? WHERE `Email` = ? AND `Ver` = 1 AND `Password` IS NOT NULL AND `Password` <> '' ");
                            $uPassSQL->bind_param("ss", $hashPass,$urlEmail);
                            $uPassSQL -> execute();

                            echo "Password changed, please log-in";

                        }else{
                            echo "Something went wrong, this is not the code we sent you!";
                    }
        }
    }catch (Exception $e){
        echo "Oops, Something really wrong has happened";
        exit();
    }
    
?>
