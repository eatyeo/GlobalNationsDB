<!DOCTYPE html>
<html>
<head>
    <title>Languages of the World</title>
    
    <!-- Link to external CSS file for styling -->
    <link rel="stylesheet" type="text/css" href="mainmenu.css">
    
    <!-- Google Font: Quicksand for styling -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <style>
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        
        th {
            background-color: #2b2b2b;
        }
        
        /* Scrollable container for the table */
        .scrollable-table {
            max-height: 400px; /* Limits table height */
            overflow-y: auto; /* Enables vertical scrolling */
        }
    </style>
</head>
<body>

<div class="container">
<?php
// Include the database connection file
include "connecttodb.php";
    
// Check if the database connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Define allowed sorting columns to prevent SQL injection
$allowed_columns = ["name", "language_family", "speakers_worldwide", "official"];
$allowed_orders = ["ASC", "DESC"];

// Retrieve sorting parameters from the URL query string (defaulting to name and ascending order)
$order_by = (isset($_GET['order_by']) && in_array($_GET['order_by'], $allowed_columns)) ? $_GET['order_by'] : "name";
$sort_order = (isset($_GET['sort_order']) && in_array($_GET['sort_order'], $allowed_orders)) ? $_GET['sort_order'] : "ASC";

// Query to fetch languages from the database, ordered dynamically based on user selection
$query = "SELECT languageid, name, language_family, speakers_worldwide, official FROM language ORDER BY $order_by $sort_order";
$result = mysqli_query($connection, $query);

// Check if the query execution was successful
if (!$result) {
    die("Query Failed: " . mysqli_error($connection)); // Display error message in case of failure
}

// Display page title
echo "<h1>Languages of the World</h1>";
?>

<!-- Sorting Form -->
<form method="get">
    <label>Sort by:</label>
    <input type="radio" name="order_by" value="name" <?php if ($order_by == "name") echo "checked"; ?>> Language Name
    <input type="radio" name="order_by" value="language_family" <?php if ($order_by == "language_family") echo "checked"; ?>> Language Family
    <input type="radio" name="order_by" value="speakers_worldwide" <?php if ($order_by == "speakers_worldwide") echo "checked"; ?>> Global Speakers

    <label>Order:</label>
    <input type="radio" name="sort_order" value="ASC" <?php if ($sort_order == "ASC") echo "checked"; ?>> Ascending
    <input type="radio" name="sort_order" value="DESC" <?php if ($sort_order == "DESC") echo "checked"; ?>> Descending

    <input type="submit" value="Sort">
</form>

<!-- Scrollable Table Container -->
<div class="scrollable-table">
    <table>
        <tr>
            <th>Language ID</th>
            <th>Language Name</th>
            <th>Language Family</th>
            <th>Global Speakers</th>
            <th>Official Status</th>
        </tr>
        
        <!-- Fetch and display each row from the result set -->
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['languageid']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['language_family']) ?></td>
                <td><?= number_format($row['speakers_worldwide']) ?></td>
                <td><?= $row['official'] == 'Y' ? 'Can be Official' : 'Regional Only' ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php
// Free the result set to free up memory
mysqli_free_result($result);
?>

<!-- Back Button -->
<div class="back-container">
    <a href="mainmenu.php" class="back-button">Back to Main Menu</a>
</div>

</div>
</body>
</html>