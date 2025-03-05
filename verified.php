
<?php
    $dbcreds = new mysqli("localhost", "joe", "root","fakebook"); //Define DB credentials




    $UrlUid = hash("sha256", $_GET["activation_code"]); //Hash UID given for verification email and stored in url
    $UrlEmail = hash("sha256", $_GET["email"]) //hash email in url too



    if ($UrlUid){

        if ($stmt = $dbcreds -> prepare("SELECT `email`, `verification_code` FROM `user' WHERE BINARY `Email` = ? AND 'VerId' = ? LIMIT 1")) //fetch UID from db
            {
                $stmt -> bind_param("ss", $email, $UrlUid); 
                $stmt -> execute();
                $stmt -> bind_result($DbUID);
                $stmt -> store_result();

                while ($stmt -> fetch())
                {
                    if ($DbUID == $UrlUid)
                    {
                        echo "Verified!"
                        session_start();

                        //UPDATE DB NOW REMOVE VERIFIED 
                        //Redirect to login page

    } 
    
?>



