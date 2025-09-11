<?php
// Database connection parameters
$dbhost = "localhost"; // or the specific host InfinityFree provides
$dbuser = "if0_39920053";
$dbpass = "TQbyYLVL9BrLKb2"; 
$dbname = "GlobalNationsDB";

// Establish a connection to the MySQL database
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check if the connection was successful
if (!$connection) {
    // If the connection fails, terminate the script and display an error message
    die("Error: Database connection failed. " . mysqli_connect_error());
}

// Register a shutdown function to ensure the database connection is closed properly
register_shutdown_function(function() use ($connection) {
    if ($connection) {
        mysqli_close($connection); // Close the database connection at the end of the script execution
    }
});
?>
