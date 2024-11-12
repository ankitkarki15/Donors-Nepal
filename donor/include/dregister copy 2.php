<?php
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
        $lastNumber = $startNumber - 1; 
    }

    // Increment the last used number
    $newNumber = $lastNumber + 1;

    // Construct the donor ID using the new number
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

    // Define upload directories
    $personalUploadDir = 'uploads/personal/';
    $medicalUploadDir = 'uploads/medical/';

    // Create directories if they don't exist
    if (!is_dir($personalUploadDir)) {
        mkdir($personalUploadDir, 0777, true) or die('Failed to create personal documents directory.');
    }
    if (!is_dir($medicalUploadDir)) {
        mkdir($medicalUploadDir, 0777, true) or die('Failed to create medical documents directory.');
    }

    // Initialize arrays to store file names
    $personalDocuments = [];
    $medicalDocuments = [];
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];

    // Process personal documents
    if (isset($_FILES['personal_documents'])) {
        foreach ($_FILES['personal_documents']['error'] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $fileName = basename($_FILES['personal_documents']['name'][$key]);
                $fileTmpName = $_FILES['personal_documents']['tmp_name'][$key];
                $fileType = $_FILES['personal_documents']['type'][$key];

                if (in_array($fileType, $allowedTypes)) {
                    $filePath = $personalUploadDir . $fileName;
                    if (move_uploaded_file($fileTmpName, $filePath)) {
                        $personalDocuments[] = $fileName;
                    } else {
                        echo "Failed to move uploaded file: $fileName<br>";
                    }
                } else {
                    echo "Invalid file type for: $fileName<br>";
                }
            } else {
                echo "File upload error code: $error<br>";
            }
        }
    }

    // Process medical documents
    if (isset($_FILES['medical_documents'])) {
        foreach ($_FILES['medical_documents']['error'] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $fileName = basename($_FILES['medical_documents']['name'][$key]);
                $fileTmpName = $_FILES['medical_documents']['tmp_name'][$key];
                $fileType = $_FILES['medical_documents']['type'][$key];

                if (in_array($fileType, $allowedTypes)) {
                    $filePath = $medicalUploadDir . $fileName;
                    if (move_uploaded_file($fileTmpName, $filePath)) {
                        $medicalDocuments[] = $fileName;
                    } else {
                        echo "Failed to move uploaded file: $fileName<br>";
                    }
                } else {
                    echo "Invalid file type for: $fileName<br>";
                }
            } else {
                echo "File upload error code: $error<br>";
            }
        }
    }

    // Convert arrays to comma-separated strings
    $personalDocumentsStr = implode(', ', $personalDocuments);
    $medicalDocumentsStr = implode(', ', $medicalDocuments);

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
