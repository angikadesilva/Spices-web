<?php
// Receive data from AJAX request
$id = $_POST['id'];

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "epic";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete the row from the semi table
$sql = "DELETE FROM semi WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    // Send success response
    echo json_encode(array("success" => true));
} else {
    // Send error response
    echo json_encode(array("success" => false, "message" => "Error deleting record: " . $conn->error));
}

// Close database connection
$conn->close();
?>
