<?php
session_start();
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Check if the user is logged in
if (!isset($_SESSION['sid'])) {
    die('User not logged in');
}

$sid = $_SESSION['sid'];
$errors = [];
$success = "";

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize form inputs
    $patient_name = isset($_POST['patient_name']) ? trim($_POST['patient_name']) : '';
    $bg = isset($_POST['bg']) ? trim($_POST['bg']) : '';
    $hospital = isset($_POST['hospital']) ? trim($_POST['hospital']) : '';
    $district = isset($_POST['district']) ? trim($_POST['district']) : '';
    $locallevel = isset($_POST['locallevel']) ? trim($_POST['locallevel']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $req_date = isset($_POST['req_date']) ? trim($_POST['req_date']) : '';
    $req_time = isset($_POST['req_time']) ? trim($_POST['req_time']) : '';
    $req_pint = isset($_POST['req_pint']) ? trim($_POST['req_pint']) : '';
    $br_reason = isset($_POST['br_reason']) ? trim($_POST['br_reason']) : '';

    // Validate required fields
    if (empty($patient_name) || empty($bg) || empty($hospital) || empty($district) || empty($locallevel) || empty($phone) || empty($req_date) || empty($req_time) || empty($req_pint) || empty($br_reason)) {
        $errors[] = 'All fields are required.';
    } else {
        // Validate the required date
        $current_date = date('Y-m-d');
        $max_date = date('Y-m-d', strtotime('+30 days'));

        if ($req_date < $current_date) {
            $errors[] = 'The required date cannot be in the past.';
        } elseif ($req_date > $max_date) {
            $errors[] = 'The required date cannot exceed 30 days in the future.';
        } else {
            // Proceed with database insertion or other logic
            $query = "INSERT INTO bloodreq (sid, patient_name, bg, hospital, district, locallevel, phone, req_date, req_time, req_pint, br_reason)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssssssssss', $sid, $patient_name, $bg, $hospital, $district, $locallevel, $phone, $req_date, $req_time, $req_pint, $br_reason);

            if ($stmt->execute()) {
                $success = 'Blood request submitted successfully.';
            } else {
                $errors[] = 'Error submitting the blood request. Please try again.';
            }
            $stmt->close();
        }
    }

    // Redirect with query parameters
    $redirect_url = 'makebloodreq.php';
    if (!empty($errors)) {
        $redirect_url .= '?errors=' . urlencode(implode('; ', $errors));
    } elseif (!empty($success)) {
        $redirect_url .= '?success=' . urlencode($success);
    }
    header("Location: $redirect_url");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blood Request</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .heading-background {
            padding-top: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 50px;   
        }
        .heading-background h2 {
            margin: 0;
            color: black;
            position: relative;
            padding-bottom: 10px; 
            border-bottom: 4px solid red; 
        }

        .custom-submit-btn {
            background-color: #cf3d3c !important; 
            height: 50px; 
            width: 200px; 
            border: 2px solid white;
            border-radius: 4px;
            font-size: 18px;
            color: white !important;
            display: block;
            margin: 0 auto;
        }
        .custom-submit-btn:hover {
            background-color: #b30000; 
            color: white !important;
        }

        .form-control {
            height: 45px; /* Increased height */
            font-size: 16px; /* Increased font size */
        }
        .form-control-sm {
            height: 38px;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 15px; /* Increased margin for better spacing */
        }
        .validation-message {
            color: red;
            font-size: 14px;
        }
        .text-black {
            color: black;
        }

        /* Alert Popup Styling */
        .alert-popup {
            position: fixed;
            top: 5%; /* Adjust to move the popup closer to the top */
            left: 50%;
            transform: translateX(-50%);
            width: 360px;
            padding: 14px;
            background-color: white;
            border: 1px solid transparent;
            border-radius: 4px;
            display: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            align-items: center;
            z-index: 1000;
            text-align: center;
        }
        .alert-popup i {
            margin-right: 10px;
        }
        .alert-success {
            padding-top: 18px;
            color: #0a0a0a;
            background-color: #fcfdfc;
            border-color: #f9fdfa;
            font-family: Georgia, Times, 'Times New Roman', serif;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .alert-success i {
            color: green; /* Green color for success icon */
        }
        .alert-danger i {
            color: red; /* Red color for error icon */
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none; /* Hide by default */
            z-index: 999;
        }
    </style>
</head>
<body>
    <?php include 'include/navbar.php'; ?>

    <!-- Overlay for popup effect -->
    <div class="overlay" id="overlay"></div>

    <!-- Alert Popup at the Top -->
    <div id="successAlert" class="alert-popup alert-success">
        <i class="fas fa-check-circle"></i> Blood request submitted successfully.
    </div>

    <div id="errorAlert" class="alert-popup alert-danger">
        <i class="fas fa-times-circle"></i> Please fill in the correct data.
    </div>

    <div class="container-fluid heading-background">
        <h2 class="text-center mb-4">Make Blood Request</h2>
    </div>
    <div class="container mt-5">
        
        <!-- phperror success here -->
        
        
        <form action="makebloodreq.php" method="POST">
            <div class="row">
                <!-- First Column -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="patient_name">Patient Name</label>
                        <input type="text" class="form-control" id="patient_name" name="patient_name" placeholder="Enter patient name">
                    </div>
                    <div class="form-group">
                        <label for="bg">Blood Group</label>
                        <select class="form-control" id="bg" name="bg">
                            <option value="" disabled selected>Select Blood Group</option>
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
                    <div class="form-group">
                        <label for="hospital">Hospital</label>
                        <input type="text" class="form-control" id="hospital" name="hospital" placeholder="Hospital name">
                    </div>
                    <div class="form-group">
                        <label for="district">District</label>
                        <select class="form-control" id="district" name="district">
                            <option value="" disabled selected>Select District</option>
                            <?php
                            // Fetch districts from database and populate dropdown options
                            $query = "SELECT * FROM districts ORDER BY district_name";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value=\"{$row['district_name']}\">{$row['district_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="locallevel">Local Level</label>
                        <select class="form-control" id="locallevel" name="locallevel">
                            <option value="" disabled selected>Select Local Level</option>
                            <?php
                            // Fetch local levels from database and populate dropdown options
                            $query = "SELECT * FROM locallevels ORDER BY locallevel_name";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value=\"{$row['locallevel_name']}\">{$row['locallevel_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- Second Column -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone number">
                    </div>
                    <div class="form-group">
                        <label for="req_date">Required Date</label>
                        <input type="date" class="form-control" id="req_date" name="req_date">
                        <div class="validation-message">You cannot request in the past and cannot exceed 30 days from today.</div>
                    </div>
                    <div class="form-group">
                        <label for="req_time">Required Time</label>
                        <input type="time" class="form-control" id="req_time" name="req_time">
                    </div>
                    <div class="form-group">
                        <label for="req_pint">Required Pint <span style="font-size:12px;color:#cc0000;">(1 pint of blood = 473ml)</span></label>
                        <input type="number" class="form-control" id="req_pint" name="req_pint" placeholder="Enter required pint">
                    </div>
                </div>
                <!-- Third Column -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="br_reason">Reason</label>
                        <textarea class="form-control" id="br_reason" name="br_reason" rows="6" placeholder="Reason for the blood request"></textarea>
                    </div>
                </div>
                </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-danger custom-submit-btn">Submit</button>
            </div>
        </form>
    </div>
    <br><br><br>
    <?php include 'include/footer.php'; ?>

    <!-- JavaScript to Handle Alert Popups -->
    <script>
        function showAlert(type, message) {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            const overlay = document.getElementById('overlay');
            
            // Hide all alerts initially
            successAlert.style.display = 'none';
            errorAlert.style.display = 'none';
            overlay.style.display = 'none';

            if (type === 'success') {
                successAlert.style.display = 'flex';
                successAlert.querySelector('i').nextSibling.textContent = message;
            } else if (type === 'error') {
                errorAlert.style.display = 'flex';
                errorAlert.querySelector('i').nextSibling.textContent = message;
            }

            overlay.style.display = 'block';

            overlay.onclick = function() {
                successAlert.style.display = 'none';
                errorAlert.style.display = 'none';
                overlay.style.display = 'none';
            };
        }

        // Example usage to show alerts (can be triggered based on PHP response)
        <?php if (isset($_GET['success'])): ?>
            showAlert('success', '<?= htmlspecialchars($_GET['success']); ?>');
        <?php elseif (isset($_GET['error'])): ?>
            showAlert('error', '<?= htmlspecialchars($_GET['error']); ?>');
        <?php endif; ?>
    </script>
</body>
</html>
