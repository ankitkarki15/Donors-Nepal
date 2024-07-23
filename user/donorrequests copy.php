<?php
session_start();
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');

if (!isset($_SESSION['user_id'])) {
    die('User not logged in');
}

$user_id = $_SESSION['user_id'];

// Check if the user already has a pending or approved request
$sql_check_request = "SELECT status FROM donorreq WHERE user_id = ? AND (status = 'Pending' OR status = 'Approved')";
$stmt_check_request = $conn->prepare($sql_check_request);
$stmt_check_request->bind_param("s", $user_id);
$stmt_check_request->execute();
$result_check_request = $stmt_check_request->get_result();

// Fetch user details
$sql_user_details = "SELECT fullname, email, phone, availability FROM users WHERE user_id = ?";
$stmt_user_details = $conn->prepare($sql_user_details);
$stmt_user_details->bind_param("s", $user_id);
$stmt_user_details->execute();
$result_user_details = $stmt_user_details->get_result();

if ($result_user_details && mysqli_num_rows($result_user_details) > 0) {
    $user = mysqli_fetch_assoc($result_user_details);
} else {
    die('<span style="font-weight: bold;">User not found.</span>');
}

// Process form submission
$alertMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bg = $_POST["bg"];
    $district = $_POST["district"];
    $locallevel = $_POST["locallevel"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $availability = 1; // Assuming this is always set to 1
    $status = "Pending";

    // Calculate age from date of birth
    $dobObj = new DateTime($dob);
    $now = new DateTime();
    $diff = $now->diff($dobObj);
    $age = $diff->y;

    // Validate data
    if (empty($bg) || empty($district) || empty($locallevel) || empty($dob) || empty($gender)) {
        $errors = "Please fill out all required fields.";
    } else if ($age < 18) {
        $errors = "You must be at least 18 years old to submit a blood request.";
    } else {
        // Insert data into donorreq table
        $insert_sql = "INSERT INTO donorreq (user_id, bg, district, locallevel, dob, gender, status, availability) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param('ssssssss', $user_id, $bg, $district, $locallevel, $dob, $gender, $status, $availability);
        $insert_stmt->execute();

        $success = "Blood request submitted successfully!";
    }
}
?>

<?php 
    include 'include/navbar.php'; 
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Donor</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .heading-background {
            background-color: #cf3d3c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            height: 200px; 
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .heading-background h2 {
            margin: 0;
            position: relative;
            padding-bottom: 10px; 
            border-bottom: 4px solid white; 
        }
    </style>
</head>
<body>
    <?php include 'include/navbar.php'; ?>
    <div class="container-fluid heading-background">
        <h2 class="text-center mb-4">Become a Donor</h2>
    </div>
    <div class="container mt-5">
        <?php if (isset($errors)): ?>
            <div class="alert alert-danger">
                <?= $errors; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?= $success; ?>
            </div>
        <?php endif; ?>
        <?php
if ($result_check_request && mysqli_num_rows($result_check_request) > 0) {
    $existing_request = mysqli_fetch_assoc($result_check_request);
    $existing_status = $existing_request['status'];

    // Define messages and icons based on the existing request status
    if ($existing_status == 'Pending') {
        $Message = 'You already have a pending request. Please wait for approval. In case of rejection, you can submit with correct details in the provided form again.';
        $Icon = '<i class="fas fa-hourglass-half" style="font-size: 3rem;color: #FFA500;"></i>';
    } elseif ($existing_status == 'Approved') {
        $Message = 'You are now approved as a registered DONORS NEPAL donor. Feel free to donate blood and save lives. You cannot submit another request at this time.';
        $Icon = '<i class="fas fa-trophy" style="font-size: 3rem;color: #28a745;"></i>';
    } elseif ($existing_status == 'Rejected') {
        $Message = 'Your previous request was rejected. Please submit your details correctly.';
        $Icon = '<i class="fas fa-times-circle" style="font-size: 3rem; color: #cf3d3c;"></i>';
    }
}
?>

<?php if (isset($Message)): ?>
    <div class="card mt-4 mx-auto" style="max-width: 500px; border: 2px solid #cf3d3c; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div class="card-body text-center">
            <div class="mb-3">
                <?= $Icon; ?>
            </div>
            <?php if ($existing_status == 'Approved'): ?>
                <h3 class="card-title" style="color: #cf3d3c;">Congratulations!</h3>
            <?php elseif ($existing_status == 'Pending'): ?>
                <h3 class="card-title" style="color: #cf3d3c;">Pending!</h3>
            <?php else: ?>
                <h3 class="card-title" style="color: #cf3d3c;">Rejected!</h3>
            <?php endif; ?>

                <!-- <h3 class="card-title">Message</h3> -->
            <?php endif; ?>
            <hr>
            <p class="card-text" style="color: #333;"><?= $Message; ?></p>
            <a href="seebloodreq.php" class="btn btn-primary" style="background-color: #cf3d3c; border-color: #cf3d3c;">Blood Requests</a>
            <a href="history/myhistory.php" class="btn btn-primary" style="background-color: #cf3d3c; border-color: #cf3d3c;">Your History</a>
        </div>
    </div>

        <?php if (!isset($Message) || $existing_status == 'Rejected'): ?>
            <form id="donorForm" action="" method="POST" class="needs-validation" novalidate>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="fullname">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="user_id">ID</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo $user_id; ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="bg">Blood Group</label>
                        <select class="form-control" id="bg" name="bg">
                            <option value="" disabled>Select Blood Group</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a blood group.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="district">District</label>
                        <select class="form-control" id="district" name="district">
                            <option value="Kathmandu">Kathmandu</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="locallevel">Local Level</label>
                        <select class="form-control" id="locallevel" name="locallevel">
                            <option value="">Select Local Level</option>
                            <option value="Kathmandu">Kathmandu</option>
                            <option value="Tokha">Tokha</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="" disabled>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Others</option>
                        </select>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" name="submit">Submit</button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    <br><br><br>
    <?php include 'include/footer.php'; ?>
</body>
</html>