<?php
session_start();

// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');


// Function to generate donor ID starting from DN5000
function generateDonorID($conn) {
    $prefix = "DN";
    $startNumber = 5000;

    // Retrieve the last donor number from the database
    $sql = "SELECT MAX(CAST(SUBSTRING(drid, 3) AS UNSIGNED)) AS last_number FROM donors";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastNumber = intval($row['last_number']);
        if ($lastNumber < $startNumber) {
            $lastNumber = $startNumber - 1;
        }
    } else {
        $lastNumber = $startNumber - 1; 
    }

    // Increment the last used number
    $newNumber = $lastNumber + 1;

    // Construct the donor ID using the new number
    $drid = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

    return $drid;
}

function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

$message = ""; // Initialize an empty message variable
$errors = array(); // Initialize errors array

if (isset($_POST['register'])) {
    // Sanitize and validate inputs
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $bg = sanitizeInput($_POST['bg']);
    $phone = sanitizeInput($_POST['phone']);
    $district = sanitizeInput($_POST['district']);
    $locallevel = sanitizeInput($_POST['locallevel']);
    $medical_conditions = sanitizeInput($_POST['medical_conditions']);
    $latitude = sanitizeInput($_POST['latitude']);
    $longitude = sanitizeInput($_POST['longitude']);
    $disease = isset($_POST['disease']) ? sanitizeInput($_POST['disease']) : 'No';
    $dob = sanitizeInput($_POST['dob']); // Capturing the DOB

    // Server-side validation
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    if (empty($bg)) {
        $errors[] = "Blood group is required";
    }
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    }
    if (empty($district)) {
        $errors[] = "District is required";
    }
    if (empty($locallevel)) {
        $errors[] = "Local level is required";
    }
    if (empty($dob)) {
        $errors[] = "Date of Birth is required";
    }

    // Set latitude and longitude to NULL if they are empty
    $latitude = !empty($latitude) ? "'$latitude'" : 'NULL';
    $longitude = !empty($longitude) ? "'$longitude'" : 'NULL';

    if (empty($errors)) {
        $drid = generateDonorID($conn);
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert into the database including the DOB
        $sql = "INSERT INTO donors (drid, name, email, password, bg, phone, district, locallevel, availability, latitude, longitude, medical_conditions, is_eligible, status, dob)
                VALUES ('$drid', '$name', '$email', '$hashedPassword', '$bg', '$phone', '$district', '$locallevel', 1, $latitude, $longitude, '$medical_conditions', TRUE, 'Pending', '$dob')";

        $insert = mysqli_query($conn, $sql);

        if ($insert) {
            // Registration successful
          $message = 'Registration successful. <a href="login.php">Login Here</a>';
        } else {
            $message = "Registration failed: " . mysqli_error($conn);
        }
    } else {
        $message = implode('<br>', $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Donor Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- <style>
        body {
            font-family: 'Poppins', sans-serif;
        
            background-color: #f8f9fa;
        }
        
        .form-container {
            background: #ffffff;
            padding: 15px; /* Compact padding */
            border-radius: 4px;
            width: 90%; /* Narrower width */
            max-width: 600px; /* Max width for better readability */
            margin: 20px auto; /* Centered form with margin */
        }
        
        .card {
            border: 1px solid #ddd; /* Simplified border */
            border-radius: 4px; /* Rounded corners */
            margin-bottom: 15px; /* Reduced margin */
        }
        
        .card-header {
            background-color: #007bff; /* Simplified color */
            color: #ffffff;
            padding: 10px;
        }
        
        .form-group label {
            font-size: 0.875rem; /* Reduced font size */
        }
        
        .form-group input, .form-group select, .form-group textarea {
            font-size: 0.875rem; /* Reduced font size */
        }
        
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: #007bff; /* Highlight border color on focus */
            outline: none;
        }
        
        .submit-btn {
            margin-top: 15px;
        }
        
        .text-center a {
            color: #007bff; /* Simplified link color */
        }
    </style> -->
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h4 class="text-center">Donor Registration</h4>
            <form id="donorRegisterForm" action="" method="POST" class="needs-validation" novalidate>
                <!-- Personal Details -->
                <div class="card">
                    <div class="card-header">
                        Personal Details
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                            <div class="invalid-feedback">
                                Please enter your name.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password *</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            <div class="invalid-feedback">
                                Please enter your password.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bg">Blood Group *</label>
                            <select class="form-control" id="bg" name="bg" required>
                                <option value="" disabled selected>Select your blood group</option>
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
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                            <div class="invalid-feedback">
                                Please enter your phone number.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth *</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                            <div class="invalid-feedback">
                                Please enter your date of birth.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="card">
                    <div class="card-header">
                        Address
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="district">District *</label>
                            <select class="form-control" id="district" name="district" required>
                                <option value="" disabled selected>Select District</option>
                                <?php
                                $query = "SELECT * FROM districts ORDER BY district_name";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value=\"{$row['district_name']}\">{$row['district_name']}</option>";
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a district.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="locallevel">Local Level *</label>
                            <select class="form-control" id="locallevel" name="locallevel" required>
                                <option value="" disabled selected>Select Local Level</option>
                                <?php
                                $query = "SELECT * FROM locallevels ORDER BY locallevel_name";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value=\"{$row['locallevel_name']}\">{$row['locallevel_name']}</option>";
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a local level.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs for latitude and longitude -->
                <input type="hidden" id="latitudeInput" name="latitude">
                        <input type="hidden" id="longitudeInput" name="longitude">
                <!-- Medical Details -->
                <div class="card">
                    <div class="card-header">
                        Medical Details
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Are you suffering from any kind of blood-related diseases? *</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="disease_yes" name="disease" value="Yes">
                                <label class="form-check-label" for="disease_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="disease_no" name="disease" value="No" checked>
                                <label class="form-check-label" for="disease_no">No</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="medical_conditions">Medical Conditions (if any)</label>
                            <textarea class="form-control" id="medical_conditions" name="medical_conditions" rows="3" placeholder="Describe any medical conditions..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group submit-btn">
                    <input type="submit" class="btn btn-primary btn-block" name="register" value="Register">
                </div> 

                <hr>
                <p class="text-center">Already have an account? <a href="donorlogin.php">Login here</a></p>
                <p class="text-center"><a href="../seeker/login.php">Back to seeker login</a></p>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    // Function to handle form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var form = document.getElementById('donorRegisterForm');
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }, false);
    })();

    // Function to handle the location data
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('latitudeInput').value = position.coords.latitude;
                    document.getElementById('longitudeInput').value = position.coords.longitude;
                    console.log("Latitude: " + position.coords.latitude);
                    console.log("Longitude: " + position.coords.longitude);
                },
                function(error) {
                    console.error('Error getting location:', error.message);
                    alert('Error getting location: ' + error.message);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000, // Increased timeout to 10 seconds
                    maximumAge: 0
                }
            );
        } else {
            console.error('Geolocation is not supported by this browser.');
            alert('Geolocation is not supported by this browser.');
        }
    }

    // Call the function to get the location on page load
    window.onload = function() {
        getLocation();
    };
</script>
<script>
    $(document).ready(function () {
        $('#district').on('change', function () {
            var districtName = $(this).val();
            if (districtName) {
                $.ajax({
                    type: 'POST',
                    url: 'ajaxLocalLevels.php',
                    data: { district_name: districtName },
                    success: function (html) {
                        $('#locallevel').html(html);
                    }
                });
            } else {
                $('#locallevel').html('<option value="">Select District First</option>');
            }
        });
    });
</script>

</body>
</html>
