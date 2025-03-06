//ADD FUCNTIONALITY TO RETREIVE THE INFORMATION FROM THE INPUTS

//CHECK IF THEY ARE VERIFIED USING SQL

//IF THEY ARE ADD THE DETAILS TO THE DATABASE

<?php
//connect to sql database
$conn = new mysqli('127.0.0.1', 'root', 'password', 'fakebookdb');

//check connection
if ($conn->connection_error) {
    die("connection failed: " . $conn->connection_error);
}

//proccessing the submitted sign up form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $passwrod = trim($_POST["password"]);

    //need to check if email is verified 
    //select the ver in database where email matches if no matches then not veridied 
    $emailCheck = $conn->prepare("SELECT Ver FROM user WHERE Email = ?");
    $emailCheck->bind_param("s", $email);
    $emailCheck->execute();
    $emailCheck->store_result();

    IF ($emailCheck->num_rows == 0 ) {
        echo "error: email not found or not verified ";
        exit();
    }

    //need to check if username is unique
    //select all rows with same username if theres > 0 then username is already taken
    $userCheck = $conn->prepare("SELECT username FROM user WHERE username = ?");
    $userCheck->bind_param("s", $username);
    $userCheck->execute();
    $userCheck->store_result();

    IF ($emailCheck->num_rows > 0 ) {
        echo "error: username is already taken";
        exit();
    }

    //update database row with username and password 
    $sql_update = "UPDATE user SET Username = ?, Password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->blind-param("sss", $username, $password, $email);
      

    //checking if data insertion was executed
    if ( stmt->execute()) {
        echo "signup successful, you can now login ";
    }else{
        echo "error signup unsuccessful ";
    }

}
?>
