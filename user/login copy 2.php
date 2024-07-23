<?php
session_start();

$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn');

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$errors = array(); // Initialize the errors array outside the if block

if (isset($_POST['login'])) {
    $identifier = $_POST['identifier']; // Use identifier instead of user_id or email
    $password = $_POST['password'];

    // Server-side validation
    if (empty($identifier)) { // Check if identifier is empty
        $errors[] = "User ID or Email is required";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        // Prepare and execute the query
        $query = "SELECT * FROM users WHERE (user_id = ? OR email = ?)";
        $statement = $conn->prepare($query);
        $statement->bind_param("ss", $identifier, $identifier); // Bind the same identifier for both parameters
        $statement->execute();
        // Get the result
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id'];
                // User login successful
                header("Location: home.php");
                exit;
            } else {
                $invaliderrors[] = "Invalid password";
            }
        } else {
            $invaliderrors[] = "Invalid user ID or email";
        }

        $statement->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>Login</title>
   <!-- Bootstrap CSS -->
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <!-- Poppins Font -->
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="assests/style/login.css">
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
                  <h6 class="text-center">User Login</h6>
                  <hr>
               </div>
               <?php if (!empty($invaliderrors)): ?>
                  <div class="alert alert-danger">
                     <?php foreach ($invaliderrors as $error): ?>
                        <p><?php echo $error; ?></p>
                     <?php endforeach; ?>
                  </div>
               <?php endif; ?>
               <form id="loginForm" action="" method="post">
               
                  <div class="form-group">
                     <label for="identifier">User ID or Email</label>
                     <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Enter your user ID or email">
                     <?php if (isset($errors) && in_array("User ID or Email is required", $errors)) echo '<p class="error-text">User ID or Email is required</p>'; ?>
                  </div>
                  <div class="form-group">
                     <label for="password">Password</label>
                     <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                     <?php if (isset($errors) && in_array("Password is required", $errors)) echo '<p class="error-text">Password is required</p>'; ?>
                  </div>
                  <div class="form-group submit-btn">
                     <input type="submit" class="btn btn-primary btn-block" name="login" value="Login">
                  </div>
                  <hr>
                  <p class="text-center">New User? <a href="register.php">Register here</a></p>
                  <!-- <p class="text-center"><a href="#">Go back</a></p> -->
               </form>
            </div>
         </div>
      </div>
   </div>
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
