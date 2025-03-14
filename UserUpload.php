<?php
session_start();
include 'config.php';

if (!isset($_SESSION['UserID'])) {
    die("Error: User not logged in.");
}

$UserID = $_SESSION['UserID'];
$file = $_FILES['file'];

$targetDir = "uploads/";
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

// Generate a unique file name
$newFileName = uniqid("profile_", true) . "." . $fileType;
$targetFilePath = $targetDir . $newFileName;

// Move file securely
if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
    
    // Use prepared statements to prevent SQL injection
    $sql = "UPDATE user SET ProfilePicture = ? WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $targetFilePath, $UserID);

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
