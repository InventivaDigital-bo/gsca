<?php
$servername = "104.131.56.51";
$database = "bdChery";
$username = "chery";
$password = "vFQE0cFBG5lFOe9x";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
mysqli_close($conn);
?>