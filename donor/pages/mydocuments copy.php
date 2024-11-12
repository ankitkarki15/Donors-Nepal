<?php


// Check if the donor is logged in by checking the session
if (!isset($_SESSION['drid'])) {
    echo "Please log in to view your documents.";
    exit();
}

// Retrieve the logged-in donor's ID from the session
$drid = $_SESSION['drid'];

// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Fetch the personal and medical document names for the logged-in donor
$sql = "SELECT personal_documents, medical_documents FROM donors WHERE drid = '$drid'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $personalDocument = $row['personal_documents'];
    $medicalDocument = $row['medical_documents'];

    // Paths to the documents
    $personalDocPath = 'uploads/personal_documents/' . $personalDocument;
    $medicalDocPath = 'uploads/medical_documents/' . $medicalDocument;

    // Start HTML output
    echo "<h2>Your Uploaded Documents</h2>";

    // Start a two-column layout using CSS Grid
    echo '<div class="document-grid">';

    // Personal document section
    if (!empty($personalDocument) && file_exists($personalDocPath)) {
        echo "<div class='document-column'>";
        echo "<h3>Personal Document</h3>";
        echo "<img src='$personalDocPath' alt='Personal Document' width='300'><br>";
        echo "<a href='$personalDocPath' target='_blank'>View Full Personal Document</a><br>";
        echo "</div>";
    } else {
        echo "<div class='document-column'><p>No personal document uploaded.</p></div>";
    }

    // Medical document section
    if (!empty($medicalDocument) && file_exists($medicalDocPath)) {
        echo "<div class='document-column'>";
        echo "<h3>Medical Document</h3>";
        echo "<img src='$medicalDocPath' alt='Medical Document' width='300'><br>";
        echo "<a href='$medicalDocPath' target='_blank'>View Full Medical Document</a><br>";
        echo "</div>";
    } else {
        echo "<div class='document-column'><p>No medical document uploaded.</p></div>";
    }

    // End the grid
    echo '</div>';
} else {
    echo "No documents found for this donor.";
}

mysqli_close($conn);
?>
<style>
    .document-grid {
        display: grid;
        grid-template-columns: 1fr 1fr; /* Two equal columns */
        gap: 20px; /* Space between columns */
        margin-top: 20px;
    }

    .document-column {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }

    .document-column img {
        max-width: 100%; /* Ensure image fits within the column */
        height: auto;
    }
</style>
