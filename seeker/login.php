<?php
session_start();  // Ensure session is started only once

// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb');
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$errors = array(); 
$invaliderrors = array(); 

// Handle login form submission
if (isset($_POST['login'])) {
    echo "Form submitted!<br>";  // Debugging message

    $identifier = $_POST['identifier']; 

    $password = $_POST['password'];
  $name = $_POST['name']; 
    // Server-side validation
    if (empty($identifier)) {
        $errors[] = "ID or Email is required";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    // Proceed if no validation errors
    if (empty($errors)) {
        // Prepare query to find user by ID or Email
        $query = "SELECT * FROM seekers WHERE (sid = ? OR email = ?)";
        $statement = $conn->prepare($query);
        
        if ($statement === false) {
            $invaliderrors[] = "Failed to prepare the query: " . $conn->error;
        } else {
            $statement->bind_param("ss", $identifier, $identifier);
            if ($statement->execute()) {
                $result = $statement->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    // Verify password
                    if (password_verify($password, $row['password'])) {
                        $_SESSION['sid'] = $row['sid']; // Set session with seeker ID
                        $_SESSION['name'] = $row['name'];
                        // Check and update location (latitude and longitude)
                        if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
                            $latitude = $_POST['latitude'];
                            $longitude = $_POST['longitude'];

                            // Update latitude and longitude in database
                            $updateQuery = "UPDATE seekers SET latitude = ?, longitude = ? WHERE sid = ?";
                            $updateStatement = $conn->prepare($updateQuery);
                            if ($updateStatement === false) {
                                $invaliderrors[] = "Failed to prepare the update query: " . $conn->error;
                            } else {
                                $updateStatement->bind_param("dds", $latitude, $longitude, $_SESSION['sid']);
                                if ($updateStatement->execute()) {
                                    // Redirect to home page after successful login
                                    echo "Login successful!<br>";  // Debugging message
                                    header("Location: home.php");
                                    exit;
                                } else {
                                    $invaliderrors[] = "Failed to update location: " . $updateStatement->error;
                                }
                                $updateStatement->close();
                            }
                        } else {
                            // Redirect if no location update is needed
                            echo "Login successful without location update!<br>";  // Debugging message
                            header("Location: home.php");
                            exit;
                        }
                    } else {
                        $invaliderrors[] = "Invalid password";
                    }
                } else {
                    $invaliderrors[] = "Invalid user ID or email";
                }
            } else {
                $invaliderrors[] = "Failed to execute query: " . $statement->error;
            }

            $statement->close();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .submit-btn input {
            color: white;
            border: none;
            font-size: 14px;
            padding: 12px 0;
            border-radius: 4px;
            background: #0a0a23;
            transition: 0.2s ease;
        }

        .form-container .submit-btn input:hover {
            background: #212529;
        }
    </style>
</head>
<body onload="getUserGeolocation()">
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
                    <!-- Display error messages -->
                    <?php if (!empty($invaliderrors)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($invaliderrors as $error): ?>
                                <p><?php echo htmlspecialchars($error); ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form id="loginForm" action="" method="post">
                        <div class="form-group">
                            <label for="identifier">User ID or Email</label>
                            <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Enter your user ID or email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>

                        <!-- Hidden inputs for latitude and longitude -->
                        <input type="hidden" id="latitudeInput" name="latitude">
                        <input type="hidden" id="longitudeInput" name="longitude">

                        <div class="form-group submit-btn">
                            <input type="submit" class="btn btn-primary btn-block" name="login" value="Login">
                        </div>

                        <hr>
                        <p class="text-center">New User? <a href="register.php">Register here</a></p>
                        <p class="text-center"><a href="../donor/donorregister.php">Register as donor</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getUserGeolocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;
                        console.log("Latitude: " + latitude + ", Longitude: " + longitude);
                        document.getElementById("latitudeInput").value = latitude;
                        document.getElementById("longitudeInput").value = longitude;
                    },
                    function(error) {
                        console.error("Error getting geolocation:", error.message);
                        alert("Unable to retrieve your location. Please ensure location services are enabled and permissions are granted.");
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                console.log("Geolocation is not supported by this browser.");
                alert("Geolocation is not supported by your browser.");
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
