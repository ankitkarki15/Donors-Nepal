<?php
include 'include/dregister.php';
session_start(); 

// Fetch the message from the session and then clear it
$message = isset($_SESSION['message']) ?
 $_SESSION['message'] : '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assests/style/donorregister.css">  
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h4 class="text-center">Donor Registration</h4>
            <?php if ($message): ?>
                <div class="alert alert-info">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form id="donorRegisterForm" action="donorregister.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <!-- Personal Details -->
                <div class="card mb-3">
                    <div class="card-header">Personal Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                                    <div class="invalid-feedback">Please enter your name.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bg">Blood Group <span class="text-danger">*</span></label>
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
                                    <div class="invalid-feedback">Please select a blood group.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                                    <div class="invalid-feedback">Please enter your phone number.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dob">Date of Birth *</label>
                                    <input type="date" class="form-control" id="dob" name="dob" required>
                                    <div class="invalid-feedback">Please enter your date of birth.</div>
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender">Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="" disabled selected>Select your Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="others">Others</option>
                                    </select>
                                    <div class="invalid-feedback">Please select your gender.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Password *</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                    <div class="invalid-feedback">Please enter your password.</div>
                                    <small id="passwordHelpBlock" class="form-text text-muted">
                                        Must be 8-20 characters long, contain letters and numbers, and must not contain spaces or special characters.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="card mb-3">
                    <div class="card-header">Address</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
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
                                    <div class="invalid-feedback">Please select a district.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="locallevel">Local Level *</label>
                                    <select class="form-control" id="locallevel" name="locallevel" required>
                                        <option value="" disabled selected>Select Local Level</option>
                                        <?php
                                        $query = "SELECT locallevel_name, latitude, longitude FROM locallevels ORDER BY locallevel_name";
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $latitude = $row['latitude'] !== NULL ? $row['latitude'] : '0.00000';
                                            $longitude = $row['longitude'] !== NULL ? $row['longitude'] : '0.00000';
                                            echo "<option value=\"{$row['locallevel_name']}\" data-lat=\"{$latitude}\" data-lng=\"{$longitude}\">{$row['locallevel_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">Please select a local level.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs for latitude and longitude -->
                <input type="hidden" id="latitudeInput" name="latitude">
                <input type="hidden" id="longitudeInput" name="longitude">
                
                <!-- Personal Documents -->
                <div class="card mb-3">
                    <div class="card-header">Uploads</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="personal_documents">Personal Documents</label>
                                    <input type="file" class="form-control-file" id="personal_documents" name="personal_documents" required>
                                    <small class="form-text text-muted">Accepted formats: PDF, JPG, PNG. Only one file allowed.</small>
                                    <div class="invalid-feedback">Please upload your documents.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="medical_documents">Medical Proofs</label>
                                    <input type="file" class="form-control-file" id="medical_documents" name="medical_documents" required>
                                    <small class="form-text text-muted">Accepted formats: PDF, JPG, PNG. Only one file allowed.</small>
                                    <div class="invalid-feedback">Please upload a medical document.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Terms and Conditions -->
                 <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="terms_conditions" name="terms_conditions" required>
                    <label class="form-check-label" for="terms_conditions">I agree to the <a href="#">terms and conditions</a>.</label>
                    <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
                <hr>
                <p class="text-center">Already have an account? <a href="donorlogin.php">Login here</a></p>
                <p class="text-center"><a href="../seeker/login.php">Back to seeker login</a></p>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Custom JavaScript for form validation
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                var form = document.getElementById('donorRegisterForm');
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            }, false);
        })();
    </script>
</body>
</html>
