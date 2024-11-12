<?php
session_start();

// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb');

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$errors = array(); // Initialize the errors array
$invaliderrors = array(); // Initialize the invalid errors array

if (isset($_POST['login'])) {
    $identifier = $_POST['identifier']; // Use identifier instead of user_id or email
    $password = $_POST['password'];

    // Server-side validation
    if (empty($identifier)) {
        $errors[] = "ID or Email is required";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        // Prepare and execute the query
        $query = "SELECT * FROM seekers WHERE (sid = ? OR email = ?)";
        $statement = $conn->prepare($query);
        $statement->bind_param("ss", $identifier, $identifier);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['sid'] = $row['sid']; // Store seeker ID in session

                // Update seeker's location if available
                if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
                    $latitude = $_POST['latitude'];
                    $longitude = $_POST['longitude'];

                    // Update latitude and longitude in the database
                    $updateQuery = "UPDATE seekers SET latitude = ?, longitude = ? WHERE sid = ?";
                    $updateStatement = $conn->prepare($updateQuery);
                    $updateStatement->bind_param("dds", $latitude, $longitude, $_SESSION['sid']);
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
<?php 
include 'include/frontnavbar.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Bootstrap CSS -->
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <!-- Poppins Font -->
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
   <title>User Login</title>
   <style>
       @import url('https://fonts.googleapis.com/css2?family=Satisfy&display=swap');

        .satisfy-regular {
            font-family: "Satisfy", cursive;
            font-weight: 400;
            font-style: normal;
            color: blue;
            font-size: 32px; /* Increased font size */
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Style for the form container */
        form {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        /* Style for form elements */
        form div {
            margin-bottom: 15px;
        }

        /* Style for labels */
        label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        /* Style for inputs */
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }

        /* Style for the button */
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error-text {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .message {
            background: #0a0a23;
            color: red;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .message:hover {
            opacity: 0.8;
        }
   </style>
   <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }

        window.onload = getLocation; // Trigger the function when the page loads
   </script>
</head>
<body>
    <form action="login.php" method="post">
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
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div>
                <label for="identifier">ID or Email:</label>
                <input type="text" id="identifier" name="identifier">
                <?php if (isset($errors) && in_array("ID or Email is required", $errors)) echo '<p class="error-text">ID or Email is required</p>'; ?>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <?php if (isset($errors) && in_array("Password is required", $errors)) echo '<p class="error-text">Password is required</p>'; ?>
            </div>
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <div>
                <button type="submit" name="login">Login</button>
            </div>
            <hr>
            <p class="text-center">New User? <a href="register.php">Register here</a></p>
            <p class="text-center"><a href="../seeker/donorlogin.php">Register as donor</a></p>
        </div>      
    </form>
</body>
</html>