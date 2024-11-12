<?php
session_start();

$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Check if the user is logged in
if (!isset($_SESSION['drid'])) {
    header('Location: donorlogin.php');
    exit();
}

$drid = $_SESSION['drid'];

// Fetch donor information
$query = "SELECT * FROM donors WHERE drid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $drid);
$stmt->execute();
$donor = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Handle dismissing the approved message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dismiss_approved_message'])) {
    $_SESSION['approved_message_dismissed'] = true;
}

// Determine the status message
$statusMessage = '';
$statusClass = '';

if (strtolower($donor['status']) === 'pending') {
    $statusMessage = "Your request is still pending.";
    $statusClass = "pending";
} elseif (strtolower($donor['status']) === 'rejected') {
    $statusMessage = "Your request has been rejected. Please contact support for more information.";
    $statusClass = "rejected";
} elseif (strtolower($donor['status']) === 'approved' && !isset($_SESSION['approved_message_dismissed'])) {
    $statusMessage = "Congratulations! You have been approved as a donor.";
    $statusClass = "approved";
    $_SESSION['approved_message'] = true; // Show approved message temporarily
} else {
    $statusMessage = "Status unknown.";
    $statusClass = "unknown";
}

// Check for approved message in session
if (isset($_SESSION['approved_message']) && !isset($_SESSION['approved_message_dismissed'])) {
    $statusMessage = "Congratulations! You have been approved as a donor.";
    $statusClass = "approved";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile | DonorsNepal</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-section {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .form-section h3 {
            border-bottom: 2px solid #e63946;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #e63946;
            border: none;
        }
        .btn-primary:hover {
            background-color: #d62839;
        }
        .alert-info {
            margin-bottom: 20px;
        }
        .status-message {
            font-size: 1.2em;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .status-message.pending {
            background-color: #f0ad4e;
            color: white;
            border: 1px solid #ec971f;
        }
        .status-message.approved {
            background-color: #5cb85c;
            color: white;
            border: 1px solid #4cae4c;
        }
        .status-message.rejected {
            background-color: #d9534f;
            color: white;
            border: 1px solid #c9302c;
        }
        .close-message {
            cursor: pointer;
            float: right;
            color: white;
            font-weight: bold;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Display Donor Status -->
        <?php if ($statusMessage && strtolower($donor['status']) !== 'approved'): ?>
            <h4 class="status-message <?php echo $statusClass; ?>">
                Donor Request Status: <?php echo $statusMessage; ?>
            </h4>
        <?php elseif ($statusClass === 'approved' && !isset($_SESSION['approved_message_dismissed'])): ?>
            <h4 class="status-message <?php echo $statusClass; ?>">
                Donor Request Status: <?php echo $statusMessage; ?>
                <span class="close-message" onclick="dismissApprovedMessage()">&times;</span>
            </h4>
            <form id="dismissApprovedForm" method="POST" action="" style="display: none;">
                <input type="hidden" name="dismiss_approved_message" value="1">
            </form>
        <?php endif; ?>

        <h2>Your Profile</h2>

        <!-- Alert Message -->
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <!-- Profile Update Form -->
        <div id="personal-info" class="form-section">
            <h3>Personal Information</h3>
            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($donor['name']); ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($donor['email']); ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="bg">Blood Group</label>
                        <input type="text" class="form-control" id="bg" name="bg" value="<?php echo htmlspecialchars($donor['bg']); ?>" required readonly>
                        <small class="form-text text-muted">Select a new blood group from the dropdown below:</small>
                        <select class="form-control mt-2" id="bg_dropdown" name="bg_dropdown" required>
                            <option value="" disabled>Select your blood group</option>
                            <option value="A+" <?php echo ($donor['bg'] == 'A+') ? 'selected' : ''; ?>>A+</option>
                            <option value="A-" <?php echo ($donor['bg'] == 'A-') ? 'selected' : ''; ?>>A-</option>
                            <option value="B+" <?php echo ($donor['bg'] == 'B+') ? 'selected' : ''; ?>>B+</option>
                            <option value="B-" <?php echo ($donor['bg'] == 'B-') ? 'selected' : ''; ?>>B-</option>
                            <option value="O+" <?php echo ($donor['bg'] == 'O+') ? 'selected' : ''; ?>>O+</option>
                            <option value="O-" <?php echo ($donor['bg'] == 'O-') ? 'selected' : ''; ?>>O-</option>
                            <option value="AB+" <?php echo ($donor['bg'] == 'AB+') ? 'selected' : ''; ?>>AB+</option>
                            <option value="AB-" <?php echo ($donor['bg'] == 'AB-') ? 'selected' : ''; ?>>AB-</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($donor['dob']); ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="phone">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($donor['phone']); ?>" required>
                    </div>
                </div>
                <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
            </form>
        </div>

        <!-- Address Update Form -->
        <div id="address-info" class="form-section">
            <h3>Address Information</h3>
            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="district">District</label>
                        <input type="text" class="form-control" id="district" name="district" value="<?php echo htmlspecialchars($donor['district']); ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="locallevel">Local Level</label>
                        <input type="text" class="form-control" id="locallevel" name="locallevel" value="<?php echo htmlspecialchars($donor['locallevel']); ?>" required>
                    </div>
                </div>
                <button type="submit" name="update_address" class="btn btn-primary">Update Address</button>
            </form>
        </div>

        <!-- Medical Information Form -->
        <div id="medical-info" class="form-section">
            <h3>Medical Information</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="medical_conditions">Medical Conditions</label>
                    <textarea class="form-control" id="medical_conditions" name="medical_conditions"><?php echo htmlspecialchars($donor['medical_conditions']); ?></textarea>
                </div>
                <button type="submit" name="update_medical_info" class="btn btn-primary">Update Medical Information</button>
            </form>
        </div>
    </div>

    <script>
        function dismissApprovedMessage() {
            document.getElementById('dismissApprovedForm').submit();
        }
    </script>
</body>
</html>
