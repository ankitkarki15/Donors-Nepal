<?php 
session_start();
include 'include/db.php'; // Include your database connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Load PHPMailer library

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (empty($_SESSION['sid'])) {
        header('Location: login.php?error=Session not set');
        exit();
    }

    $sid = $_SESSION['sid']; 
    $donorEmail = $_GET['donor_email'] ?? null;
    $scheduled_time = $_GET['scheduled_time'] ?? null; // Capture the schedule time

    if (!$donorEmail) {
        header('Location: donorsnearme.php?error=Donor email not provided');
        exit();
    }

    // Fetch the seeker's details (name, email, phone)
    $stmt = $conn->prepare("SELECT email, name, phone FROM seekers WHERE sid = ?");
    $stmt->bind_param("s", $sid); // Assuming 'sid' is a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($seeker = $result->fetch_assoc()) {
        $seekerEmail = $seeker['email'];
        $seekerName = $seeker['name'];
        $seekerPhone = $seeker['phone'];
    } else {
        header('Location: donorsnearme.php?error=Seeker not found');
        exit();
    }

    // Fetch the donor ID (drid) based on the provided donor email
    $donorStmt = $conn->prepare("SELECT drid FROM donors WHERE email = ?");
    $donorStmt->bind_param("s", $donorEmail);
    $donorStmt->execute();
    $donorResult = $donorStmt->get_result();

    if ($donor = $donorResult->fetch_assoc()) {
        $drid = $donor['drid']; // Donor ID (drid)
    } else {
        header('Location: donorsnearme.php?error=Donor not found');
        exit();
    }

    // Insert the blood donation request into the blooddonationrequests table
    $insertStmt = $conn->prepare("INSERT INTO blooddonationrequests (sid, drid,scheduled_time, status) VALUES (?, ?,?, 'pending')");
    $insertStmt->bind_param("sss", $sid, $drid,$scheduled_time); // Inserting seeker ID and donor ID

    if ($insertStmt->execute()) {
        // Continue with sending the email after successful insertion
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ankitkarki1527@gmail.com';
            $mail->Password   = 'atyqwqzkufqyjlno'; // Make sure to handle this securely in production
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('ankitkarki1527@gmail.com', 'Donors Nepal');
            $mail->addAddress($donorEmail); // Donor's email

            $mail->isHTML(true);
            $mail->Subject = 'Blood Donation Request';
            $mail->Body    = "Dear Donor,
            <br><br>
            We have a blood donation request for you. Please respond to this email if you are available to donate.
            <br><br>
            Name: $seekerName<br>
            ID: $sid<br>
            Phone: $seekerPhone<br>
            Scheduled Time: $scheduled_time <br> <!-- Add scheduled time here -->
            <br>
            Please choose one of the following options:
            <br><br>
            <a href='http://localhost/DN%20new/seeker/manage_emailrequests.php?sid=$sid&drid=$drid&action=accept' style='background-color:green;color:white;padding:10px;border-radius:4px;text-decoration:none;'>Accept</a>
            <a href='http://localhost/DN%20new/seeker/manage_emailrequests.php?sid=$sid&drid=$drid&action=decline' style='background-color:red;color:white;padding:10px;border-radius:4px;text-decoration:none;'>Decline</a>
            <br><br>Thank you,
            <br>Donors Nepal";

            $mail->send();
            header('Location: donorsnearme.php?message=Email sent successfully');
        } catch (Exception $e) {
            header('Location: donorsnearme.php?error=Message could not be sent. Mailer Error: '.$mail->ErrorInfo);
        }
    } else {
        header('Location: donorsnearme.php?error=Failed to store request in the database');
    }
}
?>
