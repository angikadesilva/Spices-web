<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Inventory</title>
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

        h2 {
            text-align: center;
            margin-bottom: 20px;
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

        form {
            display: inline-block;
        }

        input[type="number"], input[type="submit"], input[type="text"], input[type="date"] {
            padding: 5px;
            margin: 2px;
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
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        
       .view-jobfile-btn button[type="button"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
}

      .view-jobfile-btn button[type="button"]:hover {
            background-color: #45a049;
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
        <h2>Raw Material Stock Ledger</h2>
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

        // Check if form is submitted for updating stock
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['used_gross'])) {
            $id = $_POST['id'];
            $used_gross = $_POST['used_gross'];

            // Get current quantity from database
            $sql_select = "SELECT gross FROM stock WHERE id='$id'";
            $result = $conn->query($sql_select);
            $row = $result->fetch_assoc();
            $current_gross= $row["gross"];

            // Calculate remaining quantity
            $remaining_gross= $current_gross - $used_gross;

            // Update completed quantity and remaining quantity in stock table
            $sql_update = "UPDATE stock SET used_gross='$used_gross', gross='$remaining_gross' WHERE id='$id'";

            if ($conn->query($sql_update) === TRUE) {
                echo "<p>Record updated successfully</p>";
            } else {
                echo "<p>Error updating record: " . $conn->error . "</p>";
            }
        }

        // Check if form is submitted for deleting stock
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
            $id = $_POST['delete_id'];

            // Delete record from stock table
            $sql_delete = "DELETE FROM stock WHERE id='$id'";

            if ($conn->query($sql_delete) === TRUE) {
                echo "<p>Record deleted successfully</p>";
            } else {
                echo "<p>Error deleting record: " . $conn->error . "</p>";
            }
        }

        // Display data from stock table
        $sql = "SELECT * FROM stock";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>GRN No</th><th>Description</th><th>Net Gross(KG)</th><th>Used Gross(KG)</th><th>Actions</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["Grn"]."</td><td>".$row["dess"]."</td><td>".$row["gross"]."</td>";
                echo "<td><form method='post' action=''>
                        <input type='hidden' name='id' value='".$row["id"]."'>
                        <input type='number' name='used_gross' value='".$row["used_gross"]."' min='0' max='".$row["gross"]."'>
                        <input type='submit' value='Update'>
                      </form></td>";
                echo "<td><form method='post' action=''>
                        <input type='hidden' name='delete_id' value='".$row["id"]."'>
                        <input type='submit' value='Delete'>
                      </form></td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        ?>
    </div>

    <div class="container">
        <h2>Job Card Register</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="grn_no">GRN No:</label>
            <input type="text" id="grn_no" name="grn_no" required><br>

            <label for="rdate">Receiving Date:</label>
            <input type="date" id="rdate" name="rdate" required><br>

            <label for="job_date">Job Start Date:</label>
            <input type="date" id="job_date" name="job_date" required><br>

            <label for="product">Product Name:</label>
            <input type="text" id="product" name="product" required><br>

            <label for="Job_name">Job Name:</label>
            <input type="text" id="Job_name" name="Job_name" required><br>

            <label for="used">Used Gross:</label>
            <input type="text" id="used" name="used" required><br>

            <label for="job_no">Job No:</label>
            <input type="text" id="job_no" name="job_no" required><br>

            <label for="batch_no">Batch No:</label>
            <input type="text" id="batch_no" name="batch_no" required><br>

            <label for="out">Out Product:</label>
            <input type="text" id="out" name="out" required><br>

            <label for="qty">Out Qty:</label>
            <input type="text" id="qty" name="qty" required><br>

            <input type="submit" value="Submit">
            <a href="jobfile.php" class="view-jobfile-btn"><button type="button">View Jobfile</button></a>

        </form>
        <?php
        // Check if form is submitted for Job Card Register
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['grn_no'])) {
            // Check if all form fields are set
            if (isset($_POST['grn_no'], $_POST['rdate'], $_POST['job_date'], $_POST['product'], $_POST['Job_name'], $_POST['used'], $_POST['job_no'], $_POST['batch_no'], $_POST['out'], $_POST['qty'])) {
                // Retrieve form data
                $grn_no = $_POST['grn_no'];
                $rdate = $_POST['rdate'];
                $job_date = $_POST['job_date'];
                $product = $_POST['product'];
                $Job_name = $_POST['Job_name'];
                $used = $_POST['used'];
                $job_no = $_POST['job_no'];
                $batch_no = $_POST['batch_no'];
                $out = $_POST['out'];
                $qty = $_POST['qty'];

                // Insert data into processing table
                $sql_processing = "INSERT INTO processing(grn, receiving, job_date, product_name, job_name, used_gross, job_no, batch_no, out_product, out_qty) VALUES
                         ('$grn_no', '$rdate', '$job_date', '$product', '$Job_name', '$used', '$job_no', '$batch_no', '$out', '$qty')";

                if ($conn->query($sql_processing) === TRUE) {
                    echo "<p>New record created successfully</p>";

                    // Insert data into jobfile table
                    $sql_jobfile = "INSERT INTO jobfile(grn, receiving, job_date, job_name, job_no, out_product, out_qty) VALUES
                             ('$grn_no', '$rdate', '$job_date', '$Job_name', '$job_no', '$out', '$qty')";

                    if ($conn->query($sql_jobfile) === TRUE) {
                        echo "<p>Data saved in jobfile table successfully</p>";
                    } else {
                        echo "<p>Error: " . $conn->error . "</p>";
                    }
                } else {
                    echo "<p>Error: " . $conn->error . "</p>";
                }
            } else {
                echo "<p>All fields are required!</p>";
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
