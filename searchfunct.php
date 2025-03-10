<?php
// Database connection settings
$host = 'localhost';  // Hostname or IP address of your database server
$username = 'root';   // Your database username
$password = 'root';   // Your database password
$dbname = 'fakebook'; // Your database name

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
    echo "<h2>Search Results for '$searchTerm':</h2>";
    
    // Display the results as an HTML table or list
    echo "<table border='1'>";
    echo "<tr><th>User ID</th><th>Username</th><th>Name</th></tr>";
    
    // Loop through and display the search results
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['Username'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No results found for '$searchTerm'.</p>";
}

// Get the URL from the query parameter
$url = $_GET['url']; // Vulnerability: User-provided URL without validation

// Fetch content from the URL using file_get_contents (SSRF vulnerability)
$response = file_get_contents($url); // Vulnerable part: User can provide any URL

// Output the fetched content
echo "<h3>Fetched Content from the URL:</h3>";
echo "<pre>" . htmlspecialchars($response) . "</pre>";

// Close the connection
$conn->close();
?>
