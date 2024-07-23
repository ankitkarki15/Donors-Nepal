<?php

session_start();
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die('User not logged in');
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $contact_person = $_POST['contact_person'];
    $bg = $_POST['bg'];
    $hospital = $_POST['hospital'];
    $district = $_POST['district'];
    $locallevel = $_POST['locallevel'];
    $phone = $_POST['phone'];
    $req_date = $_POST['req_date'];
    $req_time = $_POST['req_time'];
    $req_pint = $_POST['req_pint'];
    $br_reason = $_POST['br_reason'];

    // Validate data
    $errors = ""; // Initialize error message
    $current_date = new DateTime();
    $req_date_obj = DateTime::createFromFormat('Y-m-d', $req_date);
    $max_date = clone $current_date;
    $max_date->modify('+60 days');

    if (empty($contact_person) || empty($bg) || empty($hospital) || empty($district) || empty($locallevel) || empty($phone) || empty($req_date) || empty($req_time) || empty($req_pint) || empty($br_reason)) {
        $errors = "Please fill out all required fields.";
    } else if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors = "Please enter a valid phone number.";
    } else if ($req_date_obj < $current_date->setTime(0, 0, 0)) {  // Changed comparison to allow current date
        $errors = "Request date cannot be in the past.";
    } else if ($req_date_obj > $max_date) {
        $errors = "Please select a date within the next 60 days.";
    } else {
        // Prepare SQL statement
        $sql = "INSERT INTO bloodreq (user_id, contact_person, bg, hospital, district, locallevel, phone, req_date, req_time, req_pint, br_reason, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $conn->prepare($sql);
            $status = "Pending"; // Set status to "Pending"
            $stmt->bind_param('ssssssssssss', $user_id, $contact_person, $bg, $hospital, $district, $locallevel, $phone, $req_date, $req_time, $req_pint, $br_reason, $status);
            
            $stmt->execute();

            $success = "Blood request submitted successfully!";
        } catch (Exception $e) {
            $errors = "Error submitting request: " . $e->getMessage();
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
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
        .text-black{
            color:black;
        }
</style>
</head>
<body>
<?php 
    include 'include/navbar.php'; 
    ?>

<div class="container-fluid heading-background">
        <h2 class="text-center mb-4">Make Blood request </h2>
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
    <form action="" method="POST" id="addRequestForm">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="contact_person">Contact Person Name</label>
                <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Enter contact person name">
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
                        echo "<option value=\"{$row['id']}\">{$row['district_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="locallevel">Local Level</label>
                <select class="form-control" id="locallevel" name="locallevel">
                    <option value="" disabled selected>Select Local Level</option>
                    <!-- Options will be populated dynamically using JavaScript -->
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone number">
            </div>
            <div class="form-group">
                <label for="req_date">Required Date</label>
                <input type="date" class="form-control" id="req_date" name="req_date">
            </div>
            <div class="form-group">
                <label for="req_time">Required Time</label>
                <input type="time" class="form-control" id="req_time" name="req_time">
            </div>
            <div class="form-group">
                <label for="req_pint">Required Pint <span style="font-size:12px;color:#cc0000;">(1 pint of blood = 473 ml (approx))</span></label>
                <input type="number" class="form-control" id="req_pint" name="req_pint" placeholder="2,4,6,8........">
            </div>
            <div class="form-group">
                <label for="br_reason">Reason</label>
                <input type="text" class="form-control" id="br_reason" name="br_reason" placeholder="Mention reason">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-block custom-submit-btn" name="submit">Submit</button>
    <p class="text-center mt-4 text-black">Wanna view blood requests? <a href="seebloodreq.php" class="text-red">View Requests</a></p>
</form>

</div>

    <br>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
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


<?php 
    include 'include/footer.php'; 
?>
</body>
</html>
