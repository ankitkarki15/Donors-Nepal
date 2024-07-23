<?php
session_start();

$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');

// Function to generate unique mem_id with "DN" prefix
function generateMembershipID($conn) {
    $prefix = "DN";
    $lastNumber = 0;

    // Retrieve the last used number from the database
    $sql = "SELECT MAX(SUBSTRING(user_id, 3)) AS last_number FROM users";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastNumber = intval($row['last_number']);
    }

    // Increment the last used number
    $newNumber = $lastNumber + 1;

    // Construct the mem_id using the new number
    $user_id = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

    return $user_id;
}

function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

$message = ""; // Initialize an empty message variable

if (isset($_POST['register'])) {
    $fullname = sanitizeInput($_POST["fullname"]);
    $email = sanitizeInput($_POST["email"]);
    $phone = sanitizeInput($_POST["phone"]);
    $password = $_POST["password"];

    // Server-side validation
    $errors = array();

    if (empty($fullname)) {
        $errors[] = "Full name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Please enter a 10-digit number.";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (count($errors) === 0) {
        $select = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

        if (mysqli_num_rows($select) > 0) {
            $message = "User already exists!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user_id = generateMembershipID($conn);

            $sql = "INSERT INTO users (user_id, fullname, email, phone, password) 
                    VALUES ('$user_id', '$fullname', '$email', '$phone', '$hashedPassword')";

            $insert = mysqli_query($conn, $sql);

            if ($insert) {
               // Registration successful
               $message = 'Registration successful. <a href="login.php">Login Here</a>';
           } else {
               $message = "Registration failed";
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assests/style/register.css">
    
</head>
<body>
   <div class="container">
      <div class="row justify-content-center">
         <div class="col-md-6 col-lg-5">
            <div class="form-container">
               <div class="logo-container">
               <h4 class="text-center">
            <span style="color: #cc0000;"><b>DONORS</b></span>
            <span class="satisfy-regular">Nepal</span>
        </h4>
        <h6 class="text-center">User Registration</h6>
        <hr>
               </div>
               <form id="registrationForm" action="" method="POST" class="needs-validation" novalidate>
                   <!-- Display message -->
                 <?php if (!empty($message)): ?>
                  <div class="alert alert-primary text-center" role="alert">
                     <?php echo $message; ?>
                  </div>   
                  <?php endif; ?>
                  <div class="form-group">
                     <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name" required>
                     <div class="invalid-feedback">
                        Please provide your full name.
                     </div>
                  </div>
                  <div class="form-group">
                     <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                     <div class="invalid-feedback">
                        Please provide a valid email.
                     </div>
                  </div>
                  <div class="form-group">
                     <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                     <div class="invalid-feedback">
                        Please provide a valid phone number.
                     </div>
                  </div>
                  <div class="form-group">
                     <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                     <div class="invalid-feedback">
                        Please provide a password.
                     </div>
                  </div>
                  <!-- Hidden fields for latitude and longitude -->
                  <!-- <input type="hidden" id="latitude" name="latitude">
                  <input type="hidden" id="longitude" name="longitude">
                   -->
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
                  <p class="text-center">Already have an account? <a href="login.php">Login here</a></p>
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
