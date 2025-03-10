<?php
session_start();
include("admin/config/dbCon.php");

// Check if user is logged in
if (!isset($_SESSION['auth'])) {
    die("Error: User not logged in.");
}

$authenticated = $_SESSION['auth'];
$username = $_SESSION["username"];


$result = $con->query("SELECT * FROM `user` WHERE `Username` = $username");

if ($result->num_rows == 0) {
    die("Error: User not found.");
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>

    <h2>Welcome, <?= htmlspecialchars($user['Username']) ?></h2>

   
    <img src="<?= !empty($user['ProfilePicture']) ? htmlspecialchars($user['ProfilePicture']) : 'default.png' ?>" width="150" height="150">

   
    <form action="UserUpload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" accept="image/*" required>
        <button type="submit" name="UserUpload">Upload</button>
    </form>


</body>
</html>
