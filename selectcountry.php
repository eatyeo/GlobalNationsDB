<!DOCTYPE html>
<html>
<head>
    <title>Country Details</title>
    
    <!-- Link to external CSS file for styling -->
    <link rel="stylesheet" type="text/css" href="mainmenu.css">
    
    <!-- Google Font for styling -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <style>
        .flag-display {
            max-width: 200px;
            max-height: 120px;
            margin: 10px 0;
            border: 2px solid #ccc;
        }
        .country-details {
            background-color: rgba(43, 43, 43, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #2b2b2b;
        }
    </style>
</head>
<body>

<div class="container">
<?php
// Include the database connection file
include "connecttodb.php";

// Function to display all countries in a dropdown
function showCountryDropdown($connection) {
    // Query to retrieve all countries with their continent info
    $query = "SELECT c.countryid, c.name, cont.name as continent_name 
              FROM country c 
              JOIN continent cont ON c.continentid = cont.continentid 
              ORDER BY c.name";
    $result = mysqli_query($connection, $query);

    // Check if the query was successful
    if ($result === false) {
        echo "Error: Unable to execute query to retrieve countries. Error: " . mysqli_error($connection);
        return;
    }

    // Check if any countries exist in the database
    if (mysqli_num_rows($result) == 0) {
        echo "No countries available.";
        return;
    }

    // Display the dropdown menu for selecting a country
    echo "<h2>Select Country to View Details</h2>";
    echo "<form method='get'>";
    echo "<select name='country_id' required>";
    echo "<option value='' disabled selected>Select a Country</option>";

    // Populate dropdown options with country names
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . htmlspecialchars($row['countryid']) . "'>" . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['continent_name']) . ")</option>";
    }

    echo "</select><br>";
    echo "<input type='submit' value='View Country Details'>";
    echo "</form>";

    // Free up the memory used by the query result
    mysqli_free_result($result);
}

// Check if the user has submitted a country ID to view its details
if (isset($_GET['country_id'])) {
    $country_id = $_GET['country_id']; // Get the selected country ID

    // Query to fetch country details with continent info
    $query = "SELECT c.name, c.capital, c.population, c.area_km2, c.gdp_billions, 
                     c.independence_year, c.flag_url, cont.name AS continent_name
              FROM country c
              JOIN continent cont ON c.continentid = cont.continentid
              WHERE c.countryid = '$country_id'";

    $result = mysqli_query($connection, $query);

    // Check if the query executed successfully
    if (!$result) {
        die("Database query failed: " . mysqli_error($connection));
    }

    // Fetch the country details
    $country = mysqli_fetch_assoc($result);

    if ($country) {
        // Display country details if a matching country is found
        echo "<div class='country-details'>";
        echo "<h1>Country Details: " . htmlspecialchars($country['name']) . "</h1>";
        
        // Display flag if URL is provided
        if (!empty($country['flag_url'])) {
            echo "<img src='" . htmlspecialchars($country['flag_url']) . "' alt='Flag of " . htmlspecialchars($country['name']) . "' class='flag-display'><br>";
        }
        
        echo "<p><strong>Capital:</strong> " . htmlspecialchars($country['capital']) . "</p>";
        echo "<p><strong>Continent:</strong> " . htmlspecialchars($country['continent_name']) . "</p>";
        echo "<p><strong>Population:</strong> " . number_format($country['population']) . "</p>";
        echo "<p><strong>Area:</strong> " . number_format($country['area_km2'], 2) . " km²</p>";
        
        if (!empty($country['gdp_billions'])) {
            echo "<p><strong>GDP:</strong> $" . number_format($country['gdp_billions'], 2) . " billion USD</p>";
        }
        
        if (!empty($country['independence_year'])) {
            echo "<p><strong>Independence Year:</strong> " . $country['independence_year'] . "</p>";
        }
        echo "</div>";

        // Query to get languages spoken in this country
        $lang_query = "SELECT l.name, cl.speakers_in_country, cl.percentage_of_population, cl.official_status
                       FROM country_language cl
                       JOIN language l ON cl.languageid = l.languageid
                       WHERE cl.countryid = '$country_id'
                       ORDER BY cl.percentage_of_population DESC";
        
        $lang_result = mysqli_query($connection, $lang_query);

        if ($lang_result && mysqli_num_rows($lang_result) > 0) {
            echo "<h3>Languages Spoken</h3>";
            echo "<table>";
            echo "<tr><th>Language</th><th>Speakers</th><th>% of Population</th><th>Official Status</th></tr>";
            
            while ($lang_row = mysqli_fetch_assoc($lang_result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($lang_row['name']) . "</td>";
                echo "<td>" . number_format($lang_row['speakers_in_country']) . "</td>";
                echo "<td>" . $lang_row['percentage_of_population'] . "%</td>";
                echo "<td>" . ($lang_row['official_status'] == 'Y' ? 'Official' : 'Not Official') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            mysqli_free_result($lang_result);
        } else {
            echo "<p>No language data available for this country.</p>";
        }

    } else {
        // Display a message if no country is found with the given ID
        echo "<p>No country found with that ID.</p>";
    }
} else {
    // If no country is selected, display the country selection dropdown
    showCountryDropdown($connection);
}
?>
    
<!-- Back Button -->
<div class="back-container">
    <a href="mainmenu.php" class="back-button">Back to Main Menu</a>
</div>

</div>  
</body>
</html>