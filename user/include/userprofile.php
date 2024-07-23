<?php
session_start();
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Join query to fetch data from both users and donorreq tables
    $query = "
        SELECT u.fullname, u.phone, u.email, u.password,
               d.bg, d.district, d.locallevel, d.dob, d.gender,
               d.status, d.dr_date, d.availability,
               u.lastdonationdate, u.donationcount
        FROM users u
        LEFT JOIN donorreq d ON u.user_id = d.user_id
        WHERE u.user_id = ?";
    
    $statement = $conn->prepare($query);     
    $statement->bind_param("s", $user_id);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Fetch details from users table
        $fullname = $row['fullname'];
        $phone = $row['phone'];
        $email = $row['email'];
        $password = $row['password'];

        // Fetch details from donorreq table
        $bg = $row['bg'];
        $district = $row['district'];
        $locallevel = $row['locallevel'];
        $dob = $row['dob'];
        $gender = $row['gender'];
        $status = $row['status'];
        $dr_date = $row['dr_date'];
        $availability = $row['availability'];

        // Additional details from users table
        $lastdonationdate = $row['lastdonationdate'];
        $donationcount = $row['donationcount'];
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
