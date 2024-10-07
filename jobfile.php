<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job File</title>
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

        th {
            background-color: #4CAF50;
            color: white;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .print-btn, .action-btn, .save-btn {
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

        .save-btn {
            background-color: #28a745; /* Green background for save button */
        }
        
        .save-btn:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .success-message {
            color: green;
            text-align: center;
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
        <h2>Job File</h2>
        <table>
            <tr>
                <th>GRN No</th>
                <th>Receiving Date</th>
                <th>Job Start Date</th>
                <th>Job Name</th>
                <th>Job No</th>
                <th>Out Product</th>
                <th>Out Qty</th>
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

            // Display data from jobfile table
            $sql = "SELECT * FROM jobfile";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr id='row_" . $row['id'] . "'>";
                    echo "<td>".$row["grn"]."</td>";
                    echo "<td>".$row["receiving"]."</td>";
                    echo "<td>".$row["job_date"]."</td>";
                    echo "<td>".$row["job_name"]."</td>";
                    echo "<td>".$row["job_no"]."</td>";
                    echo "<td>".$row["out_product"]."</td>";
                    echo "<td>".$row["out_qty"]."</td>";
                    echo "<td>";
                    echo "<button class='action-btn' onclick='markCompleted(".$row["id"].")'>Completed</button>";
                    echo "<button class='print-btn' onclick='printTableRow(".$row["id"].")'>Print</button>";
                    echo "<button class='save-btn' onclick='saveRow(".$row["id"].")'>Save</button>"; // Added Save button
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>0 results</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>

    <!-- JavaScript function -->
    <script>
        function saveRow(id) {
            var row = document.getElementById('row_' + id);
            var cells = row.getElementsByTagName('td');
            
            var grn = cells[0].innerText;
            var receiving = cells[1].innerText;
            var job_date = cells[2].innerText;
            var job_name = cells[3].innerText;
            var job_no = cells[4].innerText;
            var out_product = cells[5].innerText;
            var out_qty = cells[6].innerText;
            var used_qty = cells[7].innerText; // Add used_qty value

            // Send data to PHP script using AJAX to save it in jstock table
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert('Row successfully saved to jstock table.');
                    } else {
                        // Handle error
                        console.error('Error:', xhr.status, xhr.responseText);
                    }
                }
            };
            xhr.open('POST', 'save_to_jstock.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('grn=' + encodeURIComponent(grn) +
                     '&receiving=' + encodeURIComponent(receiving) +
                     '&job_date=' + encodeURIComponent(job_date) +
                     '&job_name=' + encodeURIComponent(job_name) +
                     '&job_no=' + encodeURIComponent(job_no) +
                     '&out_product=' + encodeURIComponent(out_product) +
                     '&out_qty=' + encodeURIComponent(out_qty) +
                     '&used_qty=' + encodeURIComponent(used_qty)); // Include used_qty in the request
        }

        function markCompleted(id) {
            var row = document.getElementById("row_" + id);
            var cells = row.getElementsByTagName('td');

            var grn = cells[0].innerText;
            var receiving = cells[1].innerText;
            var job_date = cells[2].innerText;
            var job_name = cells[3].innerText;
            var job_no = cells[4].innerText;
            var out_product = cells[5].innerText;
            var out_qty = cells[6].innerText;
            var used_qty = cells[7].innerText; // Add used_qty value

            // Send data to PHP script using AJAX to save it in jstock table
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // If successfully saved,
                        deleteRowFromJobfile(id);
                    } else {
                        // Handle error
                        console.error('Error:', xhr.status, xhr.responseText);
                    }
                }
            };
            xhr.open('POST', 'save_to_jstock.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('grn=' + encodeURIComponent(grn) +
                     '&receiving=' + encodeURIComponent(receiving) +
                     '&job_date=' + encodeURIComponent(job_date) +
                     '&job_name=' + encodeURIComponent(job_name) +
                     '&job_no=' + encodeURIComponent(job_no) +
                     '&out_product=' + encodeURIComponent(out_product) +
                     '&out_qty=' + encodeURIComponent(out_qty) +
                     '&used_qty=' + encodeURIComponent(used_qty)); // Include used_qty in the request
        }

        function deleteRowFromJobfile(id) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // If successfully deleted, remove the row from the display
                        var row = document.getElementById("row_" + id);
                        row.parentNode.removeChild(row);
                        alert('Row successfully deleted from jobfile table.');
                    } else {
                        // Handle error
                        console.error('Error:', xhr.status, xhr.responseText);
                    }
                }
            };
            xhr.open('POST', 'delete_from_jobfile.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + id);
        }

        function printTableRow(id) {
            var row = document.getElementById("row_" + id);
            var tableData = row.innerHTML;
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>Print Table</title>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<table>' + tableData + '</table>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
        function viewStock() {
            window.location.href = 'jstock.php';
        }
    </script>
    <button class="action-btn" onclick="viewStock()">View Stock</button>
</body>
</html>
