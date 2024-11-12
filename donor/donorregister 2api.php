<?php
include 'include/donorregister.php';
// include 'include/update_coordinates.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h4 class="text-center">Donor Registration</h4>
            <form id="donorRegisterForm" action="" method="POST" class="needs-validation" novalidate>
                <!-- Personal Details -->
                <div class="card">
                    <div class="card-header">Personal Details</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                            <div class="invalid-feedback">Please enter your name.</div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password *</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            <div class="invalid-feedback">Please enter your password.</div>
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
                            <div class="invalid-feedback">Please select a blood group.</div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                            <div class="invalid-feedback">Please enter your phone number.</div>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth *</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                            <div class="invalid-feedback">Please enter your date of birth.</div>
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="card">
                    <div class="card-header">Address</div>
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
                            <div class="invalid-feedback">Please select a district.</div>
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
                            <div class="invalid-feedback">Please select a local level.</div>
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs for latitude and longitude -->
                <input type="hidden" id="latitudeInput" name="latitude">
                <input type="hidden" id="longitudeInput" name="longitude">

                <!-- Medical Details -->
                <div class="card">
                    <div class="card-header">Medical Details</div>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    // Handle form validation
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

