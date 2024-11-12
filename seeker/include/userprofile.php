<?php
session_start();
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

if (isset($_SESSION['sid'])) {
    $sid = $_SESSION['sid'];
    
    // Query to fetch data from seekers table
    $query = "
        SELECT name, phone, email, password,
               bg, district, locallevel, dob, gender,
               latitude, longitude
        FROM seekers
        WHERE sid = ?";
    
    $statement = $conn->prepare($query);     
    $statement->bind_param("s", $sid);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Fetch details from seekers table
        $fullname = $row['name'];
        $phone = $row['phone'];
        $email = $row['email'];
        $password = $row['password'];
        $bg = $row['bg'];
        $district = $row['district'];
        $locallevel = $row['locallevel'];
        $dob = $row['dob'];
        $gender = $row['gender'];
        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
    } else {
        echo "No user found.";
    }

    $statement->close();
} 
else {
    echo "User not logged in.";
}

$conn->close();

?>
