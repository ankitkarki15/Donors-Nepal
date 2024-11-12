<?php 

session_start();
include '../include/navbar.php'; 

$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION['sid'])) {
    $sid = $_SESSION['sid'];
    
    // Fetch user details from seekers table
    $query = "
        SELECT name, email, phone, bg, gender, district, locallevel, dob
        FROM seekers
        WHERE sid = ?";
    
    $statement = $conn->prepare($query);
    $statement->bind_param("s", $sid);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Fetch details from seekers table
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
        $bg = $row['bg'];
        $dob = $row['dob'];
        $gender = $row['gender'];
        $district = $row['district'];
        $locallevel = $row['locallevel'];
    } else {
        echo "No profile found.";
        exit;
    }

    $statement->close();
} else {
    echo "User not logged in.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $bg = $_POST['blood_group'];
    $gender = $_POST['gender'];
    $district = $_POST['district'];
    $locallevel = $_POST['locallevel'];

    // Debugging output
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Update query
    $update_query = "
        UPDATE seekers 
        SET name = ?, phone = ?, dob = ?, bg = ?, gender = ?, district = ?, locallevel = ?
        WHERE sid = ?";
    
    $statement = $conn->prepare($update_query);
    $statement->bind_param("ssssssss", $name, $phone, $dob, $bg, $gender, $district, $locallevel, $sid);
    
    if ($statement->execute()) {
        echo "<script>alert('Profile updated successfully.');</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<script>alert('Error: " . $statement->error . "');</script>";
    }
    
    $statement->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            border: 2px solid white;
        }
        .container {
            margin-top: 50px;
            margin-bottom: 70px;
        }
        .profile-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .profile-card .labels {
            font-weight: bold;
        }
        .profile-button {
            border: none;
            color: white;
        }
        .profile-button:hover {
            background-color: #990000;
        }
        .bg {
            background-color: #cc0000;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            font-size: 36px;
            font-weight: bold;
            border-radius: 50%;
            text-transform: uppercase;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container rounded bg-white">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <span class="bg"><?php echo $bg; ?></span>
                <span class="font-weight-bold mt-3"><?php echo $name; ?></span>
                <span class="text-black"><?php echo $email; ?></span>
                <span class="text-black">ID: <strong><?php echo $sid; ?></strong></span>
            </div>
        </div>
        <div class="col-md-9">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right"><u>Profile Settings</u></h4>
                    <button class="btn btn-primary" id="editProfileBtn" type="button">Edit Profile</button>
                    <button class="btn btn-primary" id="saveProfileBtn" type="submit" style="display:none;">Save Changes</button>
                </div>
                <form id="profileForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="labels">Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Mobile Number</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="labels">DOB</label>
                            <input type="date" class="form-control" name="dob" value="<?php echo $dob; ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Blood Group</label>
                            <select class="form-control" name="blood_group" disabled>
                                <option value="">Select Blood Group</option>
                                <option value="A+" <?php if ($bg == 'A+') echo 'selected'; ?>>A+</option>
                                <option value="A-" <?php if ($bg == 'A-') echo 'selected'; ?>>A-</option>
                                <option value="B+" <?php if ($bg == 'B+') echo 'selected'; ?>>B+</option>
                                <option value="B-" <?php if ($bg == 'B-') echo 'selected'; ?>>B-</option>
                                <option value="AB+" <?php if ($bg == 'AB+') echo 'selected'; ?>>AB+</option>
                                <option value="AB-" <?php if ($bg == 'AB-') echo 'selected'; ?>>AB-</option>
                                <option value="O+" <?php if ($bg == 'O+') echo 'selected'; ?>>O+</option>
                                <option value="O-" <?php if ($bg == 'O-') echo 'selected'; ?>>O-</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="labels">Gender</label>
                            <select class="form-control" name="gender" disabled>
                                <option value="">Select Gender</option>
                                <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                                <option value="Other" <?php if ($gender == 'Other') echo 'selected'; ?>>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">District</label>
                            <input type="text" class="form-control" name="district" value="<?php echo $district; ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Locality</label>
                            <input type="text" class="form-control" name="locallevel" value="<?php echo $locallevel; ?>" readonly>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("editProfileBtn").addEventListener("click", function() {
        let form = document.getElementById("profileForm");
        let inputs = form.querySelectorAll("input");
        let selects = form.querySelectorAll("select");

        inputs.forEach(input => input.removeAttribute("readonly"));
        selects.forEach(select => select.removeAttribute("disabled"));
        
        document.getElementById("saveProfileBtn").style.display = "inline-block";
        this.style.display = "none";
    });
</script>

<?php
include '../include/footer.php'; 
?>
</body>
</html>
