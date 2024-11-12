<?php include('./include/userprofile.php'); ?>
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
<?php include './include/navbar.php'; ?>

<div class="container rounded bg-white mt-4">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="donor-request-tab" data-toggle="tab" href="#donor-request" role="tab" aria-controls="donor-request" aria-selected="true">Donor Request</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="blood-request-tab" data-toggle="tab" href="#blood-request" role="tab" aria-controls="blood-request" aria-selected="false">Blood Request</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="email-request-tab" data-toggle="tab" href="#email-request" role="tab" aria-controls="email-request" aria-selected="false">My email Request</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="donor-request" role="tabpanel" aria-labelledby="donor-request-tab">
                    <div class="container mt-4">
                        <div class="row">
                            <?php
                            // Assuming you have established a database connection
                            $conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

                            // Check the connection
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            // Get user_id
                            $sid = $_SESSION['sid'];

                            
                            $sql = "SELECT * FROM donors WHERE sid = '$sid'";

                            // Execute the query
                            $result = mysqli_query($conn, $sql);

                            // Check if there are any results
                            if (mysqli_num_rows($result) > 0) {
                                // Output data of each row
                                echo '<table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>DNID</th>
                                            <th>Blood Group</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>
                                        <td>' . $row['sid'] . '</td>
                                        <td>' . $row['bg'] . '</td>
                                        <td>' . $row['status'] . '</td>
                                        <td>' . $row['dr_date'] . '</td>
                                    </tr>';
                                }
                                echo '</tbody>
                                </table>';
                            } else {
                                echo '<div class="col-md-12"><p style="color:black;">No donor requests found.</p></div>';
                            }

                            // Close the database connection
                            mysqli_close($conn);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="blood-request" role="tabpanel" aria-labelledby="blood-request-tab">
                    <div class="container mt-4">
                        <div class="row">
                            <?php
                            // Assuming you have established a database connection
                            $conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

                            // Check the connection
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            // Get user_id
                            $sid = $_SESSION['sid'];

                            // SQL query to fetch blood requests history for the user
                            $sql = "SELECT * FROM bloodreq WHERE sid = '$sid'";

                            // Execute the query
                            $result = mysqli_query($conn, $sql);

                            // Check if there are any results
                            if (mysqli_num_rows($result) > 0) {
                                // Output data of each row
                                echo '<table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>BR_ID</th>
                                            <th>Contact</th>
                                            <th>Bg</th>
                                            <th>Address</th>
                                            <th>Required time</th>
                                            <th>Case</th>
                                           
                                              <th>Action</th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody>';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>
                                        <td>' . $row['id'] . '</td>
                                        <td>' . $row['patient_name'] . '</td>
                                        <td>' . $row['bg'] . '</td>
                                        <td>'. $row['locallevel']. '</td>
                                      <td>' .$row['req_date'] . ', ' . $row['req_time']. '</td>
                                       <td>' . $row['br_reason'] . '</td>
                                   
                                       <td>Delete?</td>
                                      
                                    </tr>';
                                }
                                echo '</tbody>
                                </table>';
                            } else {
                                echo '<div class="col-md-12"><p>No blood requests found.</p></div>';
                            }

                            // Close the database connection
                            mysqli_close($conn);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br><br><br><br><br><br><br><br><br>
<?php include('./include/footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                            
</body>
</html>
