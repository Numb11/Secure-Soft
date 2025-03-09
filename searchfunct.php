<?php
// Database connection settings
$host = 'localhost';  // Hostname or IP address of your database server
$username = 'root';   // Your database username
$password = 'root';       // Your database password
$dbname = 'fakebook';  // Your database name

// Establish a database connection
$conn = new mysqli($host, $username, $password, $dbname);

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
    echo "<h2>Search Results:</h2>";
    echo "<form method='POST' action=''>"; // You can adjust the action if needed

    // Start the dropdown menu
    echo "<select name='searchResult' id='searchResult'>";
    
    // Add an empty option or a default prompt
    echo "<option value=''>Select an option</option>";

    // Loop through and populate the dropdown with results
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    }

    // Close the dropdown and the form
    echo "</select><br><br>";
    echo "<button type='submit'>Submit</button>";
    echo "</form>";
} else {
    echo "<p>No results found for '$searchTerm'.</p>";
}

// Close the connection
$conn->close();
?>