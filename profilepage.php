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
