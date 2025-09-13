<!DOCTYPE html>
<html>
<head>
    <title>Add Country</title>
    <link rel="stylesheet" type="text/css" href="mainmenu.css"> <!-- Link to CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <style>
        /* Styling for the form container */
        .scrollable-container {
            max-height: 90vh; /* Ensures it doesn't overflow the screen */
            overflow-y: auto; /* Enables scrolling if needed */
            padding: 20px;
            width: 80%;
            max-width: 600px;
            background-color: rgba(28, 16, 8, 0.9);
            border-radius: 10px;
            position: relative;
        }
    </style>
</head>
<body>

<div class="scrollable-container">
<?php
include "connecttodb.php";

// Fetch continents and languages from database
$continents_query = "SELECT continentid, name FROM continent";
$languages_query = "SELECT languageid, name, speakers_worldwide FROM language";

$continents_result = mysqli_query($connection, $continents_query);
$languages_result = mysqli_query($connection, $languages_query);

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $country_id = $_POST['country_id'];
    $country_name = $_POST['country_name'];
    $capital = $_POST['capital'];
    $continent_id = $_POST['continent_id'];
    $population = $_POST['population'];
    $area = $_POST['area'];
    $gdp = $_POST['gdp'];
    $independence_year = $_POST['independence_year'];
    $flag_url = $_POST['flag_url'];

    // Validate inputs
    if (!is_numeric($population) || $population < 0) {
        die("Error: Population must be a valid positive number.");
    }
    
    if (!is_numeric($area) || $area <= 0) {
        die("Error: Area must be a valid positive number.");
    }
    
    if (!empty($gdp) && (!is_numeric($gdp) || $gdp < 0)) {
        die("Error: GDP must be a valid positive number.");
    }
    
    if (!empty($independence_year) && (!is_numeric($independence_year) || $independence_year < 1 || $independence_year > date('Y'))) {
        die("Error: Independence year must be a valid year.");
    }

    // Check if country ID already exists
    $check_query = "SELECT * FROM country WHERE countryid = '$country_id'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        die("Error: Country ID already exists.");
    }

    // Check if country name already exists
    $check_name_query = "SELECT * FROM country WHERE name = '$country_name'";
    $check_name_result = mysqli_query($connection, $check_name_query);

    if (mysqli_num_rows($check_name_result) > 0) {
        die("Error: Country name already exists.");
    }

    // Validate language data
    $languages = $_POST['languages'];
    foreach ($languages as $languageid => $data) {
        if ($data['speakers'] > 0) {
            if (!is_numeric($data['speakers']) || $data['speakers'] < 0) {
                die("Error: Invalid number of speakers for language $languageid.");
            }
            if (!is_numeric($data['percentage']) || $data['percentage'] < 0 || $data['percentage'] > 100) {
                die("Error: Invalid percentage for language $languageid.");
            }
        }
    }

    // Insert country into database
    $gdp_value = empty($gdp) ? 'NULL' : "'$gdp'";
    $independence_value = empty($independence_year) ? 'NULL' : "'$independence_year'";
    
    $query = "INSERT INTO country (countryid, name, capital, continentid, population, area_km2, gdp_billions, independence_year, flag_url) 
              VALUES ('$country_id', '$country_name', '$capital', '$continent_id', '$population', '$area', $gdp_value, $independence_value, '$flag_url')";

    if (mysqli_query($connection, $query)) {
        echo "<h2>Country Successfully Added!</h2>";
        echo "<h3>Country Details:</h3>";
        echo "Country ID: $country_id<br>";
        echo "Name: $country_name<br>";
        echo "Capital: $capital<br>";
        echo "Population: " . number_format($population) . "<br>";
        echo "Area: " . number_format($area, 2) . " km²<br>";
        if (!empty($gdp)) echo "GDP: $" . number_format($gdp, 2) . " billion<br>";
        if (!empty($independence_year)) echo "Independence Year: $independence_year<br>";

        if (isset($_POST['languages'])) {
            echo "<h3>Languages Spoken:</h3>";
            echo "<table><tr><th>Language</th><th>Speakers</th><th>Percentage</th><th>Official</th></tr>";

            foreach ($languages as $languageid => $data) {
                if ($data['speakers'] > 0) {
                    // Get language name
                    $lang_query = "SELECT name FROM language WHERE languageid = '$languageid'";
                    $lang_result = mysqli_query($connection, $lang_query);
                    $lang_row = mysqli_fetch_assoc($lang_result);
                    $lang_name = $lang_row['name'];

                    // Insert into country_language table
                    $official_status = isset($data['official']) ? 'Y' : 'N';
                    $insert_lang_query = "INSERT INTO country_language (countryid, languageid, speakers_in_country, percentage_of_population, official_status) 
                                         VALUES ('$country_id', '$languageid', '{$data['speakers']}', '{$data['percentage']}', '$official_status')";
                    mysqli_query($connection, $insert_lang_query);

                    echo "<tr><td>$lang_name</td><td>" . number_format($data['speakers']) . "</td><td>{$data['percentage']}%</td><td>" . ($official_status == 'Y' ? 'Yes' : 'No') . "</td></tr>";
                }
            }
            echo "</table>";
        }
    } else {
        echo "Error while adding country: " . mysqli_error($connection);
    }
}
?>

    <h1>Add New Country</h1>
    <form method="post">
        Country ID: <input type="text" name="country_id" required><br>
        Country Name: <input type="text" name="country_name" required><br>
        Capital City: <input type="text" name="capital" required><br>
        
        <!-- Dropdown for selecting continent -->
        Continent: 
        <select name="continent_id" required>
            <?php while ($row = mysqli_fetch_assoc($continents_result)) { ?>
                <option value="<?php echo $row['continentid']; ?>"><?php echo $row['name']; ?></option>
            <?php } ?>
        </select><br>

        Population: <input type="number" name="population" required><br>
        Area (km²): <input type="number" step="0.01" name="area" required><br>
        GDP (billions USD): <input type="number" step="0.01" name="gdp"><br>
        Independence Year: <input type="number" name="independence_year" min="1" max="<?php echo date('Y'); ?>"><br>
        Flag URL: <input type="url" name="flag_url"><br>

        <h3>Languages Spoken in This Country</h3>
        <?php while ($row = mysqli_fetch_assoc($languages_result)) { ?>
            <fieldset style="margin: 10px 0; padding: 10px;">
                <legend><?php echo $row['name']; ?></legend>
                <label>Number of Speakers:</label>
                <input type="number" name="languages[<?php echo $row['languageid']; ?>][speakers]" min="0" value="0"><br>
                
                <label>Percentage of Population:</label>
                <input type="number" step="0.01" name="languages[<?php echo $row['languageid']; ?>][percentage]" min="0" max="100" value="0">%<br>
                
                <label>Official Language:</label>
                <input type="checkbox" name="languages[<?php echo $row['languageid']; ?>][official]"><br>
            </fieldset>
        <?php } ?>
        
        <input type="submit" value="Add Country">
    
    <!-- Back Button -->
    <div class="back-container">
        <a href="mainmenu.php" class="back-button">Back to Main Menu</a>
    </div>
    </form>

</div>
</body>
</html>