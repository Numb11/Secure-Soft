<?php
session_start();
include 'dbCON.php';

if (!isset($_SESSION['UserID'])) {
    die("Error: User not logged in.");
}

$UserID = $_SESSION['UserID'];
$file = $_FILES['file'];

$targetDir = "uploads/";
$fileName = basename($file["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

// Check if file is allowed file 
$allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

if (in_array($fileType, $allowedTypes)) {
    if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
        
        $sql = "UPDATE user SET ProfilePicture = ? WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $targetFilePath, $UserID);
        if ($stmt->execute()) {
            echo "Profile picture successfull";
        } else {
            echo "Database error: " . $stmt->error;
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
}
?>
