<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raw Material Receiving Table</title>
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
        table td#dispatch,
        table td#received {
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
    <h2>Raw Material Receiving Table</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>GRN No</th>
            <th>Dispatch</th>
            <th>Vehicle</th>
            <th>Hand</th>
            <th>Receiving Date</th>
            <th>Mobile No</th>
            <th>Security Clearance</th>
            <th>Received</th>
            <th>Description</th>
            <th>Designation</th>
            <th>Unit</th>
            <th>Gross Weight</th>
            <th>Value</th>
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

        // Display data from receiving table
        $sql = "SELECT * FROM receiving";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["Grn_no"]."</td>";
                echo "<td id='dispatch'>".$row["dispatch"]."</td>";
                echo "<td>".$row["vehicle"]."</td>";
                echo "<td>".$row["hand"]."</td>";
                echo "<td>".$row["rdate"]."</td>";
                echo "<td>".$row["mobile"]."</td>";
                echo "<td>".$row["csecurity"]."</td>";
                echo "<td id='received'>".$row["received"]."</td>";
                echo "<td>".$row["dess"]."</td>";
                echo "<td>".$row["d"]."</td>";
                echo "<td>".$row["unit"]."</td>";
                echo "<td>".$row["gross"]."</td>";
                echo "<td>".$row["gvalue"]."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='14'>0 results</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</div>
</body>
</html>
