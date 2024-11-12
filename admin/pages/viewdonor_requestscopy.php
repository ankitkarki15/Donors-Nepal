<?php
// Establish database connection
$conn = new mysqli('localhost', 'root', 'ankit', 'dndb');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Initialize message variables
$message = "";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $drid = $conn->real_escape_string($_POST['drid']);

    // Fetch user details
    $sql = "SELECT dob FROM donors WHERE drid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $drid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $today = new DateTime();
        $dob = new DateTime($row['dob']);
        $age = $today->diff($dob)->y;

        if (isset($_POST['approved'])) {
            if ($age >= 18) {
                $sql = "UPDATE donors SET status = 'Approved' WHERE drid = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $drid);
                if ($stmt->execute()) {
                    $message = "Donor " . $drid . " approved successfully.";
                }
            } else {
                $message = "Donor " . $drid . " is not eligible due to age restrictions.";
            }
        } elseif (isset($_POST['rejected'])) {
            $sql = "UPDATE donors SET status = 'Rejected' WHERE drid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $drid);
            if ($stmt->execute()) {
                $message = "Donor " . $drid . " rejected successfully.";
            }
        }
    }

    $stmt->close();
}

// Fetch all donor details
$sql = "SELECT drid, sid, name, email, phone, bg, dob, district, locallevel, last_donation, donation_count, availability, medical_conditions, is_eligible, status, personal_documents, medical_documents 
         FROM donors WHERE status = 'Pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
     .custom-table {
            width: 100%;
        }
        .modal-content {
            padding: 20px;
            max-width: 1800px; 
        }
        .modal-content img {
            max-width: 100%; /* Responsive */
            max-height: 400px; /* Limit height */
            width: auto; /* Maintain aspect ratio */
            height: auto; /* Maintain aspect ratio */
            border: 1px solid #ddd; /* Optional styling */
            border-radius: 4px; /* Optional styling */
            margin-bottom: 10px; /* Space below image */
        }   

        .form-group {
            margin-bottom: 15px;
        }
        .modal-header {
            border-bottom: none;
        }
    </style>
    <title>Pending Donors Requests</title>
    <script>
        function confirmAction(drid, action) {
            var message = action === 'approve' ? "Do you want to approve this donor ID " + drid + "?" : "Do you want to reject this donor ID " + drid + "?";
            if (confirm(message)) {
                return true; // Proceed with form submission
            }
            return false; // Cancel form submission
        }

        // Display message after action
        $(document).ready(function() {
            var message = "<?php echo $message; ?>";
            if (message) {
                alert(message);
            }
        });
    </script>
</head>
<body>
    <div class="container px-1 py-4">
        <h3><small>Pending Donors Requests</small></h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped custom-table">
                <thead class="thead-dark">
                    <tr>
                        <th>DRID</th>
                        <th>SID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>BG</th>
                        <th>DOB</th>
                        <th>View Full Details</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['drid']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['sid']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['bg']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['dob']) . "</td>";
                            echo "<td>";
                            echo '<button class="btn btn-info" data-toggle="modal" data-target="#detailsModal' . htmlspecialchars($row['drid']) . '">View Full Details</button>';
                            echo "</td>";
                            echo "</tr>";

                            // Modal for Full Details
                            $drid = htmlspecialchars($row['drid']);
                            $personalDocPath = '../donor/uploads/personal_documents/' . htmlspecialchars($row['personal_documents']);
                            $medicalDocPath = '../donor/uploads/medical_documents/' . htmlspecialchars($row['medical_documents']);
                            
                            echo '
                            <div class="modal fade" id="detailsModal' . $drid . '" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
                               <div class="modal-dialog modal-lg" role="document">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailsModalLabel">Donor Details - ' . htmlspecialchars($row['name']) . '</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" onsubmit="return confirmAction(\'' . $drid . '\', this.approval.value);">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="donorName">Name</label>
                                                    <input type="text" class="form-control" id="donorName" value="' . htmlspecialchars($row['name']) . '" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="donorEmail">Email</label>
                                                    <input type="email" class="form-control" id="donorEmail" value="' . htmlspecialchars($row['email']) . '" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="donorPhone">Phone</label>
                                                    <input type="text" class="form-control" id="donorPhone" value="' . htmlspecialchars($row['phone']) . '" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="donorBG">Blood Group</label>
                                                    <input type="text" class="form-control" id="donorBG" value="' . htmlspecialchars($row['bg']) . '" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="donorDOB">Date of Birth</label>
                                                    <input type="date" class="form-control" id="donorDOB" value="' . htmlspecialchars($row['dob']) . '" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="donorDistrict">District</label>
                                                    <input type="text" class="form-control" id="donorDistrict" value="' . htmlspecialchars($row['district']) . '" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="donorLocalLevel">Local Level</label>
                                                    <input type="text" class="form-control" id="donorLocalLevel" value="' . htmlspecialchars($row['locallevel']) . '" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="lastDonation">Last Donation</label>
                                                    <input type="text" class="form-control" id="lastDonation" value="' . htmlspecialchars($row['last_donation']) . '" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="donationCount">Donation Count</label>
                                                    <input type="text" class="form-control" id="donationCount" value="' . htmlspecialchars($row['donation_count']) . '" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="availability">Availability</label>
                                                    <input type="text" class="form-control" id="availability" value="' . htmlspecialchars($row['availability']) . '" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="medicalConditions">Medical Conditions</label>
                                                    <input type="text" class="form-control" id="medicalConditions" value="' . htmlspecialchars($row['medical_conditions']) . '" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Personal Document:</h6>
                                                    <img src="' . htmlspecialchars($personalDocPath) . '" alt="Personal Document" />
                                                    <h6>Medical Document:</h6>
                                                    <img src="' . htmlspecialchars($medicalDocPath) . '" alt="Medical Document" />
                                                </div>
                                            </div>
                                            <input type="hidden" name="drid" value="' . $drid . '">
                                            <div class="modal-footer">
                                                <button type="submit" name="approved" class="btn btn-success">Approve</button>
                                                <button type="submit" name="rejected" class="btn btn-danger">Reject</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                        }
                    } else {
                        echo "<tr><td colspan='8'>No pending donors found.</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
