<?php
session_start();
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');

$message = ""; // Initialize a variable to hold the update message

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Extract the updated profile information from the form
        $fullname = $_POST['fullname'];
        $phone = $_POST['phone'];
        // Add more fields as needed
        
        // Update the user's profile in the database
        $update_query = "UPDATE users SET fullname=?, phone=? WHERE user_id=?";
        $statement = $conn->prepare($update_query);
        $statement->bind_param("sss", $fullname, $phone, $user_id);
        $statement->execute();

        if ($statement->affected_rows > 0) {
            $message = "Profile updated successfully.";
            // You can redirect the user to a confirmation page or refresh the current page
            // header("Location: profile.php");
            // exit();
        } else {
            $message = "Failed to update profile.";
        }

        $statement->close();
    } else {
        // Join query to fetch data from both users and donorreq tables
        $query = "
            SELECT u.fullname, u.phone, u.email,
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
            $message = "No user found.";
        }

        $statement->close();
    }
} else {
    $message = "User not logged in.";
}

$conn->close();
?>
