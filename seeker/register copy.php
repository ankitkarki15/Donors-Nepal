<?php
session_start();

// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

function generateMembershipID($conn) {
    $prefix = "DN";
    $lastNumber = 100;

    // Retrieve the last used number from the database
    $sql = "SELECT MAX(SUBSTRING(sid, 3)) AS last_number FROM seekers";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastNumber = intval($row['last_number']);
    }

    // Increment the last used number
    $newNumber = $lastNumber + 1;

    // Construct the mem_id using the new number
    $sid = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

    return $sid;
}

function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

$message = ""; // Initialize an empty message variable
$errors = array(); // Initialize errors array

if (isset($_POST['register'])) {
    
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $bg = sanitizeInput($_POST['bg']);
    $phone = sanitizeInput($_POST['phone']);
    $password = sanitizeInput($_POST['password']);

    // Server-side validation
    if (empty($name)) {
        $errors[] = "Full name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($bg)) {
        $errors[] = "Blood group is required";
    }

    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Please enter a 10-digit number.";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        // Check if email already exists
        $select = mysqli_query($conn, "SELECT * FROM seekers WHERE email = '$email'");

        if (mysqli_num_rows($select) > 0) {
            $errors[] = "User already exists";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sid = generateMembershipID($conn);

            $sql = "INSERT INTO seekers (sid, name, email, bg, phone, password) VALUES
                     ('$sid', '$name', '$email', '$bg', '$phone', '$hashedPassword')";

            $insert = mysqli_query($conn, $sql);

            if ($insert) {
                // Registration successful
                $message = 'Registration successful. <a href="login.php">Login Here</a>';
            } else {
                $message = "Registration failed: " . mysqli_error($conn);
            }
        }
    } else {
        $message = implode('<br>', $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>Register</title>
   <!-- Bootstrap CSS -->
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <!-- Poppins Font -->
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="assests/style/register.css">
</head>
<body>
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-md-8 col-lg-6">
            <div class="form-container">
               <div class="logo-container">
                  <h4 class="text-center">
                     <span style="color: #cc0000;"><b>DONORS</b></span>
                     <span class="satisfy-regular">Nepal</span>
                  </h4>
                  <h6 class="text-center">User Registration</h6>
                 
                  <hr>
               </div>
               <form id="registerForm" action="" method="POST" class="needs-validation" novalidate>
                  <!-- Display message -->
                  <?php if (!empty($message)): ?>
                  <div class="alert alert-primary text-center" role="alert">
                     <?php echo $message; ?>
                  </div>   
                  <?php endif; ?>

                  <div class="form-group">
                    <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                            <div class="invalid-feedback">
                                Please provide a name.
                    </div>
                  </div>
                  <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            <div class="invalid-feedback">
                                Please provide a valid email address.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bg">Blood Group</label>
                            <select class="form-control" id="bg" name="bg" required>
                                <option value="">Select your blood group</option>
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
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                            <div class="invalid-feedback">
                                Please provide a phone number.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            <div class="invalid-feedback">
                                Please provide a password.
                            </div>
                        </div>
                  <div class="form-group form-check">
                     <input class="form-check-input" type="checkbox" value="" id="terms" required>
                     <label class="form-check-label" for="terms">
                        Agree to terms and conditions
                     </label>
                     <div class="invalid-feedback">
                        You must agree before submitting.
                     </div>
                  </div>

                  <div class="form-group submit-btn">
                     <input type="submit" class="btn btn-primary btn-block" name="register" value="Register">
                  </div>
                  <hr>
                  <p class="text-center">Already have an account? <a href="login.php">Login here</a></p>
                  <p class="text-center"><a href="../donor/donorregister.php">Register as donor</a></p>
                </form>
            </div>
         </div>
      </div>
   </div>

   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
</body>
