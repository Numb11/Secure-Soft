<?php
session_start();
include 'db.php';

if (!isset($_SESSION['UserID'])) {
    die("Error: User not logged in.");
}

$UserID = $_SESSION['UserID'];
$file = $_FILES['file'];
$bio = trim($_POST['bio']); // Get the bio/caption

// Upload directory
$uploadDir = __DIR__ . "/uploads/";
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

// Get file details
$fileName = basename($file["name"]);
$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$fileTmp = $file["tmp_name"];
$fileSize = $file["size"];
$fileMimeType = mime_content_type($fileTmp);

// Generate a secure file name
$newFileName = uniqid("profile_", true) . "." . $fileExt;
$targetFilePath = $uploadDir . $newFileName;

// Security checks
if (!in_array($fileExt, $allowedExtensions) || !in_array($fileMimeType, $allowedMimeTypes)) {
    die("Error: Invalid file type.");
}
if ($fileSize > 2 * 1024 * 1024) { // 2MB limit
    die("Error: File too large.");
}

// Move the file and update the database
if (move_uploaded_file($fileTmp, $targetFilePath)) {
    $sql = "UPDATE user SET ProfilePicture = ?, Bio = ? WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $newFileName, $bio, $UserID);
    
    if ($stmt->execute()) {
        header("Location: profile.php"); // Refresh profile page
        exit();
    } else {
        die("Database error: " . $stmt->error);
    }
} else {
    die("Error: Upload failed.");
}
?>
