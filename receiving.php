<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product to Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
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
            font-size:xx-large; 
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

        label {
            display: inline-block;
            width: 150px;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="date"] {
            width: 250px;
            padding: 5px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Styling for View Processing button */
        a button[type="button"] {
            padding: 10px 20px;
            background-color: #4CAF50; /* Green */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin-top: 10px;
        }

        a button[type="button"]:hover {
            background-color: #45a049; /* Darker Green */
        }

        .message {
            text-align: center;
            color: black;
            margin-top: 20px;
            margin-bottom: 10px;
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
            background-color: #f2f2f2;
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
            <a href="receiving.php">Goods Receiving</a>
            <a href="processing.php">Raw Material Stock</a>
            <a href="jobfile.php">Jobfile</a>
            <a href="jstock.php">Semi Processed Goods</a>
            <a href="package.php">Package</a>
            <a href="admin.php" class="admin-link">Admin</a>
        </nav>
    </header>
    <div class="container">
        <h2>Goods Receiving Note</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="grn_no">GRN No:</label>
            <input type="text" id="grn_no" name="grn_no" required><br>

            <label for="dispatch">Dispatch No:</label>
            <input type="text" id="dispatch" name="dispatch" required><br>

            <label for="vehicle">Vehicle No:</label>
            <input type="text" id="vehicle" name="vehicle" required><br>

            <label for="hand">Handover Person Name:</label>
            <input type="text" id="hand" name="hand" required><br>

            <label for="date">Received Date:</label>
            <input type="date" id="date" name="date" required><br>

            <label for="mobile">Mobile No:</label>
            <input type="text" id="mobile" name="mobile" required><br>

            <label for="security">Security Clearance:</label>
            <input type="text" id="security" name="security" required><br>

            <label for="received">Received person Name:</label>
            <input type="text" id="received" name="received" required><br>

            <label for="des">Designation:</label>
            <input type="text" id="des" name="des" required><br>

            <label for="d">Description:</label>
            <input type="text" id="d" name="d" required><br>

            <label for="unit">No of units:</label>
            <input type="text" id="unit" name="unit" required><br>

            <label for="gross">Gross weight:</label>
            <input type="text" id="gross" name="gross" required><br>

            <label for="value">Value:</label>
            <input type="text" id="value" name="value" required><br>

            <input type="submit" value="Submit">
            <a href="processing.php"><button type="button">View Processing</button></a>
        </form>
    </div>

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

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if all form fields are set
        if(isset($_POST['grn_no'], $_POST['dispatch'], $_POST['vehicle'], $_POST['hand'], $_POST['date'],$_POST['mobile'], $_POST['security'], $_POST['received'], $_POST['des'], $_POST['d'],$_POST['unit'], $_POST['gross'], $_POST['value'])){
            // Retrieve form data
            $grn_no = $_POST['grn_no'];
            $dispatch = $_POST['dispatch'];
            $vehicle = $_POST['vehicle'];
            $hand = $_POST['hand'];
            $date = $_POST['date'];
            $mobile = $_POST['mobile'];
            $security = $_POST['security'];
            $received = $_POST['received'];
            $des = $_POST['des'];
            $d = $_POST['d'];
            $unit = $_POST['unit'];
            $gross = $_POST['gross'];
            $value = $_POST['value'];

            // Insert data into receiving table
            $sql_receiving = "INSERT INTO receiving (Grn_no, dispatch, vehicle, hand, rdate, mobile, csecurity, received, dess, d, unit, gross, gvalue)
                    VALUES ('$grn_no', '$dispatch', '$vehicle', '$hand', '$date', '$mobile', '$security', '$received', '$des', '$d', '$unit', '$gross', '$value')";

            // Insert data into stock table
            $sql_stock = "INSERT INTO stock (Grn, dess, gross) 
                    VALUES ('$grn_no', '$d', '$gross')";

            if ($conn->query($sql_receiving) === TRUE && $conn->query($sql_stock) === TRUE) {
                echo "<div class='message'>New record created successfully</div>";
            } else {
                echo "<p>Error: " . $sql_receiving . "<br>" . $conn->error . "</p>";
                echo "<p>Error: " . $sql_stock . "<br>" . $conn->error . "</p>";
            }
        } else {
            echo "<p>All fields are required!</p>";
        }
    }

    $conn->close();
    ?>
</body>
</html>
