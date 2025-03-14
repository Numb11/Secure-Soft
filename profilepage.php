<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    die("Error: User not logged in.");
}

$UserID = $_SESSION['UserID'];
$result = $conn->query("SELECT * FROM user WHERE UserID = $UserID");

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

    <h2>Welcome, <?= htmlspecialchars($user['Username']) ?></h2>

   
    <img src="<?= !empty($user['ProfilePicture']) ? htmlspecialchars($user['ProfilePicture']) : 'default.png' ?>" width="150" height="150">

   
    <form action="UserUpload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" accept="image/*" required>
        <button type="submit" name="UserUpload">Upload</button>
        <br>
	<textarea name= "description" placeholder= "Enter description..." rows="3" cols="50"></textarea>
	<br>
	<input type="submit" value="upload">
    
    </form>
	


</body>
</html>
