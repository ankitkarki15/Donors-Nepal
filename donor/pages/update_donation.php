<?php

$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Check if the user is logged in
if (!isset($_SESSION['drid'])) {
    header('Location: donorlogin.php');
    exit();
}

$drid = $_SESSION['drid'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_donation_date'])) {
        $donationDate = $_POST['donation_date'];

        // Update donation date
        $updateDonationQuery = "UPDATE donors SET last_donation = ? WHERE drid = ?";
        $stmt = $conn->prepare($updateDonationQuery);
        $stmt->bind_param('ss', $donationDate, $drid);

        if ($stmt->execute()) {
            $message = "Your recent donation date updated successfully.";
        } else {
            $message = "Error updating donation date.";
        }
        $stmt->close();
    }
}

// Fetch donor information to show the current donation date
$query = "SELECT last_donation FROM donors WHERE drid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $drid);
$stmt->execute();
$donor = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Donation Date | DonorsNepal</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Navbar Styles */
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #e63946;
        }

        .nav-link {
            font-size: 0.85rem;
            color: #333;
        }

        .nav-link:hover {
            color: #e63946;
        }

        /* Dashboard Content Styles */
        .dashboard-content {
            padding: 20px;
        }

        .update-form {
            margin-top: 20px;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .message {
            margin-top: 20px;
            font-weight: bold;
        }

        footer {
            background-color: #f1f1f1;
            padding: 10px;
            color: #333;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .update-form {
                padding: 10px;
            }
        }
    </style>
</head>
<body>


<!-- Update Donation Date Content -->
<div class="container dashboard-content">
    <h2>Update Your Donation Date</h2>

    <?php if (!empty($message)): ?>
        <div class="message alert alert-info">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form action="" method="post" class="update-form">
        <div class="form-group">
            <label for="donation_date">Current Donation Date</label>
            <input type="date" class="form-control" id="donation_date" name="donation_date" value="<?php echo htmlspecialchars($donor['last_donation']); ?>" required>
        </div>
        <button type="submit" name="update_donation_date" class="btn btn-primary">Update Donation Date</button>
    </form>
</div>

<!-- Footer -->
<?php include 'include/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
