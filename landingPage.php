<?php
session_start();
include("admin/config/dbCon.php");

// Check if user is logged in
if (!isset($_SESSION['auth'])) {
    die("Error: User not logged in.");
}

$authenticated = $_SESSION['auth'];
$username = $_SESSION["username"];

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>

    <h2>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?></h2>

   
    <img src="<?= !empty($user['ProfilePicture']) ? htmlspecialchars($user['ProfilePicture']) : 'default.png' ?>" width="150" height="150">

   
<form action="UserUpload.php" method="POST" enctype="multipart/form-data" class="mt-3">
    <input type="file" name="file" class="form-control mb-2" required>
    
    <textarea name="bio" class="form-control mb-2" placeholder="Enter your bio or caption..."></textarea>
    
    <button type="submit" class="btn btn-primary w-100">Upload File & Bio</button>
</form>


</body>
</html>
