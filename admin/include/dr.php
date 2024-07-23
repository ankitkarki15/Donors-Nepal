<?php
// Connect to database
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn');
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Get data from AJAX request
$userId = $_POST['userId'];
$action = $_POST['action'];

// Update status based on action
if ($action === 'approve') {
    $status = 'Approved';
} elseif ($action === 'delete') {
    // Perform delete action if needed
} elseif ($action === 'reject') {
    $status = 'Rejected';
}

// Update status in the database
$sql = "UPDATE users SET status = '$status' WHERE user_id = '$userId'";
if (mysqli_query($conn, $sql)) {
    echo 'Status updated successfully';
} else {
    echo 'Error updating status: ' . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>
