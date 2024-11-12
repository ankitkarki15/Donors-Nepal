<?php
session_start();

// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Function to generate donor ID starting from DN5000
function generateDonorID($conn) {
    $prefix = "DN";
    $startNumber = 5000;

    // Retrieve the last donor number from the database
    $sql = "SELECT MAX(CAST(SUBSTRING(drid, 3) AS UNSIGNED)) AS last_number FROM donors";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastNumber = intval($row['last_number']);
        if ($lastNumber < $startNumber) {
            $lastNumber = $startNumber - 1;
        }
    } else {
        $lastNumber = $startNumber - 1; // Start from DN5000
    }

    // Increment the last used number
    $newNumber = $lastNumber + 1;

    // Construct the donor ID using the new number
    $drid = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

    return $drid;
}

function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

$message = ""; // Initialize an empty message variable
$errors = array(); // Initialize errors array

if (isset($_POST['register'])) {
    // Sanitize and validate inputs as before
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $bg = sanitizeInput($_POST['bg']);
    $phone = sanitizeInput($_POST['phone']);
    $district = 'Kathmandu';  // Since it's always Kathmandu
    $locallevel = sanitizeInput($_POST['locallevel']);
    $medical_conditions = sanitizeInput($_POST['medical_conditions']);
    $disease = isset($_POST['disease']) ? sanitizeInput($_POST['disease']) : 'No';
    $dob = sanitizeInput($_POST['dob']);

    // Fetch latitude and longitude for the selected local level
    $query = "SELECT latitude, longitude FROM locallevels WHERE locallevel_name = '$locallevel'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];

    // Add age calculation
    $dob = new DateTime($dob);
    $today = new DateTime('today');
    $age = $dob->diff($today)->y;

    if ($age < 18 || $age > 65) {
        $errors[] = 'You must be between 18 and 65 years old to donate blood.';
    }

    // Format the DateTime object for SQL query
    $dobFormatted = $dob->format('Y-m-d');

    // Continue with registration logic, store latitude and longitude in the donors table
    if (empty($errors)) {
        $drid = generateDonorID($conn);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO donors (drid, name, email, password, bg, phone, district, locallevel, availability, latitude, longitude, medical_conditions, is_eligible, status, dob)
                VALUES ('$drid', '$name', '$email', '$hashedPassword', '$bg', '$phone', '$district', '$locallevel', 1, '$latitude', '$longitude', '$medical_conditions', TRUE, 'Pending', '$dobFormatted')";

        $insert = mysqli_query($conn, $sql);

        if ($insert) {
            $message = 'Registration successful. <a href="login.php">Login Here</a>';
        } else {
            $message = "Registration failed: " . mysqli_error($conn);
        }
    } else {
        $message = implode('<br>', $errors);
    }

    // Pass the message to the session
    $_SESSION['message'] = $message;

    // Redirect back to the form page to display the message
    header("Location: donorlogin.php");
    exit();
}
