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

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to insert data into the specified table
function insert_data($conn, $table, $receiving, $used_qty, $num_packets) {
    $receiving = sanitize_input($receiving);
    $used_qty = sanitize_input($used_qty);
    $num_packets = sanitize_input($num_packets);

    $sql = "INSERT INTO $table (receiving, used_qty, num_packets) VALUES ('$receiving', '$used_qty', '$num_packets')";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check which form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['table']) && isset($_POST['receiving']) && isset($_POST['used_qty']) && isset($_POST['num_packets'])) {
        $table = $_POST['table'];
        $receiving = $_POST['receiving'];
        $used_qty = $_POST['used_qty'];
        $num_packets = $_POST['num_packets'];

        // Insert data into the appropriate table
        switch ($table) {
            case 'packet1':
                insert_data($conn, 'packet1', $receiving, $used_qty, $num_packets);
                break;
            case 'packet2':
                insert_data($conn, 'packet2', $receiving, $used_qty, $num_packets);
                break;
            case 'packet3':
                insert_data($conn, 'packet3', $receiving, $used_qty, $num_packets);
                break;
            default:
                echo "Invalid table specified.";
        }
    } else {
        echo "Incomplete form data.";
    }
}

$conn->close();
?>
