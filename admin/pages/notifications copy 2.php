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

// Fetch notifications
$adminId = $_SESSION['admin_id'];
$query = "SELECT * FROM admin_notifications WHERE admin_id = ? ORDER BY timestamp DESC";
$statement = $conn->prepare($query);
$statement->bind_param("i", $adminId);
$statement->execute();
$result = $statement->get_result();
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
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="notification-card border-<?php echo ($row['action'] == 'accepted') ? 'success' : (($row['action'] == 'declined') ? 'danger' : 'secondary'); ?>">
                    <h5 class="mb-1">Donation Request <?php echo ucfirst(htmlspecialchars($row['action'])); ?></h5>
                    <p class="mb-1">
                        <strong>Seeker Email:</strong> <?php echo htmlspecialchars($row['seeker_email']); ?><br>
                        <strong>Donor Email:</strong> <?php echo htmlspecialchars($row['donor_email']); ?><br>
                        <!-- <strong>Status:</strong>  -->
                       
                    </p>
                    <p class="timestamp">Timestamp: <?php echo htmlspecialchars($row['timestamp']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info text-center">
                No notifications available
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$statement->close();
$conn->close();
?>
