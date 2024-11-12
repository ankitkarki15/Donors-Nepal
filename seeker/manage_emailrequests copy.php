<?php
include 'include/db.php';  // Include the database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

function sendEmailToSeeker($seekerEmail, $seekerName, $donorName, $donorEmail, $donorPhone, $newStatus) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ankitkarki1527@gmail.com'; // Your Gmail address
        $mail->Password   = 'atyqwqzkufqyjlno'; // Your Gmail App-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('ankitkarki1527@gmail.com', 'Donors Nepal');
        $mail->addAddress($seekerEmail);
        $mail->addReplyTo($donorEmail, 'Donor');

        // Content for different actions
        $mail->isHTML(true);
        if ($newStatus === 'accepted') {
            $mail->Subject = 'Blood Donation Request Accepted';
            $mail->Body    = "Dear $seekerName,
            <br><br>Your blood donation request has been <strong>accepted</strong> by the donor:
            <br><strong>Name:</strong> $donorName
            <br><strong>Email:</strong> $donorEmail
            <br><strong>Phone:</strong> $donorPhone
            <br><br>Thank you,
            <br>Donors Nepal";
        } elseif ($newStatus === 'declined') {
            $mail->Subject = 'Blood Donation Request Declined';
            $mail->Body    = "Dear $seekerName,
            <br><br>Your blood donation request has been <strong>declined</strong> by the donor with email: $donorEmail.
            <br><br>Thank you,
            <br>Donors Nepal";
        }

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        echo "Error sending email to seeker: {$mail->ErrorInfo}";
    }
}

function notifyAdmin($sid, $donorEmail, $newStatus, $seekerEmail, $donorID, $conn) {
    $adminId = 2; // Notify only admin with ID 2
    $message = "The donation request for Seeker ID $sid has been $newStatus.";

    // Prepare the SQL statement for admin notifications
    $adminStmt = $conn->prepare("INSERT INTO admin_notifications (admin_id, sid, donor_email, action, message, timestamp, seeker_email, drid) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)");
    if ($adminStmt === false) {
        echo "Error preparing statement: " . $conn->error;
        return;
    }

    // Bind parameters
    $adminStmt->bind_param("issssss", $adminId, $sid, $donorEmail, $newStatus, $message, $seekerEmail, $donorID);
    
    // Execute and handle errors
    if (!$adminStmt->execute()) {
        echo "Error inserting notification: " . $adminStmt->error; // Error handling
    } else {
        echo "Admin notified successfully.";
    }
    $adminStmt->close(); // Close the statement
}

if (isset($_GET['sid'], $_GET['drid'], $_GET['action'])) {
    $sid = $_GET['sid'];
    $donorID = $_GET['drid'];  // Changed from donor_email to drid
    $action = $_GET['action'];  // Either 'accept' or 'decline'

    // Determine the new status based on the action
    $newStatus = null;
    if ($action === 'accept') {
        $newStatus = 'accepted';
    } elseif ($action === 'decline') {
        $newStatus = 'declined';
    } else {
        // Invalid action
        echo "Invalid action.";
        exit();
    }

    // Update the request status in the database
    $stmt = $conn->prepare("UPDATE blooddonationrequests SET status = ? WHERE sid = ? AND drid = ?");
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    $stmt->bind_param("sss", $newStatus, $sid, $donorID); // Adjusted binding types

    // Execute and check for errors
    if ($stmt->execute()) {
        // Fetch the seeker's details to notify them
        $seekerStmt = $conn->prepare("SELECT email, name FROM seekers WHERE sid = ?");
        $seekerStmt->bind_param("s", $sid);  // Treat sid as a string
        $seekerStmt->execute();
        $seekerResult = $seekerStmt->get_result();
        $seeker = $seekerResult->fetch_assoc();

        // Fetch the donor's details using drid to get the email
        $donorStmt = $conn->prepare("SELECT name, email, phone FROM donors WHERE drid = ?");
        $donorStmt->bind_param("s", $donorID);  
        $donorStmt->execute();
        $donorResult = $donorStmt->get_result();
        $donor = $donorResult->fetch_assoc();

        // Check if seeker and donor records exist
        if ($seeker && $donor) {
            $seekerEmail = $seeker['email'];
            $seekerName = $seeker['name'];
            $donorName = $donor['name'];
            $donorEmail = $donor['email'];  // Correct donor email
            $donorPhone = $donor['phone'];

            // Debug: Display donor and seeker information
            echo "<pre>Debug Info:<br>";
            echo "Donor ID: " . htmlspecialchars($donorID) . "<br>";
            echo "Donor Name: " . htmlspecialchars($donorName) . "<br>";
            echo "Donor Email: " . htmlspecialchars($donorEmail) . "<br><br>";
            echo "Seeker ID: " . htmlspecialchars($sid) . "<br>";
            echo "Seeker Name: " . htmlspecialchars($seekerName) . "<br>";
            echo "Seeker Email: " . htmlspecialchars($seekerEmail) . "<br>";
            echo "</pre>";

            // Send email notification to the seeker
            sendEmailToSeeker($seekerEmail, $seekerName, $donorName, $donorEmail, $donorPhone, $newStatus);
            
            // Notify admin with ID 2, including seeker_email and donorID
            notifyAdmin($sid, $donorEmail, $newStatus, $seekerEmail, $donorID, $conn);
            
            // Show a confirmation message to the donor
            echo "You have successfully " . ($newStatus === 'accepted' ? 'accepted' : 'declined') . " the request.";
        } else {
            echo "Seeker or donor not found.";
        }
        
        // Close the statements
        $seekerStmt->close();
        $donorStmt->close();
    } else {
        echo "Error processing your response: " . $stmt->error; // Enhanced error handling
    }

    $stmt->close(); // Close the main statement
} else {
    echo "Invalid request.";
}
?>

