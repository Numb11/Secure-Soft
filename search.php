<?php

$host = '127.0.0.1';  
$username = 'root';   
$password = '';  
$dbname = 'fakebook'; 
$port = 3306 ;


$conn = new mysqli($host, $username, $password, $dbname, 3306);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search term from the URL
$searchTerm = mysqli_real_escape_string($conn, $_GET['searchTerm']); // Sanitize user input

// SQL query to search the database
$query = "SELECT * FROM user WHERE Username LIKE '%$searchTerm%'";

// Execute the query
$result = $conn->query($query);

// Check if there are any results
if ($result->num_rows > 0) {
    echo "<h2>Search Results for '$searchTerm':</h2>";
    
    // Display the results as an HTML table or list
    echo "<table border='1'>";
    echo "<tr><th>UserID</th><th>Username</th></tr>";
    
    // Loop through and display the search results
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['UserID'] . "</td>";
        echo "<td>" . $row['Username'] . "</td>";
    // Adds a hyperlink to start a session with user they select
        echo "<td><a href='chat.php?RecieverID=" . $row['UserID'] . "'>Start Chat</a></td>";
        echo "<td>";

        echo "<form method='POST' action='chat.php'>";
        echo "<input type='hidden' name='RecieverID' value='" . $row['UserID'] . "'>";
        echo "<input type='submit' value='Start Chat'>";
        echo "</form>";
        echo "</td>";

        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No results found for '$searchTerm'.</p>";
}

?>