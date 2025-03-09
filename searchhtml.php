<DOCTYPE html>
<html>

<head>
<title>FakeBook</title>
<link rel = "stylesheet" href="log-in.css">
</head>
<body>
    
    <!-- Search form -->
    <form action="search.php" method="GET">
        <label for="searchTerm">Search Term:</label>
        <input type="text" id="searchTerm" name="searchTerm" required>
        <button type="submit">Search</button>
    </form>

    <hr>

    <!-- Display search results -->
    <?php
    if (isset($_GET['searchTerm'])) {
        // Display search results if search term is passed
        include('searchfunct.php');
    }
    ?>
</body>
</html>
