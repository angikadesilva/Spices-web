<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "epic";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$grn = $_POST['grn'];
$receiving = $_POST['receiving'];
$job_date = $_POST['job_date'];
$job_name = $_POST['job_name'];
$job_no = $_POST['job_no'];
$batch_no = $_POST['batch_no'];
$out_qty = $_POST['out_qty'];

$sql = "INSERT INTO semi (grn, receiving, job_date, job_name, job_no, batch_no, out_qty) 
        VALUES ('$grn', '$receiving', '$job_date', '$job_name', '$job_no', '$batch_no', '$out_qty')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "New record created successfully";
} else {
    $_SESSION['message'] = "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("Location: jstock.php");
exit();
?>
