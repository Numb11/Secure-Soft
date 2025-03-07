

<?php
//connect to sql database
$conn = new mysqli('localhost', 'root','root','fakebook',3307);


//proccessing the submitted sign up form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = hash("sha256", trim($_POST["password"]));


    $emailCheck = $conn->prepare("SELECT Ver FROM user WHERE Email = ?");
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

    $dbUsername = '';
    $createCheck = $conn->prepare("SELECT `Username` FROM `user` WHERE `Email` = ?");
    $createCheck->bind_param("s", $email);
    $createCheck->execute();
    $createCheck->store_result();
    $createCheck -> bind_result($dbUsername);
    echo $dbUsername. "DHUD";
    if (strlen($dbUsername) > 1){
        echo "Error: Please try again";
        exit();
    }





    //need to check if username is unique
    //select all rows with same username if theres > 0 then username is already taken
    $userCheck = $conn->prepare("SELECT username FROM user WHERE username = ?");
    $userCheck->bind_param("s", $username);
    $userCheck->execute();
    $userCheck->store_result();


    //update database row with username and password 
    $sql_update = ("UPDATE `user` SET `Username` = ?, `Password` = ? WHERE `email` = ?");
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sss", $username, $password, $email);

    //checking if data insertion was executed
    if ( $stmt->execute()) {
        echo "You have signed up!  Please return to the log-in page :)";
    }else{
        echo "error signup unsuccessful ";
    }
    
}
?>
