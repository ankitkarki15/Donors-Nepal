<?php
session_start();

// Database connection
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

                // Update user's location if available
                if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
                    $latitude = $_POST['latitude'];
                    $longitude = $_POST['longitude'];

                    // Update latitude and longitude in the database
                    $updateQuery = "UPDATE users SET latitude = ?, longitude = ? WHERE user_id = ?";
                    $updateStatement = $conn->prepare($updateQuery);
                    $updateStatement->bind_param("dds", $latitude, $longitude, $_SESSION['user_id']);
                    $updateStatement->execute();
                    $updateStatement->close();
                }

                // Redirect to home page or any other page
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
                   <!-- Hidden inputs for latitude and longitude -->
                  <input type="hidden" id="latitudeInput" name="latitude">
                  <input type="hidden" id="longitudeInput" name="longitude">
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
   
   <script>
   // Function to get user's geolocation
   function getUserGeolocation() {
      if ("geolocation" in navigator) {
         navigator.geolocation.getCurrentPosition(function(position) {
            // Retrieve latitude and longitude
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            
            // Populate the hidden input fields
            document.getElementById("latitudeInput").value = latitude;
            document.getElementById("longitudeInput").value = longitude;
         }, function(error) {
            console.log("Error getting geolocation:", error);
         });
      } else {
         console.log("Geolocation is not supported by this browser.");
      }
   }

   // Call the function to get geolocation when the page loads
   getUserGeolocation();
</script>


   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
