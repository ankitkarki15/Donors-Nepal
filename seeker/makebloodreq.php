<?php include 'include/navbar.php'; ?>
<?php
// session_start();
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Check if the user is logged in
if (!isset($_SESSION['sid'])) {
    die('User not logged in');
}

$sid = $_SESSION['sid'];
$errors = [];
$success = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    
    if (empty($patient_name) || empty($bg) || empty($hospital) || empty($district) || empty($locallevel) || empty($phone) || empty($req_date) || empty($req_time) || empty($req_pint) || empty($br_reason)) {
        $errors[] = 'All fields are required.';
    } else {
      
        $current_date = date('Y-m-d');
        $max_date = date('Y-m-d', strtotime('+30 days'));

        if ($req_date < $current_date) {
            $errors[] = 'The required date cannot be in the past.';
        } elseif ($req_date > $max_date) {
            $errors[] = 'The required date cannot exceed 30 days in the future.';
        } else {
            
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
            background: linear-gradient(135deg, #f4f4f4, #e2e2e2);
            color: black;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            height: 180px; 
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .heading-background h2 {
            margin: 0;
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
        .text-black {
            color: black;
        }
        .line-input {
        border: none;
        border-bottom: 1px solid black; /* Adds a line at the bottom */
        outline: none;
        width: 100%; /* Adjust width as necessary */
        padding: 5px 0; /* Adjust padding for a cleaner look */
        font-size: 16px; /* Adjust font size if needed */
    }

    .line-input::placeholder {
        color: #aaa; /* Placeholder color for a minimalistic feel */
    }

    /* To highlight the line when focused */
    .line-input:focus {
        border-bottom: 2px solid red; /* Line becomes red when focused */
    }
    </style>
</head>
<body>
 

    <div class="container-fluid heading-background">
        <h2 class="text-center mb-4">Make Blood Request</h2>
    </div>
    <div class="container mt-5">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        <form action="makebloodreq.php" method="POST">
            <div class="row">
                <!-- First Column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="patient_name">Patient Name</label>
                        <input type="text" class="line-input" id="patient_name" name="patient_name" placeholder="Enter patient name">
                    </div>
                    <div class="form-group">
                        <label for="bg">Blood Group</label>
                        <select class="line-input" id="bg" name="bg">
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
                        <input type="text"class="line-input" id="hospital" name="hospital" placeholder="Hospital name">
                    </div>
                    <div class="form-group">
                        <label for="district">District</label>
                        <select class="line-input" id="district" name="district">
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
                        <select class="line-input" id="locallevel" name="locallevel">
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" class="line-input" id="phone" name="phone" placeholder="Phone number">
                    </div>
                    <div class="form-group">
                        <label for="req_date">Required Date</label>
                        <input type="date" class="line-input" id="req_date" name="req_date">
                    </div>
                    <div class="form-group">
                        <label for="req_time">Required Time</label>
                        <input type="time"  id="req_time" name="req_time">
                    </div>
                    <div class="form-group">
                        <label for="req_pint">Required Pint <span style="font-size:12px;color:#cc0000;">(1 pint of blood = 473ml)</span></label>
                        <input type="number" class="line-input" id="req_pint" name="req_pint" placeholder="Enter required pint">
                    </div>
                    <div class="form-group">
                        <label for="br_reason">Reason</label>
                        <textarea class="line-input" id="br_reason" name="br_reason" rows="1" placeholder="Reason for the blood request"></textarea>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-danger custom-submit-btn">Submit</button>
            </div>
        </form>
    </div>
</body>
<br><br>
<?php include 'include/footer.php'; ?>
</html>