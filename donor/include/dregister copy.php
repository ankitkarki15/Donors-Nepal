<?php 
// Define upload directories
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

// Initialize arrays to store document names
$documents = [
    'personal_documents' => '',
    'medical_documents' => ''
];
$allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];

// Process file uploads
foreach ($documents as $type => &$fileName) {
    if (isset($_FILES[$type]) && $_FILES[$type]['error'] == UPLOAD_ERR_OK) {
        $fileTmpName = $_FILES[$type]['tmp_name'];
        $fileType = $_FILES[$type]['type'];
        $originalFileName = basename($_FILES[$type]['name']);
        $fileExt = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

        if (in_array($fileType, $allowedTypes)) {
            $newFileName = uniqid('', true) . "." . $fileExt; // Unique file name
            $filePath = $directories[$type] . $newFileName;
            if (move_uploaded_file($fileTmpName, $filePath)) {
                $fileName = $newFileName;
            } else {
                echo "Failed to move uploaded file: $originalFileName<br>";
            }
        } else {
            echo "Invalid file type for: $originalFileName<br>";
        }
    }
}

// Convert document names to comma-separated strings (for future use if needed)
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
    // Collect form data
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
    
    // Generate donor ID
    $drid = generateDonorID($conn);

    // Set default status
    $status = 'pending';

    // Insert donor into the database
    $sql = "INSERT INTO donors (drid, name, email, phone, bg, dob, district, locallevel, medical_conditions, password, personal_documents, medical_documents, latitude, longitude, status, created_at)
            VALUES ('$drid', '$name', '$email', '$phone', '$bg', '$dob', '$district', '$locallevel', '$medical_conditions', '$password', '$personalDocumentsStr', '$medicalDocumentsStr', '$latitude', '$longitude', '$status', NOW())";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Registration successful!";
        header("Location: donorregister.php");
        exit();
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($conn);
        header("Location: donorregister.php");
        exit();
    }

    // Close database connection
    mysqli_close($conn);
}
?>