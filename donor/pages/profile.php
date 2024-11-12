<?php


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

// Determine the status message
$statusMessage = '';
$statusClass = '';

if (strtolower($donor['status']) === 'pending') {
    $statusMessage = "Your request is still pending.";
    $statusClass = "pending";
} elseif (strtolower($donor['status']) === 'rejected') {
    $statusMessage = "Your request has been rejected. Please contact support for more information.";
    $statusClass = "rejected";
} elseif (strtolower($donor['status']) === 'approved') {
    $statusMessage = "Congratulations! You have been approved as a donor.";
    $statusClass = "approved";
    $_SESSION['approved_message'] = true; // Show approved message temporarily
} else {
    $statusMessage = "Status unknown.";
    $statusClass = "unknown";
}


// Handle post requests for updates
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        // Get profile form data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $bg = $_POST['bg_dropdown'];
        $dob = $_POST['dob'];
        $phone = $_POST['phone'];

        // Update donor information
        $updateQuery = "UPDATE donors SET name = ?, email = ?, bg = ?, dob = ?, phone = ? WHERE drid = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('ssssss', $name, $email, $bg, $dob, $phone, $drid);
        
        if ($stmt->execute()) {
            $message = "Profile updated successfully.";
        } else {
            $message = "Error updating profile.";
        }
        $stmt->close();
    } elseif (isset($_POST['update_address'])) {
        $district = $_POST['district'];
        $locallevel = $_POST['locallevel'];

        // Fetch latitude and longitude for the selected locallevel
        $query = "SELECT latitude, longitude FROM locallevels WHERE locallevel_name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $locallevel);
        $stmt->execute();
        $result = $stmt->get_result();
        $location = $result->fetch_assoc();
        $latitude = $location['latitude'];
        $longitude = $location['longitude'];
        $stmt->close();

        // Update address with latitude and longitude
        $updateAddressQuery = "UPDATE donors SET district = ?, locallevel = ?, latitude = ?, longitude = ? WHERE drid = ?";
        $stmt = $conn->prepare($updateAddressQuery);
        $stmt->bind_param('ssdds', $district, $locallevel, $latitude, $longitude, $drid);
        
        if ($stmt->execute()) {
            $message = "Address updated successfully.";
        } else {
            $message = "Error updating address.";
        }
        $stmt->close();
    } elseif (isset($_POST['manage_availability'])) {
        // Get availability form data
        $availability = $_POST['availability'];

        // Update availability
        $updateAvailabilityQuery = "UPDATE donors SET availability = ? WHERE drid = ?";
        $stmt = $conn->prepare($updateAvailabilityQuery);
        $stmt->bind_param('ss', $availability, $drid);
        
        if ($stmt->execute()) {
            $message = "Availability updated successfully.";
        } else {
            $message = "Error updating availability.";
        }
        $stmt->close();
    }
}

// Fetch updated donor information
$query = "SELECT * FROM donors WHERE drid = ?";
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
    <title>Your Profile | DonorsNepal</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Your existing CSS */
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
        <h4 class="status-message <?php echo $statusClass; ?>">
            Donor Request Status: <?php echo $statusMessage; ?>
            <?php if ($statusClass === 'approved'): ?>
                <span class="close-message" onclick="this.parentElement.style.display='none';">&times;</span>
            <?php endif; ?>
        </h4>

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

        <!-- Availability Update Form -->
        <div id="availability-info" class="form-section">
            <h3>Manage Availability</h3>
            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="availability">Availability</label>
                        <select class="form-control" id="availability" name="availability">
                            <option value="Available" <?php echo ($donor['availability'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                            <option value="Unavailable" <?php echo ($donor['availability'] == 'Unavailable') ? 'selected' : ''; ?>>Unavailable</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="manage_availability" class="btn btn-primary">Update Availability</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
