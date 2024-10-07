<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semi Processed Goods</title>
    <style>
        /* Your existing CSS styles */
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

        th {
            background-color: #4CAF50;
            color: white;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .print-btn, .action-btn {
            display: block;
            width: 100px;
            margin: 5px auto;
            padding: 5px;
            text-align: center;
            cursor: pointer;
            border-radius: 5px;
            color: white;
            border: none;
        }

        .print-btn {
            background-color: #28a745; /* Green background */
        }
        
        .print-btn:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .action-btn {
            background-color: #28a745; /* Blue background */
        }
        
        .action-btn:hover {
            background-color: #218838; /* Darker blue on hover */
        }

        .success-message {
            color: green;
            text-align: center;
        }

        /* CSS styles for the form */
        .form-container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-group button {
            display: block;
            width: 100px;
            margin: 10px auto;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .form-group button:hover {
            background-color: #218838;
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
    <h2>Semi Processed Goods Ledger</h2>
    
    <?php
    if (isset($_SESSION['message'])) {
        echo "<p class='success-message'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
    }
    ?>
    
    <table>
        <tr>
            <th>GRN No</th>
            <th>Receiving Date</th>
            <th>Job Start Date</th>
            <th>Job Name</th>
            <th>Job No</th>
            <th>Out Product</th>
            <th>Out Qty</th>
            <th>Used Qty</th>
            <th>Actions</th>
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

        // Display data from jstock table
        $sql = "SELECT * FROM jstock";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr id='row_" . $row["id"] . "'>";
                echo "<td>" . $row["grn"] . "</td>";
                echo "<td>" . $row["receiving"] . "</td>";
                echo "<td>" . $row["job_date"] . "</td>";
                echo "<td>" . $row["job_name"] . "</td>";
                echo "<td>" . $row["job_no"] . "</td>";
                echo "<td>" . $row["out_product"] . "</td>";
                echo "<td id='out_qty_" . $row["id"] . "'>" . $row["out_qty"] . "</td>";
                echo "<td><input type='number' id='used_qty_" . $row["id"] . "'></td>"; // Input for used_qty
                echo "<td>";
                echo "<button class='action-btn' onclick='updateQty(" . $row["id"] . ")'>Update</button> ";
                echo "<button class='action-btn' style='background-color: green;' onclick='deleteRow(" . $row["id"] . ")'>Delete</button>"; // Delete button
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>0 results</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</div>

<!-- Form for adding new semi-processed goods -->
<div class="form-container">
    <h2>Semi Processed Goods Form</h2>
    <form action="add_semi.php" method="post">
        <div class="form-group">
            <label for="grn">GRN No</label>
            <input type="text" id="grn" name="grn" required>
        </div>
        <div class="form-group">
            <label for="receiving">Receiving Date</label>
            <input type="date" id="receiving" name="receiving" required>
        </div>
        <div class="form-group">
            <label for="job_date">Job Start Date</label>
            <input type="date" id="job_date" name="job_date" required>
        </div>
        <div class="form-group">
            <label for="job_name">Job Name</label>
            <input type="text" id="job_name" name="job_name" required>
        </div>
        <div class="form-group">
            <label for="job_no">Job No</label>
            <input type="text" id="job_no" name="job_no" required>
        </div>
        <div class="form-group">
            <label for="batch_no">Batch no</label>
            <input type="text" id="batch_no" name="batch_no" required>
        </div>
        <div class="form-group">
            <label for="out_qty">Out Qty</label>
            <input type="number" id="out_qty" name="out_qty" required>
        </div>
        <div class="form-group">
            <button type="submit">Submit</button>
            <button type="button" class="view-package-btn" onclick="window.location.href='package.php'">View Package</button>
        </div>
        </div>
    </form>
</div>

<!-- JavaScript function -->
<script>
    function updateQty(id) {
        var usedQtyInput = document.getElementById('used_qty_' + id);
        var usedQty = usedQtyInput.value;

        // Send data to PHP script using AJAX to update out_qty
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Update out_qty in the table
                        var outQtyCell = document.getElementById('out_qty_' + id);
                        outQtyCell.textContent = response.out_qty;
                       
                        // Clear the usedQtyInput field
                        usedQtyInput.value = '';
                    } else {
                        alert('Failed to update quantity.');
                    }
                } else {
                    alert('Error: ' + xhr.status);
                }
            }
        };
        xhr.open('POST', 'update_qty.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('id=' + id + '&used_qty=' + usedQty);
    }

    function deleteRow(id) {
        if (confirm('Are you sure you want to delete this row?')) {
            // Send data to PHP script using AJAX to delete row from jstock table
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Remove the row from the table
                            var row = document.getElementById('row_' + id);
                            row.parentNode.removeChild(row);
                            alert('Row deleted successfully.');
                        } else {
                            alert('Failed to delete row.');
                        }
                    } else {
                        alert('Error: ' + xhr.status);
                    }
                }
            };
            xhr.open('POST', 'delete_row.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + id);
        }
    }
</script>
</body>
</html>
