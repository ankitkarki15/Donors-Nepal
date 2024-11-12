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
</head>
<body>
    <div class="container">
        <h1>Notifications</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    
                    <th>Seeker Email</th>
                    <th>Donor Email</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                       
                        <td><?php echo htmlspecialchars($row['seeker_email']); ?></td>
                        <td><?php echo htmlspecialchars($row['donor_email']); ?></td>
                        <?php 
                        // echo htmlspecialchars($row['message']); ?>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td>
    <?php
    // Display action with a badge
    $status = htmlspecialchars($row['action']); // Sanitize action field
    if ($action == 'accepted') {
        echo '<span class="badge badge-success">' . $action . '</span>';
    } elseif ($action == 'declined') {
        echo '<span class="badge badge-danger">' . $action . '</span>';
    } else {
        echo '<span class="badge badge-secondary">' . $action . '</span>'; // Default badge for other cases
    }
    ?>
</td>

                        <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
                    </tr>
                <?php endwhile; ?>
                <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="8" class="text-center">No notifications available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$statement->close();
$conn->close();
?>
