<?php
// Establish database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $drid = $_POST['drid'];

    if (isset($_POST['approved'])) {
        $sql = "UPDATE donors SET status = 'Approved' WHERE drid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $drid);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $drid = $_POST['drid'];
        $sql = "DELETE FROM donors WHERE drid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $drid);
        $stmt->execute();
    } elseif (isset($_POST['rejected'])) {
        $drid = $_POST['drid'];
        $sql = "UPDATE donors SET status = 'Rejected' WHERE drid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $drid);
        $stmt->execute();
    }
}

// Fetch approved donor requests
$sql = "SELECT drid, name, phone, bg, CONCAT(district, ', ', locallevel) AS location, 
               DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), dob)), '%Y') + 0 AS age, 
               medical_conditions, status 
        FROM donors 
        WHERE status = 'Approved'";
$result = $conn->query($sql);

// Check for query execution error
if (!$result) {
    die("Error fetching data: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Approved Donor Requests</title>
    <style>
        /* Add custom styles if necessary */
        .table th, .table td {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container px-3 py-4">
        <h3><small>Approved Donor Requests</small></h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Donor_ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>BG</th>
                        <th>Location</th>
                        <th>Age</th>
                        <th>Medical Conditions</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['drid']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['bg']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['medical_conditions']) . "</td>";
                            echo "<td>";
                            // Display status with badge
                            $status = htmlspecialchars($row['status']);
                            if ($status == 'Approved') {
                                echo '<span class="badge badge-success">' . $status . '</span>';
                            } else {
                                echo '<span class="badge badge-secondary">' . $status . '</span>';
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No approved requests found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
