<?php
session_start();
include("admin/config/dbCon.php");

if (!isset($_SESSION['username']) OR ($_SESSION['username'] == False )) {
    die("Error: User not logged in.");
}




$username = $_SESSION["username"];
$file = $_FILES['file'];


$targetDir = "../Uploads";
$allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
$maxFileSize = 2 * 1024 * 1024; // 2MB limit

// Check for upload errors
if ($file['error'] !== UPLOAD_ERR_OK) {
    die("Error: File upload failed.");
}

// Get file details
$fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
$fileSize = $file["size"];

// Check file type
if (!in_array($fileType, $allowedTypes)) {
    die("Invalid file type. echo <br><a href='profilepage.php'>Go to Profile</a>; Only JPG, JPEG, PNG, and GIF are allowed.");
	
}

// Check file size
if ($fileSize > $maxFileSize) {
    die("File too large. Maximum allowed size is 2MB.");
}


// Move file securely
if (move_uploaded_file($file["tmp_name"], $targetDir)) {
    
    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE user SET ProfilePicture = ? WHERE username = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $targetDir, $username);

    if ($stmt->execute()) {
        echo "Profile picture uploaded successfully!";
        echo "<br><a href='profilepage.php'>Go to Profile</a>"; // Link to another page
    } else {
        echo "Database error: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "Error moving the uploaded file.";
	
}
?>
