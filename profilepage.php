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
	<script>
        function validateForm() {
            var fileInput = document.getElementById("fileUpload");
            var allowedExtensions = /\.(jpg|jpeg|png|gif)$/i;
            if (!allowedExtensions.exec(fileInput.value)) {
                alert("Invalid file type. Please upload an image file (JPG, JPEG, PNG, GIF).");
                fileInput.value = "";
                return false;
            }
            return true;
        }
    </script>
	
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
