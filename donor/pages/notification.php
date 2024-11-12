<?php
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Check if the user is logged in
if (!isset($_SESSION['drid'])) {
    header('Location: donorlogin.php');
    exit();
}

$drid = $_SESSION['drid'];

// Fetch donor status from the database
$query = "SELECT status FROM donors WHERE drid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $drid);
$stmt->execute();
$result = $stmt->get_result();
$donor = $result->fetch_assoc();
$stmt->close();

$statusMessage = '';
$statusClass = '';

// Determine the status message and class based on the donor's status
if (strtolower($donor['status']) === 'pending') {
    $statusMessage = "Your donation request is still pending.";
    $statusClass = "pending";
} elseif (strtolower($donor['status']) === 'rejected') {
    $statusMessage = "Your donation request was rejected. Please contact support.";
    $statusClass = "rejected";
} elseif (strtolower($donor['status']) === 'approved') {
    $statusMessage = "Congratulations! Your request has been approved.";
    $statusClass = "approved";
} else {
    $statusMessage = "Status unknown.";
    $statusClass = "unknown";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications | DonorsNepal</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .notification {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-top: 20px;
        }
        .notification h4 {
            margin-bottom: 10px;
        }
        .notification.approved {
            border-color: #4cae4c;
            background-color: #dff0d8;
        }
        .notification.pending {
            border-color: #ec971f;
            background-color: #fcf8e3;
        }
        .notification.rejected {
            border-color: #c9302c;
            background-color: #f2dede;
        }
        .notification.unknown {
            border-color: #999;
            background-color: #eee;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Your Notifications</h2>

        <!-- Display the notification message based on the status -->
        <div class="notification <?php echo $statusClass; ?>">
            <h4>Donor Status:</h4>
            <p><?php echo $statusMessage; ?></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
