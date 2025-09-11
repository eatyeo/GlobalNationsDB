<!DOCTYPE html>
<html>
<head>
    <title>Countries of the World - Main Menu</title>
    
    <!-- Importing Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    
    <!-- Linking external CSS file for styling -->
    <link rel="stylesheet" type="text/css" href="mainmenu.css">
</head>
<body>

<?php
    include "connecttodb.php";
?>

<!-- Container to center the content and apply styling -->
<div class="container">
    <p>&nbsp;</p>
    
    <!-- Table to structure the menu and image side by side -->
    <table style="border-collapse: collapse; width: 100%;" border="0">
        <tbody>
            <tr>
                <!-- Left column: Menu with links to different functionalities -->
                <td style="width: 50%; vertical-align: top; padding-right: 10px;">
                    <h1>Countries Database</h1>
                    <ul>
                        <li><a href="showlanguages.php">View All Languages</a></li> <!-- View all languages -->
                        <li><a href="addcountry.php">Add New Country</a></li> <!-- Add a new country -->
                        <li><a href="deletelanguage.php">Delete Language</a></li> <!-- Remove a language -->
                        <li><a href="editlanguage.php">Edit Language Info</a></li> <!-- Edit existing language -->
                        <li><a href="displaycontinents.php">Continents with No Countries</a></li>
                        <li><a href="selectcountry.php">View Country Details</a></li> <!-- Select and view country info -->
                    </ul>
                </td>
                <!-- Right column: Globe/World image -->
                <td style="width: 50%; vertical-align: top; padding-left: 10px;">
                    <img src="https://cdn-icons-png.flaticon.com/512/814/814513.png" width="226" height="270" style="margin-top: 55px;" alt="World Globe" />
                </td>
            </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
</div>

</body>
</html>