<?php
// session_start(); 

// Fetch the message from the session and then clear it
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);

// Initialize directory paths
$directories = [
    'personal_documents' => 'uploads/personal_documents/', 
    'medical_documents' => 'uploads/medical_documents/'
];

// Create directories if they don't exist
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true) or die('Failed to create directory: ' . $dir);
    }
}

// Initialize array to store document names
$documents = [
    'personal_documents' => '',
    'medical_documents' => ''
];
$allowedTypes = ['image/jpeg', 'image/png'];
$maxFileSize = 2 * 1024 * 1024; // 2MB

// Process file uploads
foreach ($documents as $type => &$fileName) {
    if (isset($_FILES[$type]) && $_FILES[$type]['error'] === UPLOAD_ERR_OK) {
        $fileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '', basename($_FILES[$type]['name'])); // Sanitize file name
        $fileTmpName = $_FILES[$type]['tmp_name'];
        $fileType = $_FILES[$type]['type'];

        // Check file type and size
        if (in_array($fileType, $allowedTypes) && $_FILES[$type]['size'] <= $maxFileSize) {
            $filePath = $directories[$type] . $fileName;
            if (move_uploaded_file($fileTmpName, $filePath)) {
                // Successfully uploaded
            } else {
                echo "Failed to move uploaded file: $fileName<br>";
            }
        } else {
            echo "Invalid file type or size for: $fileName<br>";
        }
    } else {
        if (isset($_FILES[$type]['error']) && $_FILES[$type]['error'] !== UPLOAD_ERR_NO_FILE) {
            echo "File upload error for $fileName (Error code: " . $_FILES[$type]['error'] . ")<br>";
        }
    }
}

// Convert document names to strings
$personalDocumentsStr = $documents['personal_documents'];
$medicalDocumentsStr = $documents['medical_documents'];

// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Function to generate donor ID starting from DN5000
function generateDonorID($conn) {
    $prefix = "DN";
    $startNumber = 5000;

    $sql = "SELECT MAX(CAST(SUBSTRING(drid, 3) AS UNSIGNED)) AS last_number FROM donors";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastNumber = intval($row['last_number']);
        if ($lastNumber < $startNumber) {
            $lastNumber = $startNumber - 1;
        }
    } else {
        $lastNumber = $startNumber - 1; 
    }

    $newNumber = $lastNumber + 1;
    $drid = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

    return $drid;
}

// Handle form submission
if (isset($_POST['register'])) {
    // Sanitize and validate inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $bg = mysqli_real_escape_string($conn, $_POST['bg']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $locallevel = mysqli_real_escape_string($conn, $_POST['locallevel']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
    $medical_conditions = mysqli_real_escape_string($conn, $_POST['medical_conditions']);
    $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    // Generate donor ID
    $drid = generateDonorID($conn);
    $status = 'pending';

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO donors (drid, name, email, phone, bg, dob, district, locallevel, medical_conditions, password, personal_documents, medical_documents, latitude, longitude, gender, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    // Bind parameters
    $stmt->bind_param("ssssssssssssssss", $drid, $name, $email, $phone, $bg, $dob, $district, $locallevel, $medical_conditions, $password, $personalDocumentsStr, $medicalDocumentsStr, $latitude, $longitude, $gender, $status);

    // Execute statement
    if ($stmt->execute()) {
        $_SESSION['message'] = "Registration successful!";
        header("Location: donorlogin.php");
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        header("Location: donorregister.php");
        exit();
    }

    // Close statement and connection
    $stmt->close();
    mysqli_close($conn);
}
?>
