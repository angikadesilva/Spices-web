<?php
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

$id = $_POST['id'];
$usedQty = $_POST['used_qty'];

// Retrieve current out_qty
$sqlSelect = "SELECT out_qty FROM jstock WHERE id = $id";
$resultSelect = $conn->query($sqlSelect);

if ($resultSelect->num_rows > 0) {
    $row = $resultSelect->fetch_assoc();
    $outQty = $row['out_qty'];

    // Calculate new out_qty after subtracting used_qty
    $newOutQty = $outQty - $usedQty;

    // Update out_qty in the database
    $sqlUpdate = "UPDATE jstock SET out_qty = $newOutQty WHERE id = $id";

    if ($conn->query($sqlUpdate) === TRUE) {
        // Return the updated out_qty
        echo json_encode(array('success' => true, 'out_qty' => $newOutQty));
    } else {
        echo json_encode(array('success' => false));
    }
} else {
    echo json_encode(array('success' => false));
}

$conn->close();
?>
