<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Get the posted data
$id = $_POST['id'];

// Validate received data
if(empty($id)) {
    echo "ID is required.";
    exit();
}

// Prepare and bind
$stmt = $conn->prepare("DELETE FROM jobfile WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
