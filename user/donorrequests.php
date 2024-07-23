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
        // Initialize the variables
        $Message = '';
        $Icon = '';

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

        <?php if (!empty($Message)): ?>
            <div class="alert alert-info text-center">
                <?= $Icon; ?><br>
                <?= $Message; ?>
            </div>
        <?php else: ?>
            <!-- Form for new donor request -->
            <form action="" method="POST">
                <div class="form-group">
                    <label for="bg">Blood Group</label>
                    <select name="bg" id="bg" class="form-control">
                        <option value="">Select Blood Group</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="district">District</label>
                        <select class="form-control" id="district" name="district" required>
                            <option value="" disabled selected>Select District</option>
                            <?php
                            // Fetch districts from database and populate dropdown options
                            $query = "SELECT * FROM districts ORDER BY district_name";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value=\"{$row['id']}\">{$row['district_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="locallevel">Local Level</label>
                        <select class="form-control" id="locallevel" name="locallevel" required>
                            <option value="" disabled selected>Select Local Level</option>
                            <!-- Options will be populated dynamically using JavaScript -->
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    </div>
                </div>
                <div class="text-center">
                    <!-- <button type="submit" class="btn btn-primary">Submit Request</button> -->
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
    <br><br><br><br>
    <?php include 'include/footer.php'; ?>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    document.getElementById('district').addEventListener('change', function() {
        var districtId = this.value;
        var localLevelSelect = document.getElementById('locallevel');

        // Clear existing options
        localLevelSelect.innerHTML = '<option value="" disabled selected>Select Local Level</option>';

        // Fetch local levels using AJAX
        if (districtId !== '') {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'include/fetch_locallevels.php?district_id=' + encodeURIComponent(districtId), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var localLevels = JSON.parse(xhr.responseText);
                        localLevels.forEach(function(localLevel) {
                            var option = document.createElement('option');
                            option.value = locallevel.id; // Assuming 'id' is the key for locallevel_id
                            option.textContent = localLevel.locallevel_name; // Assuming 'local_level_name' is the key for local level name
                            localLevelSelect.appendChild(option);
                        });
                    } else {
                        console.error('Error fetching local levels. Status code: ' + xhr.status);
                    }
                }
            };
            xhr.send();
        }
    });
</script>

</body>
</html>
