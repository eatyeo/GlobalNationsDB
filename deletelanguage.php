<!DOCTYPE html>
<html>
<head>
    <title>Delete Language</title>
    
    <!-- Link to external CSS file for styling -->
    <link rel="stylesheet" type="text/css" href="mainmenu.css">
    
    <!-- Google Font for styling -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
<?php
// Include the database connection file
include "connecttodb.php";

// Function to display all languages
function showLanguagesDropdown($connection) {
    // Query to retrieve all languages
    $query = "SELECT * FROM language";
    $result = mysqli_query($connection, $query);

    // Check if the query was successful
    if ($result === false) {
        echo "Error: Unable to execute query to retrieve languages. Error: " . mysqli_error($connection);
        return;
    }

    // Check if any languages exist in the database
    if (mysqli_num_rows($result) == 0) {
        echo "No languages available to delete.";
        return;
    }

    // Display the dropdown menu for selecting a language to delete
    echo "<h2>Select Language to Delete</h2>";
    echo "<form method='post'>";
    echo "<select name='language_id' required>";
    echo "<option value='' disabled selected>Select a Language</option>";

    // Populate dropdown options with language names
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . htmlspecialchars($row['languageid']) . "'>" . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['language_family']) . " - " . number_format($row['speakers_worldwide']) . " speakers)</option>";
    }

    echo "</select><br>";
    echo "<input type='submit' value='Delete Language'>";
    echo "</form>";

    // Free up the memory used by the query result
    mysqli_free_result($result);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['language_id']) && !empty($_POST['language_id'])) {
        $languageid = $_POST['language_id'];  // Get selected language ID

        // Check if the language exists in the database
        $check_lang_query = "SELECT * FROM language WHERE languageid = '$languageid'";
        $check_lang_result = mysqli_query($connection, $check_lang_query);

        if ($check_lang_result === false) {
            echo "Error: Unable to execute query to check for language.";
            exit;
        }

        // If no matching language is found, display an error message
        if (mysqli_num_rows($check_lang_result) == 0) {
            echo "Error: Language with ID '$languageid' does not exist.";
            mysqli_free_result($check_lang_result);
            exit;
        }

        // Get language name for display
        $language_row = mysqli_fetch_assoc($check_lang_result);
        $language_name = $language_row['name'];
        mysqli_free_result($check_lang_result);

        // Check if the language is used in any country-language relationships
        $check_usage_query = "SELECT * FROM country_language WHERE languageid = '$languageid'";
        $check_usage_result = mysqli_query($connection, $check_usage_query);

        if ($check_usage_result === false) {
            echo "Error: Unable to execute query to check for language usage.";
            exit;
        }

        // If the language is linked to countries, prevent deletion
        if (mysqli_num_rows($check_usage_result) > 0) {
            $usage_count = mysqli_num_rows($check_usage_result);
            echo "Error: Cannot delete '$language_name' as it is spoken in $usage_count country/countries. Please remove it from country records first.";
            mysqli_free_result($check_usage_result);
            exit;
        }

        mysqli_free_result($check_usage_result);

        // Prompt for confirmation before deleting
        if (isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
            // Execute delete query if user confirms
            $delete_query = "DELETE FROM language WHERE languageid = '$languageid'";

            if (mysqli_query($connection, $delete_query)) {
                echo "Language '$language_name' (ID: $languageid) successfully deleted!";
            } else {
                echo "Error: Failed to delete the language. Please try again later.";
            }
        } else if (isset($_POST['confirm']) && $_POST['confirm'] == 'no') {
            // If user cancels deletion
            echo "Deletion cancelled.";
        } else {
            // Display confirmation prompt before deleting
            echo "<form method='post'>
                    <h3>Confirm Deletion</h3>
                    <p>Are you sure you want to delete the language '<strong>$language_name</strong>' (ID: $languageid)?</p>
                    <p><strong>Warning:</strong> This action cannot be undone!</p>
                    <input type='hidden' name='language_id' value='$languageid'>
                    <input type='submit' name='confirm' value='yes' style='background-color: #d32f2f;'> 
                    <input type='submit' name='confirm' value='no' style='background-color: #388e3c;'>
                  </form>";
            exit;
        }
    }
} else {
    // If no form submission, display the language dropdown
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