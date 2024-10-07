<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Cards</title>
    <style>
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: lightgray;
            z-index: 2;
            position: relative;
        }
        .logo {
            display: flex;
            align-items: center;
            margin-left: 10px;
        }

        .epic {
            font-size: 24px;
            color: Black;
        }

        .dot {
            color: #28a745;
            font-size: xx-large;
        }
        .navbar {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .navbar a {
            padding: 10px 20px;
            font-size: 20px;
            color: black;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .navbar a:hover {
            color: rgba(255, 255, 255, 0.7);
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2{
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }
        table td#out_product,
        table td#out_qty {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>
<header>
    <div class="logo">
        <span class="epic">Epic<span class="dot">.</span>Green</span>
    </div>
    <nav class="navbar">
        <a href="index.html">Home</a>
        <a href="raw_material.php">Raw Material</a>
        <a href="job_card.php">Jobcard</a>
        <a href="job_file.php">Jobfile</a>
        <a href="semi.php">Semi Processed Goods</a>
        <a href="packages.php">Package</a>
    </nav>
</header>
<div class="container">
    <h2>Job Cards</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>GRN</th>
            <th>Receiving</th>
            <th>Job Date</th>
            <th>Product Name</th>
            <th>Job Name</th>
            <th>Used Gross</th>
            <th>Job No</th>
            <th>Batch No</th>
            <th>Out Product</th>
            <th>Out Quantity</th>
        </tr>
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

        // Display data from processing table
        $sql = "SELECT * FROM processing";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["grn"]."</td>";
                echo "<td>".$row["receiving"]."</td>";
                echo "<td>".$row["job_date"]."</td>";
                echo "<td>".$row["product_name"]."</td>";
                echo "<td>".$row["job_name"]."</td>";
                echo "<td>".$row["used_gross"]."</td>";
                echo "<td>".$row["job_no"]."</td>";
                echo "<td>".$row["batch_no"]."</td>";
                echo "<td id='out_product'>".$row["out_product"]."</td>";
                echo "<td id='out_qty'>".$row["out_qty"]."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11'>0 results</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</div>
</body>
</html>
