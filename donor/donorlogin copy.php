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
            // Prepare and execute the query
            $query = "SELECT * FROM donors WHERE (drid = ? OR email = ?)";
            $statement = $conn->prepare($query);
            $statement->bind_param("ss", $identifier, $identifier);
            $statement->execute();
            $result = $statement->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    $_SESSION['drid'] = $row['drid']; 

                    // Update the donor's latitude and longitude
                    $updateQuery = "UPDATE donors SET latitude = ?, longitude = ? WHERE drid = ?";
                    $updateStatement = $conn->prepare($updateQuery);
                    $updateStatement->bind_param("dds", $latitude, $longitude, $row['drid']);
                    $updateStatement->execute();
                    $updateStatement->close();

                    header("Location:donordash.php");
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

    <?php
    include '../seeker/include/frontnavbar.php'
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
    <link rel="stylesheet" href="assets/style/login.css">
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
        getUserGeolocation(); // Call the geolocation function on page load
    };
    </script>
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
                    <h6 class="text-center">Donor Login</h6>
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
                    <input type="hidden" id="latitudeInput" name="latitude"> <!-- Hidden input for latitude -->
                    <input type="hidden" id="longitudeInput" name="longitude"> <!-- Hidden input for longitude -->
                    <div class="form-group">
                        <label for="identifier">User ID or Email</label>
                        <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Enter your user ID or email">
                        <?php if (isset($errors) && in_array("ID or Email is required", $errors)) echo '<p class="error-text">ID or Email is required</p>'; ?>
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
                    <p class="text-center">New Donor? <a href="donorregister.php">Register here</a></p>
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
