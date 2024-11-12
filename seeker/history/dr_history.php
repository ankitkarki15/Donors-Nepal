<?php include('../include/userprofile.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
</head>
<body>
<?php include('../include/usernav.php'); ?>

<div class="container rounded bg-white">
    <div class="row">
        
        <div class="col-md-12"><br><br><br>
            <h3>My Blood Requests History</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Blood Group</th>
                        <th>Address</th>
                        <th>Local Level</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Assuming you have established a database connection
                    $conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');

                    // Check the connection
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    // Get user_id
                    $user_id = $_SESSION['user_id'];

                    // SQL query to fetch blood requests history for the user
                    $sql = "SELECT * FROM donorreq WHERE user_id = '$user_id'";

                    // Execute the query
                    $result = mysqli_query($conn, $sql);

                    // Check if there are any results
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Output each blood request as a table row
                            echo '<tr>';
                            echo '<td>' . $row['bg'] . '</td>';
                            echo '<td>' . $row['district'] . '</td>';
                            echo '<td>' . $row['locallevel'] . '</td>';
                            echo '<td>' . (isset($row['dob']) ? $row['dob'] : '') . '</td>';
                            echo '<td>' . (isset($row['gender']) ? $row['gender'] : '') . '</td>';
                            echo '<td>' . $row['status'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6">No blood requests found.</td></tr>';
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
