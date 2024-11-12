<?php
// session_start(); 
// Start the session at the very top

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: /adminlogin.php"); // Redirect if not logged in
    exit();
}

// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb');
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Fetch notifications for accepted and declined actions
$adminId = $_SESSION['admin_id'];
$acceptedQuery = "SELECT * FROM admin_notifications WHERE admin_id = ? AND action = 'accepted' ORDER BY timestamp DESC";
$declinedQuery = "SELECT * FROM admin_notifications WHERE admin_id = ? AND action = 'declined' ORDER BY timestamp DESC";

$acceptedStatement = $conn->prepare($acceptedQuery);
$acceptedStatement->bind_param("i", $adminId);
$acceptedStatement->execute();
$acceptedResult = $acceptedStatement->get_result();

$declinedStatement = $conn->prepare($declinedQuery);
$declinedStatement->bind_param("i", $adminId);
$declinedStatement->execute();
$declinedResult = $declinedStatement->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .notification-card {
            margin-bottom: 1rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-left: 5px solid;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .badge-secondary {
            background-color: #6c757d;
        }
        .timestamp {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Notifications</h1>
        
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="accepted-tab" data-toggle="tab" href="#accepted" role="tab" aria-controls="accepted" aria-selected="true">Accepted</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="declined-tab" data-toggle="tab" href="#declined" role="tab" aria-controls="declined" aria-selected="false">Declined</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-4" id="myTabContent">
            <!-- Accepted Requests Tab -->
            <div class="tab-pane fade show active" id="accepted" role="tabpanel" aria-labelledby="accepted-tab">
                <?php if ($acceptedResult->num_rows > 0): ?>
                    <?php while ($row = $acceptedResult->fetch_assoc()): ?>
                        <div class="notification-card border-success">
                            <h5 class="mb-1">Donation Request Accepted</h5>
                            <p class="mb-1">
                                <strong>Seeker Email:</strong> <?php echo htmlspecialchars($row['seeker_email']); ?><br>
                                <strong>Donor Email:</strong> <?php echo htmlspecialchars($row['donor_email']); ?>
                            </p>
                            <p class="timestamp">Timestamp: <?php echo htmlspecialchars($row['timestamp']); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        No accepted notifications available
                    </div>
                <?php endif; ?>
            </div>

            <!-- Declined Requests Tab -->
            <div class="tab-pane fade" id="declined" role="tabpanel" aria-labelledby="declined-tab">
                <?php if ($declinedResult->num_rows > 0): ?>
                    <?php while ($row = $declinedResult->fetch_assoc()): ?>
                        <div class="notification-card border-danger">
                            <h5 class="mb-1">Donation Request Declined</h5>
                            <p class="mb-1">
                                <strong>Seeker Email:</strong> <?php echo htmlspecialchars($row['seeker_email']); ?><br>
                                <strong>Donor Email:</strong> <?php echo htmlspecialchars($row['donor_email']); ?>
                            </p>
                            <p class="timestamp">Timestamp: <?php echo htmlspecialchars($row['timestamp']); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        No declined notifications available
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close prepared statements and connection
$acceptedStatement->close();
$declinedStatement->close();
$conn->close();
?>
