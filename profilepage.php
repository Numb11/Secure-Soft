<?php
session_start();
include("admin/config/dbCon.php");



if (!isset($_SESSION['username']) OR ($_SESSION['username'] == False )) {
    die("Error: User not logged in.");
}



$username = $_SESSION["username"];

$stmt = $con->prepare("SELECT * FROM user WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$DbR = $result->fetch_assoc();
$stmt->close();
if ($result->num_rows == 0) {
    die("Error: User not found.");
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <link rel = "stylesheet" href="log-in.css">
	
	</head>
<body>

    <h2>Welcome, <?= htmlspecialchars($username) ?></h2>

   
    <img src="<?= !empty($user['ProfilePicture']) ? htmlspecialchars($user['ProfilePicture']) : 'default.png' ?>" width="150" height="150">

   
    <form action="UserUpload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" accept="image/*" required>
        <button type="submit" name="UserUpload">Upload</button>
        <br>
	<textarea name= "description" placeholder= "Enter description..." rows="3" cols="50"></textarea>
	<br>
	<input type="submit" value="upload">

    </form>
	

    <button onclick="window.location.href='chat.php'">
    Go to messaging page
    </button>



</body>
</html>
