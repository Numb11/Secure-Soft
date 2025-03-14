

<?php
    //Handling of signing up of a user
    include("admin/config/dbCon.php");

    //function to validate that username and password are in the correct format 
    function validateCred($username, $password)
        {

        $passPatt = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{14,50}$/"; 


        if (strlen($username) < 2 || strlen($username) > 25)
            {
            echo "Error, username too" . (($username > 2) ? " short":" long") . " please retry";
            endSess();

            } 
        elseif (strlen($password) < 12 || strlen($password) > 50)
            {
            echo "Error, password too" . (($username > 12) ? " short":" long") . " please retry";
            endSess();
            }
        elseif (!(preg_match($passPatt,$password, $matches))){
            echo "Password error, a password should contain the following <br> 1. Length between 14 and 50 <br> 2. At least one digit/special character <br> 3. At least one uppercase/lowercase character <br> ";
            endSess();
    
            }
            
        return True;
        }



    //proccessing the submitted sign up form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST["email"]);
        $username = trim($_POST["username"]);
        $password = hash("sha256", trim($_POST["password"]));

	    


        //checking that the email entered is already verified
        $emailCheck = $con->prepare("SELECT `Ver` FROM `user` WHERE `Email` = ?");

        $emailCheck->bind_param("s", $email);
        $emailCheck->execute();
        $emailCheck->store_result();


        if ($emailCheck->num_rows == 0 ) {
            echo "error: Email not verified ";
            exit();
        }elseif($emailCheck->num_rows > 1 ) {
            echo "error: Username is already taken";
            exit();
        }
    }

        //function to sanitize data

	 function sanitiseString($str){ //Sanitise input
            $str = trim($str);
            $str = stripslashes($str);
            return $str;

        }

        $dbUsername = '';
        $createCheck = $con->prepare("SELECT `Username` FROM `user` WHERE `Email` = ?");
        $createCheck->bind_param("s", $email);
        $createCheck->execute();
        $createCheck->store_result();
        $createCheck -> bind_result($dbUsername);
        echo $dbUsername;
        if (strlen($dbUsername) > 1){
            echo "Error: Please try again";
            exit();
        }


    //making sure account doesnt already have password
	    $existing_pass= '';
	    $passCheck = $con->prepare("SELECT 'Password' FROM `user` WHERE `Email` = ?");
        $passCheck->bind_param("s", $email);
        $passCheck->execute();
        $passCheck->store_result();
	    $passCheck->bind_result($existing_pass);
	
	
	
	IF (strlen($existing_pass) > 0){
		ECHO "ERROR: it appears this account is already signed up";
		exit();
	}else{
		
		


        //need to check if username is unique
        //select all rows with same username if theres > 0 then username is already taken
        $userCheck = $con->prepare("SELECT username FROM user WHERE username = ?");
        $userCheck->bind_param("s", $username);
        $userCheck->execute();
        $userCheck->store_result();

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //update database row with username and password 
        $sql_update = ("UPDATE `user` SET `Username` = ?, `Password` = ? WHERE `email` = ?");
        $stmt = $con->prepare($sql_update);
        $stmt->bind_param("sss", $username, $hashed_password, $email);

        //checking if data insertion was executed
        if ( $stmt->execute()) {
            echo "You have signed up!  Please return to the log-in page :)";
        }else{
            echo "error signup unsuccessful ";
        }
        
    }
?>
