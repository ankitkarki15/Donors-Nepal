<?php
session_start();
include './include/navbar.php';

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

// Handle form submission for profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $bg = $_POST['blood_group'];
    $gender = $_POST['gender'];
    $district = $_POST['district'];
    $locallevel = $_POST['locallevel'];

    // Update query
    $update_query = "
        UPDATE seekers 
        SET name = ?, phone = ?, dob = ?, bg = ?, gender = ?, district = ?, locallevel = ?
        WHERE sid = ?";
    
    $statement = $conn->prepare($update_query);
    $statement->bind_param("ssssssss", $name, $phone, $dob, $bg, $gender, $district, $locallevel, $sid);
    
    if ($statement->execute()) {
        echo "<script>alert('Profile updated successfully.'); window.location.href='myprofile.php';</script>";
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
    <title>Edit Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
    
    <style>
        body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f5f7;
    margin: 0;
    padding: 0;
}

.container {
    margin-top: 50px;
    margin-bottom: 70px;
}

.profile-card {
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    background-color: #fff;
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease-in-out;
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
}

.profile-button {
    background-color: #cc0000;
    color: white;
    border-radius: 5px;
    padding: 10px 20px;
    font-weight: bold;
    transition: background-color 0.3s ease;
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

form .form-group {
    margin-bottom: 20px;
}

form .form-control {
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    padding: 10px 15px;
    transition: border-color 0.3s ease;
}

form .form-control:focus {
    border-color: #cc0000;
    box-shadow: 0 0 8px rgba(204, 0, 0, 0.1);
}

h4 {
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
}

p {
    color: #555;
    margin-bottom: 10px;
}

@media (max-width: 768px) {
    .container {
        margin-top: 20px;
    }
    
    .profile-card {
        margin-bottom: 20px;
    }
    
    form .form-group {
        margin-bottom: 15px;
    }
}

    </style>
</head>
<body>
<br><br><br>
<div class="container">

    <div class="row">
        <div class="col-md-4">
            <div class="profile-card text-center">
                <span class="bg"><?php echo $bg; ?></span>
                <h4 class="mt-3"><?php echo $name; ?></h4>
                <p><?php echo $email; ?></p>
                <p>ID: <strong><?php echo $sid; ?></strong></p>
            </div>
        </div>
        <div class="col-md-8">
            <div class="profile-card">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <h4>Edit Profile</h4>    
                <div class="form-row">
                        <!-- First column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>DOB</label>
                                <input type="date" class="form-control" name="dob" value="<?php echo $dob; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Blood Group</label>
                                <select class="form-control" name="blood_group" required>
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

                        <!-- Second column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="form-control" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                                    <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                                    <option value="Other" <?php if ($gender == 'Other') echo 'selected'; ?>>Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>District</label>
                                <input type="text" class="form-control" name="district" value="<?php echo $district; ?>" required>
                            </div>
                                    
                        </div>
                    </div>
                    <button class="btn btn-primary profile-button" type="submit">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include './include/footer.php';
?>

</body>
</html>
