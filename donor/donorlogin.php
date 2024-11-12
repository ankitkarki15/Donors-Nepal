    <?php
   session_start();

   // Database connection
   $conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb');
   
   if (!$conn) {
       die('Connection failed: ' . mysqli_connect_error());
   }
   
   $errors = array(); 
   $invaliderrors = array(); 
   
   if (isset($_POST['login'])) {
       $identifier = $_POST['identifier']; 
       $password = $_POST['password'];
       $latitude = $_POST['latitude']; // Get latitude from form
       $longitude = $_POST['longitude']; // Get longitude from form
   
       // Server-side validation
       if (empty($identifier)) {
           $errors[] = "ID or Email is required";
       }
   
       if (empty($password)) {
           $errors[] = "Password is required";
       }
   
       if (empty($errors)) {
           // Prepare and execute the query to fetch donor data (including status)
           $query = "SELECT * FROM donors WHERE (drid = ? OR email = ?)";
           $statement = $conn->prepare($query);
           $statement->bind_param("ss", $identifier, $identifier);
           $statement->execute();
           $result = $statement->get_result();
   
           if ($result->num_rows > 0) {
               $row = $result->fetch_assoc();
   
               // Log the status value for debugging
               error_log('Status: ' . $row['status']); // Log status for review
   
               // Check password
               if (password_verify($password, $row['password'])) {
   
                   // Convert status to lowercase for case-insensitive comparison
                   $status = strtolower(trim($row['status']));
   
                   // Check if the donor's registration status is approved
                   if ($status === 'approved') {
                       $_SESSION['drid'] = $row['drid']; 
   
                       // Update the donor's latitude and longitude
                       $updateQuery = "UPDATE donors SET latitude = ?, longitude = ? WHERE drid = ?";
                       $updateStatement = $conn->prepare($updateQuery);
                       $updateStatement->bind_param("dds", $latitude, $longitude, $row['drid']);
                       $updateStatement->execute();
                       $updateStatement->close();
   
                       // Redirect to donor dashboard
                       header("Location:donordash.php");
                       exit;
                   } else {
                       // If the donor is not approved, show an appropriate message
                       $invaliderrors[] = "Your registration process is still pending. Please visit soon to get updated.";
                   }
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

<?php
    // include '../seeker/include/frontnavbar.php'
?>
<br>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Donor Login</title>
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- Poppins Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
<script>
function getUserGeolocation() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                console.log("Latitude: " + latitude + ", Longitude: " + longitude); // Log to console
                document.getElementById("latitudeInput").value = latitude;
                document.getElementById("longitudeInput").value = longitude;
            },
            function(error) {
                console.error("Error getting geolocation:", error.message);
                alert("Unable to retrieve your location. Please ensure location services are enabled and permissions are granted.");
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        console.log("Geolocation is not supported by this browser.");
        alert("Geolocation is not supported by your browser.");
    }
}

window.onload = function() {
    getUserGeolocation();
};
</script>
</head>
<body style="font-family: 'Poppins', sans-serif;">

<div class="container" style="margin-top: 40px;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="form-container" style="padding: 10px; border-radius: 5px;">
                <div class="logo-container" style="margin-bottom: 10px;">
                    <h4 class="text-center" style="color: black;">
                        <span style="color: #cc0000;"><b>DONORS</b></span>
                        <span style="font-family: 'Satisfy', cursive;">Nepal</span>
                    </h4>
                    <h6 class="text-center" style="color: black; margin-top: 10px;">Donor Login</h6>
                    <hr style="border-color: #cc0000;">
              
                </div>
                <?php if (!empty($invaliderrors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($invaliderrors as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form id="loginForm" action="" method="post">
                    <input type="hidden" id="latitudeInput" name="latitude"> <!-- Hidden input for latitude -->
                    <input type="hidden" id="longitudeInput" name="longitude"> <!-- Hidden input for longitude -->
                    <div class="form-group">
                        <label for="identifier" style="color: black; font-size:14px;">User ID or Email</label>
                        <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Enter your user ID or email" style="padding: 8px;color: black; font-size:14px;">
                        <?php if (isset($errors) && in_array("ID or Email is required", $errors)) echo '<p class="error-text" style="color: red;">ID or Email is required</p>'; ?>
                    </div>
                    <div class="form-group">
                        <label for="password"style="color: black; font-size:14px;">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" style="padding: 8px;color: black; font-size:14px;">
                        <?php if (isset($errors) && in_array("Password is required", $errors)) echo '<p class="error-text" style="color: red;">Password is required</p>'; ?>
                    </div>
                    
                    <div class="form-group submit-btn" style="text-align: center;">
                        <input type="submit" class="btn-lg" style="background-color: #0a0a23; color: white; padding: 8px 110px; font-size: 16px;" name="login" value="Login">
                    </div>
                    <hr style="border-color: #ccc;">
                    <p class="text-center">New Donor? <a href="donorregister.php" style="color: #0a0a23;">Register here</a></p>
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
