<!DOCTYPE html>
<html>
<head>
    <title>Edit Language Information</title>
    
    <!-- Link to external CSS for styling -->
    <link rel="stylesheet" type="text/css" href="mainmenu.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <script>
        // JavaScript function to validate form input before submission
        function validateForm() {
            var speakers = document.forms["editForm"]["new_speakers"].value;
            var family = document.forms["editForm"]["new_family"].value;

            // Check if speakers is a valid number and greater than 0
            if (isNaN(speakers) || speakers <= 0) {
                alert("Please enter a valid number of speakers greater than 0.");
                return false;
            }

            // Check if language family is not empty
            if (family.trim() === "") {
                alert("Please enter a language family.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

<div class="container">
<?php
// Include the database connection file
include "connecttodb.php";

// Function to display all languages in a dropdown
function showLanguagesDropdown($connection) {
    // Query to get all languages from the database
    $query = "SELECT * FROM language";
    $result = mysqli_query($connection, $query);

    // Check if the query was successful
    if ($result === false) {
        echo "Error: Unable to execute query to retrieve languages. Error: " . mysqli_error($connection);
        return;
    }

    // Check if any rows are returned
    if (mysqli_num_rows($result) == 0) {
        echo "No languages available.";
        return;
    }

    // Display the dropdown form to select a language
    echo "<h2>Select Language to Edit</h2>";
    echo "<form name='editForm' method='post' onsubmit='return validateForm()'>";
    echo "<select name='language_id' required>";
    echo "<option value='' disabled selected>Select a Language</option>";

    // Loop through all languages and add them to the dropdown list
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . htmlspecialchars($row['languageid']) . "'>" . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['language_family']) . ")</option>";
    }

    echo "</select><br>";
    // Input field for new language family
    echo "New Language Family: <input type='text' name='new_family' required><br>";
    // Input field for new global speakers count
    echo "New Global Speakers: <input type='text' name='new_speakers' required><br>";
    // Checkbox for official language status
    echo "Can be Official Language: <input type='checkbox' name='official_status' value='Y'><br>";
    // Submit button
    echo "<input type='submit' value='Update Language'>";
    echo "</form>";

    // Free the result after use
    mysqli_free_result($result);
}

// Check if form is submitted via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $language_id = $_POST['language_id'];
    $new_family = $_POST['new_family'];
    $new_speakers = $_POST['new_speakers'];
    $official_status = isset($_POST['official_status']) ? 'Y' : 'N';

    // Server-side validation of inputs
    if (!is_numeric($new_speakers) || $new_speakers <= 0) {
        echo "<p>Error: Global speakers must be a valid number greater than 0.</p>";
    } elseif (trim($new_family) === "") {
        echo "<p>Error: Language family cannot be empty.</p>";
    } else {
        // Sanitize input to avoid SQL injection attacks
        $language_id = mysqli_real_escape_string($connection, $language_id);
        $new_family = mysqli_real_escape_string($connection, $new_family);
        $new_speakers = mysqli_real_escape_string($connection, $new_speakers);

        // Get the current language name for display
        $name_query = "SELECT name FROM language WHERE languageid = '$language_id'";
        $name_result = mysqli_query($connection, $name_query);
        $language_name = mysqli_fetch_assoc($name_result)['name'];

        // Update the language in the database
        $query = "UPDATE language SET language_family = '$new_family', speakers_worldwide = '$new_speakers', official = '$official_status' WHERE languageid = '$language_id'";

        if (mysqli_query($connection, $query)) {
            echo "<p>Language '$language_name' successfully updated!</p>";
            echo "<p>New Language Family: $new_family</p>";
            echo "<p>New Global Speakers: " . number_format($new_speakers) . "</p>";
            echo "<p>Official Language Status: " . ($official_status == 'Y' ? 'Yes' : 'No') . "</p>";
        } else {
            echo "<p>Error: Failed to update the language. Please check your input and try again.</p>";
        }
    }
} else {
    // Display the dropdown to select a language if no POST request is made
    showLanguagesDropdown($connection);
}
?>

<!-- Back Button -->
<div class="back-container">
    <a href="mainmenu.php" class="back-button">Back to Main Menu</a>
</div>    

</div>
</body>
</html>