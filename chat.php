<?php
// Start the session to access the session variables
session_start();

// Check if the user is logged in (i.e., session variable exists)
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// The logged-in user's ID (sender)
$sender_id = $_SESSION['user_id']; // Get the sender ID from session

// Get the receiver ID (from the URL)
$receiver_id = isset($_GET['receiver_id']) ? (int)$_GET['receiver_id'] : 0; // Ensure it's an integer

// Ensure the receiver ID is valid
if ($receiver_id == 0) {
    die("Invalid receiver ID");
}

// Database connection settings
$host = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'fakebook';

// Establish a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for sending a message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert the message into the database
    $query = "INSERT INTO message (SenderID, RecieverID, Content) VALUES ('$sender_id', '$receiver_id', '$message')";
    if ($conn->query($query) === TRUE) {
        echo "<p>Message sent successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

// SQL query to get all messages between the two users
$query = "SELECT * FROM message WHERE (SenderID = $sender_id AND RecieverID = $receiver_id) OR (SenderID = $receiver_id AND RecieverID = $sender_id) ORDER BY timestamp ASC";
$result = $conn->query($query);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        /* Styles for chat */
    </style>
</head>
<body>

<div class="chat-container">
    <div class="message-box">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $message_class = $row['SenderID'] == $sender_id ? 'sender-message' : 'receiver-message';
                echo "<div class='message $message_class'>";
                echo "<div class='message-content'>" . htmlspecialchars($row['Content']) . "</div>";
                echo "<div class='message-time'>" . $row['timestamp'] . "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No messages yet. Start the conversation!</p>";
        }
        ?>
    </div>

    <form method="POST" action="chat.php?receiver_id=<?php echo $receiver_id; ?>" class="message-input-container">
        <textarea name="message" rows="3" placeholder="Type a message..." required></textarea>
        <button type="submit">Send</button>
    </form>
</div>

</body>
</html>