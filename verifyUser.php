

<?php
//connect to sql database
$conn = new mysqli('localhost', 'root','','fakebook');


//proccessing the submitted sign up form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);


	//fucntion to make sure username and password is in correct format
	
	 function validateCred($username, $password)
        {

        $passPatt = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{14,50}$/"; //geeksForGeeks


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
        }

	//cehcking if the email is verified inside the database
    $emailCheck = $conn->prepare("SELECT `Ver` FROM `user` WHERE `Email` = ?");
    $emailCheck->bind_param("s", $email);
    $emailCheck->execute();
    $emailCheck->store_result();

	//checking that there are no rows where the email sint verified
    if ($emailCheck->num_rows == 0 ) {
        echo "error: Email not verified ";
        exit();
    }elseif($emailCheck->num_rows > 1 ) {
        echo "error: Username is already taken";
        exit();
    }
	
	//making sure account doesnt already have password
	$existing_pass= '';
	$passCheck = $conn->prepare("SELECT Password FROM user WHERE email = ?");
    $passCheck->bind_param("s", $email);
    $passCheck->execute();
    $passCheck->store_result();
	$passCheck->bind_result($existing_pass);
	
	
	
	IF (strlen($existing_pass) > 0){
		ECHO "ERROR: it appears this account is already signed up";
		exit();
	}else{
		
		
	}
	
   

    //need to check if username is unique
    //select all rows with same username if theres > 0 then username is already taken
    $userCheck = $conn->prepare("SELECT username FROM user WHERE username = ?");
	
    $userCheck->bind_param("s", $username);
    $userCheck->execute();
    $userCheck->store_result();
	IF ($userCheck->num_rows > 0 ) {
        echo "error: username is already taken";
        exit();
    }
	
	
	
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //update database row with username and password 
    $sql_update = ("UPDATE `user` SET `Username` = ?, `Password` = ? WHERE `email` = ?");
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sss", $username, $hashed_password, $email);

    //checking if data insertion was executed
    if ( $stmt->execute()) {
		
        echo "You have signed up!  Please return to the log-in page :)";
		?>
		<br>
            <br>
            <label> <a href="index.php">Log-in here!</a> </label>

        <br></br>
		<?php
		
    }else{
        echo "error signup unsuccessful ";
    }

}
?>
