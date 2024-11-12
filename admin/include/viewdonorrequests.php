<?php
// Establish database connection
$conn = new mysqli('localhost', 'root', 'ankit', 'dndb');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $drid = $conn->real_escape_string($_POST['drid']);

    // Fetch user details
    $sql = "SELECT dob FROM donors WHERE drid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $drid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $today = new DateTime(); // Initialize today's date
        $dob = new DateTime($row['dob']);
        $age = $today->diff($dob)->y;

        // Determine eligibility based on age
        $isEligible = ($age >= 18);

        if (isset($_POST['approved']) && $isEligible) {
            $sql = "UPDATE donors SET status = 'Approved' WHERE drid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $drid);
            $stmt->execute();
        } elseif (isset($_POST['rejected']) || !$isEligible) {
            $sql = "UPDATE donors SET status = 'Rejected' WHERE drid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $drid);
            $stmt->execute();
        }
    }

    $stmt->close();
}

// Fetch all donor details except latitude and longitude
$sql = "SELECT drid, sid, name, email, phone, bg, dob, district, locallevel, last_donation, donation_count, availability, medical_conditions, is_eligible, status, personal_documents, medical_documents 
         FROM donors WHERE status = 'Pending'";
$result = $conn->query($sql);
?>