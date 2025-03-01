
<?php
    $dbcreds = new mysqli('localhost', 'x', 'y', 'z',0000); //Define DB credentials




    $UrlUid = hash("sha256", $_GET["activation_code"]); //Hash UID given for verification email and stored in url
    $UrlEmail = hash("sha256", $_GET["email"]) //hash email in url too

    


    if ($UrlUid){

        if ($stmt = $dbcreds -> prepare("SELECT `email`, `verification_code` FROM `User' WHERE BINARY `email` = email AND 'VerId' = id LIMIT 1")) //fetch UID from db
            {
                $stmt -> bind_param("s", $email); 
                $stmt -> bind_param("id", $UrlUid);
                $stmt -> execute();
                $stmt -> bind_result($DbUID);
                $stmt -> store_result();

                while ($stmt -> fetch())
                {
                    if ($DbUID == $UrlUid)
                    {
                        echo "verified"
                        session_start();

                        //UPDATE DB NOW REMOVE VERIFIED 

    } 
    
?>



