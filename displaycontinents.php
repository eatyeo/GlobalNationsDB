<!DOCTYPE html>
<html>
<head>
    <title>Continents with No Countries</title>
    
    <!-- Link to external CSS file for styling -->
    <link rel="stylesheet" type="text/css" href="mainmenu.css">
    
     <!-- Google Font: Quicksand for styling -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
<?php
// Include the database connection file
include "connecttodb.php";

// Query to get all unique continent IDs from the country table (continents that have countries)
$check_query = "SELECT DISTINCT continentid FROM country";
$check_result = mysqli_query($connection, $check_query);
    
// Check if the query executed successfully
if (!$check_result) {
    die("Database query failed.");
}

// Create an array to store continent IDs that have countries
$continents_with_countries = [];
while ($row = mysqli_fetch_assoc($check_result)) {
    $continents_with_countries[] = $row['continentid'];
}

// Query to retrieve all continents from the continent table
$query = "SELECT name, description, continentid FROM continent";
$result = mysqli_query($connection, $query);

// Check if the query executed successfully
if (!$result) {
    die("Database query failed.");
}

// Display the heading
echo "<h2>Continents with No Countries Registered</h2>";

$found_empty = false;

// Iterate through the list of all continents
while ($row = mysqli_fetch_assoc($result)) {
    // Only display continents who are NOT in the list of continents with countries
    if (!in_array($row['continentid'], $continents_with_countries)) {
        if (!$found_empty) {
            echo "<ul>";
            $found_empty = true;
        }
        echo "<li><strong>" . htmlspecialchars($row['name']) . "</strong> (ID: " . $row['continentid'] . ")";
        if (!empty($row['description'])) {
            echo "<br><em>" . htmlspecialchars($row['description']) . "</em>";
        }
        echo "</li>";
    }
}

if ($found_empty) {
    echo "</ul>";
} else {
    echo "<p>All continents have at least one country registered in the database.</p>";
}

// Free the memory used by the result sets
mysqli_free_result($result);
mysqli_free_result($check_result);
?>

<!-- Back Button -->
<div class="back-container">
    <a href="mainmenu.php" class="back-button">Back to Main Menu</a>
</div>
    
</div>
</body>
</html>