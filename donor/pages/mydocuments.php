<?php

if (!isset($_SESSION['drid'])) {
    echo "Please log in to view and update your documents.";
    exit();
}

$drid = $_SESSION['drid'];
$message = '';

// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Directory for medical documents
$medicalDirectory = 'uploads/medical_documents/';

// Allowed file types
$allowedTypes = ['image/jpeg', 'image/png'];

// Fetch the current documents for the donor
$sql = "SELECT personal_documents, medical_documents FROM donors WHERE drid = '$drid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$personalDocument = $row['personal_documents'];
$medicalDocument = $row['medical_documents'];

// Process medical document update if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['medical_documents']) && $_FILES['medical_documents']['error'] === UPLOAD_ERR_OK) {
    $fileName = basename($_FILES['medical_documents']['name']);
    $fileTmpName = $_FILES['medical_documents']['tmp_name'];
    $fileType = $_FILES['medical_documents']['type'];

    if (in_array($fileType, $allowedTypes)) {
        if (!empty($medicalDocument) && file_exists($medicalDirectory . $medicalDocument)) {
            unlink($medicalDirectory . $medicalDocument);
        }

        $medicalDocument = $fileName;
        $filePath = $medicalDirectory . $medicalDocument;
        move_uploaded_file($fileTmpName, $filePath);

        $sql = "UPDATE donors SET medical_documents = '$medicalDocument' WHERE drid = '$drid'";
        if (mysqli_query($conn, $sql)) {
            $message = "Medical document updated successfully!";
        } else {
            $message = "Error updating medical document: " . mysqli_error($conn);
        }
    } else {
        $message = "Invalid file type for medical document.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Documents</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .document-section {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            color: #333;
          
        }

        .document-section h3, .document-section h2 {
            color: #e63946;
            text-align: center;
            font-size: 24px;
            
        }

        .alert-info {
            text-align: center;
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .document-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .document-column {
            padding: 10px;
            margin:25px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .document-column img {
            max-width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }

        .document-column a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
           color: #e63946;
            
        }

        .document-section form {
            max-width: 600px;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .document-section form label {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
            display: block;
        }

        .document-section form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .document-section form button {
            width: 100%;
            padding: 12px;
            background-color: #e63946;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .document-section form button:hover {
            background-color: #d63031;
        }
    </style>
</head>
<body class="document-section">
<br><br>
<h3>Your Uploaded Documents</h3>

<?php if ($message): ?>
    <div class="alert-info"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<div class="document-grid">
    <div class="document-column">
        <a>Personal Document</a>
        <?php
        $personalDocPath = 'uploads/personal_documents/' . $personalDocument;
        if (!empty($personalDocument) && file_exists($personalDocPath)) {
            echo "<img src='$personalDocPath' alt='Personal Document'><br>";
            echo "<a href='$personalDocPath' target='_blank'>View Full Personal Document</a>";
        } else {
            echo "<p>No personal document uploaded.</p>";
        }
        ?>
    </div>

    <div class="document-column">
        <a>Medical Document</a>
        <?php
        $medicalDocPath = 'uploads/medical_documents/' . $medicalDocument;
        if (!empty($medicalDocument) && file_exists($medicalDocPath)) {
            echo "<img src='$medicalDocPath' alt='Medical Document'><br>";
            echo "<a href='$medicalDocPath' target='_blank'>View Full Medical Document</a>";
        } else {
            echo "<p>No medical document uploaded.</p>";
        }
        ?>
    </div>
</div>

<form action="donordash.php?page=mydocuments" method="POST" enctype="multipart/form-data">
    <label for="medical_documents">Upload New Medical Document:</label>
    <input type="file" name="medical_documents" accept="image/jpeg, image/png" required>
    <button type="submit">Update Medical Document</button>
</form>

</body>
</html>

<?php
mysqli_close($conn);
?>
