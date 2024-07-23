<?php
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('connection failed');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate unique mem_id with "DN" prefix
function generateMembershipID($conn) {
    $prefix = "DN";
    $lastNumber = 0;

    // Retrieve the last used number from the database
    $sql = "SELECT MAX(SUBSTRING(mem_id, 3)) AS last_number FROM users";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastNumber = intval($row['last_number']);
    }

    // Increment the last used number
    $newNumber = $lastNumber + 1;

    // Construct the mem_id using the new number
    $mem_id = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

    return $mem_id;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $bloodgroup = $_POST['bloodgroup'];
    $province = $_POST['province'];
    $district = $_POST['district'];
    $locallevel = $_POST['locallevel'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $availability = 1; // Automatically set as available when registering
    $lastdonationdate = NULL;
    $donationcount = 0; // Initial count

    // Generate mem_id with "DN" prefix
    $mem_id = generateMembershipID($conn);

    // Prepared statement to prevent SQL injection
    $sql = $conn->prepare("INSERT INTO users (mem_id, fullname, bloodgroup, province, district, locallevel, email, dob, phone, gender, password, lastdonationdate, donationcount, availability)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("sssssssssssisi", $mem_id, $fullname, $bloodgroup, $province, $district, $locallevel, $email, $dob, $phone, $gender, $password, $lastdonationdate, $donationcount, $availability);

    if ($sql->execute()) {
        echo json_encode(['success' => true, 'mem_id' => $mem_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $sql->error]);
    }

    $sql->close();
}
$conn->close();
?>
