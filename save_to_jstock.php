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

// Get the data sent via POST
$grn = $_POST['grn'];
$receiving = $_POST['receiving'];
$job_date = $_POST['job_date'];
$job_name = $_POST['job_name'];
$job_no = $_POST['job_no'];
$out_product = $_POST['out_product'];
$out_qty = $_POST['out_qty'];
$used_qty = $_POST['used_qty'];

// Insert data into jstock table
$sql = "INSERT INTO jstock (grn, receiving, job_date, job_name, job_no, out_product, out_qty, used_qty) VALUES ('$grn', '$receiving', '$job_date', '$job_name', '$job_no', '$out_product', '$out_qty', '$used_qty')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
