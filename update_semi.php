<?php
// Receive data from AJAX request
$id = $_POST['id'];
$usedQty = $_POST['used_qty'];

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

// Calculate remaining quantity
$sql = "SELECT out_qty FROM semi WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $outQty = $row['out_qty'];
    $remainingQty = $outQty - $usedQty;

    // Update the semi table with the new remaining quantity
    $updateSql = "UPDATE semi SET used_qty = $usedQty, out_qty = $remainingQty WHERE id = $id";
    if ($conn->query($updateSql) === TRUE) {
        // Send success response with remaining quantity
        echo json_encode(array("success" => true, "remaining_qty" => $remainingQty));
    } else {
        // Send error response
        echo json_encode(array("success" => false, "message" => "Error updating record: " . $conn->error));
    }
} else {
    // Send error response
    echo json_encode(array("success" => false, "message" => "Record not found."));
}

// Close database connection
$conn->close();
?>
