<?php

if (!isset($_SESSION['drid'])) {
    header("Location: front.php");
    exit();
}

$drid = $_SESSION['drid']; // Get the donor ID from the session

// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb');
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Check if the update form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sid'])) {
    $sid = $_POST['sid'];
    $donation_status = $_POST['donation_status'];
    $donated_blood_pint = $_POST['donated_blood_pint'];

    // Update the donation status and donated blood pint
    $update_query = "UPDATE blooddonationrequests SET donation_status = ?, donated_blood_pint = ? WHERE sid = ?";
    $update_statement = $conn->prepare($update_query);
    $update_statement->bind_param("sis", $donation_status, $donated_blood_pint, $sid);
    
    if ($update_statement->execute()) {
        // If the donation status is 'completed', update the donors table
        if ($donation_status === 'completed') {
            // Check if the donor is eligible to become unavailable
            $check_availability_query = "SELECT last_donation FROM donors WHERE drid = ?";
            $check_statement = $conn->prepare($check_availability_query);
            $check_statement->bind_param("s", $drid);
            $check_statement->execute();
            $check_statement->bind_result($last_donation);
            $check_statement->fetch();
            $check_statement->close();

            // Get the current date
            $current_date = new DateTime();
            $last_donation_date = new DateTime($last_donation);
            $interval = $last_donation_date->diff($current_date);
            $days_since_last_donation = $interval->days;

            // Update the donor's availability only if it's been more than 45 days since last donation
            if ($days_since_last_donation > 45) {
                // Update the donor's availability, increment donation count, and set last donation date
                $update_donor_query = "UPDATE donors SET availability = 0, donation_count = donation_count + 1, last_donation = CURDATE() WHERE drid = ?";
                $donor_statement = $conn->prepare($update_donor_query);
                $donor_statement->bind_param("s", $drid);
                $donor_statement->execute();
                $donor_statement->close();
            }
        }

        // Set success message
        $_SESSION['success_message'] = "Details updated and stored in database successfully .";
    }
    $update_statement->close();
}

// Fetch the accepted donation requests for the specific donor, including donation status and donated blood pint
$query = "SELECT DISTINCT blooddonationrequests.sid, blooddonationrequests.status, blooddonationrequests.donation_status, blooddonationrequests.donated_blood_pint, seekers.name, seekers.email 
          FROM blooddonationrequests
          JOIN seekers ON blooddonationrequests.sid = seekers.sid
          WHERE blooddonationrequests.drid = ? AND blooddonationrequests.status = 'accepted'";
$statement = $conn->prepare($query);
$statement->bind_param("s", $drid);
$statement->execute();
$result = $statement->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accepted Donation Requests</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-container {
            margin-top: 50px;
        }
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container table-container">
        <h1 class="mb-4">Accepted Donation Requests</h1>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success" role="alert">
                <?php 
                    echo htmlspecialchars($_SESSION['success_message']); 
                    unset($_SESSION['success_message']); // Unset the message after displaying it
                ?>
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Seeker Name</th>
                        <th>Seeker ID</th>
                        <th>Seeker Email</th>
                        <th>Donation Status</th>
                        <th>Blood Pint Donated</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['sid']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
    <?php 
    $donationStatus = htmlspecialchars($row['donation_status']); 
    if ($donationStatus === 'completed') {
        echo '<span class="badge badge-success">Completed</span>';
    } elseif ($donationStatus === 'in_progress') {
        echo '<span class="badge badge-warning">In Progress</span>';
    } elseif ($donationStatus === 'not_completed') {
        echo '<span class="badge badge-danger">Not Completed</span>';
    }
    ?>
</td>

                            <td><?php echo htmlspecialchars($row['donated_blood_pint']); ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal-<?php echo htmlspecialchars($row['sid']); ?>">
                                    Update
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="updateModal-<?php echo htmlspecialchars($row['sid']); ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateModalLabel">Update Donation Status</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="POST"> <!-- Updated to post to the same file -->
                                                    <div class="form-group">
                                                        <label for="donation_status">Donation Status</label>
                                                        <select class="form-control" id="donation_status" name="donation_status">
                                                            <option value="completed">Completed</option>
                                                            <option value="in_progress">In Progress</option>
                                                            <option value="not_completed">Not Completed</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="donated_blood_pint">Blood Pint Donated</label>
                                                        <input type="number" class="form-control" id="donated_blood_pint" name="donated_blood_pint" value="<?php echo htmlspecialchars($row['donated_blood_pint']); ?>">
                                                    </div>
                                                    <input type="hidden" name="sid" value="<?php echo htmlspecialchars($row['sid']); ?>">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                No donation requests have been accepted yet.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$statement->close();
$conn->close();
?>
