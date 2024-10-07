<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Table</title>
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

        .update-btn, .delete-btn, button[type="submit"], button[type="reset"], .calculate-btn {
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .update-btn:hover, .delete-btn:hover, button[type="submit"]:hover, button[type="reset"]:hover, .calculate-btn:hover {
            background-color: #45a049;
        }

        .update-btn, .delete-btn, button[type="submit"], .calculate-btn {
            background-color: #4CAF50;
        }

        button[type="reset"] {
            background-color: #4CAF50;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        #message {
            text-align: center;
        }

        .form-container {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .form-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        <h2>Semi Processed Entry</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>GRN No</th>
                <th>Receiving Date</th>
                <th>Job Start Date</th>
                <th>Job Name</th>
                <th>Job No</th>
                <th>Out Qty</th>
                <th>Batch No</th>
                <th>Used Qty</th>
                <th>Update</th>
                <th>Delete</th>
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

            // Display data from semi table
            $sql = "SELECT * FROM semi";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["id"]."</td>";
                    echo "<td>".$row["grn"]."</td>";
                    echo "<td>".$row["receiving"]."</td>";
                    echo "<td>".$row["job_date"]."</td>";
                    echo "<td>".$row["job_name"]."</td>";
                    echo "<td>".$row["job_no"]."</td>";
                    echo "<td id='out_qty_".$row["id"]."'>".$row["out_qty"]."</td>";
                    echo "<td>".$row["batch_no"]."</td>";
                    echo "<td><input type='number' id='used_qty_".$row["id"]."' value='".$row["used_qty"]."'></td>";
                    echo "<td><button class='update-btn' onclick='updateQty(".$row["id"].")'>Update</button></td>";
                    echo "<td><button class='delete-btn' onclick='deleteRow(".$row["id"].")'>Delete</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>0 results</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>

    <div id="message"></div>

    <div class="container
    form-container">
        <div class="form-box">
            <h2>25g Packets</h2>
            <form id="form25g" onsubmit="event.preventDefault(); submitForm('form25g', 'packet1');" method="POST">
                <label for="receiving25g">Receiving Date:</label>
                <input type="date" id="receiving25g" name="receiving" required>
                <label for="used_qty25g">Used Qty:</label>
                <input type="number" id="used_qty25g" name="used_qty" required>
                <label for="num_packets25g">Number of packets:</label>
                <input type="number" id="num_packets25g" name="num_packets" required>
                <button type="submit">Submit</button>
                <button type="reset">Clear</button>
            </form>
        </div>

        <div class="form-box">
            <h2>50g Packets</h2>
            <form id="form50g" onsubmit="event.preventDefault(); submitForm('form50g', 'packet2');" method="POST">
                <label for="receiving50g">Receiving Date:</label>
                <input type="date" id="receiving50g" name="receiving" required>
                <label for="used_qty50g">Used Qty:</label>
                <input type="number" id="used_qty50g" name="used_qty" required>
                <label for="num_packets50g">Number of packets:</label>
                <input type="number" id="num_packets50g" name="num_packets" required>
                <button type="submit">Submit</button>
                <button type="reset">Clear</button>
            </form>
        </div>

        <div class="form-box">
            <h2>100g Packets</h2>
            <form id="form100g" onsubmit="event.preventDefault(); submitForm('form100g', 'packet3');" method="POST">
                <label for="receiving100g">Receiving Date:</label>
                <input type="date" id="receiving100g" name="receiving" required>
                <label for="used_qty100g">Used Qty:</label>
                <input type="number" id="used_qty100g" name="used_qty" required>
                <label for="num_packets100g">Number of packets:</label>
                <input type="number" id="num_packets100g" name="num_packets" required>
                <button type="submit">Submit</button>
                <button type="reset">Clear</button>
            </form>
        </div>
    </div>

    <script>
        function updateQty(id) {
            var usedQty = document.getElementById('used_qty_' + id).value;

            // Send data to PHP script using AJAX to update semi table
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Update the out_qty cell with the remaining quantity
                            var outQtyCell = document.getElementById('out_qty_' + id);
                            outQtyCell.textContent = response.remaining_qty;
                        } else {
                            // Handle error
                            console.error('Error:', response.message);
                        }
                    } else {
                        // Handle error
                        console.error('Error:', xhr.status, xhr.responseText);
                    }
                }
            };
            xhr.open('POST', 'update_semi.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + id + '&used_qty=' + usedQty);
        }

        function deleteRow(id) {
            if (confirm("Are you sure you want to delete this row?")) {
                // Send data to PHP script using AJAX to delete row from semi table
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Reload the page after successful deletion
                            location.reload();
                        } else {
                            // Handle error
                            console.error('Error:', xhr.status, xhr.responseText);
                        }
                    }
                };
                xhr.open('POST', 'delete_semi.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send('id=' + id);
            }
        }

        function submitForm(formId, table) {
            var formData = new FormData(document.getElementById(formId));
            formData.append('table', table);

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var message = xhr.responseText;
                        if (message === "success") {
                            // Display success message and clear form
                            document.getElementById('message').innerText = "Record added successfully.";
                            document.getElementById(formId).reset();
                        } else {
                            // Display error message
                            document.getElementById('message').innerText = message;
                        }
                    } else {
                        // Handle error
                        console.error('Error:', xhr.status, xhr.responseText);
                    }
                }
            };
            xhr.open('POST', 'add_packet.php', true);
            xhr.send(formData);
        }
    </script>
</body>
</html>
