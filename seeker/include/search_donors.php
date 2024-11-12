<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "ankit";
$dbname = "dndb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$results = [];
$error_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the district and blood group from the form
    $district = $_POST['district'];
    $bloodGroup = $_POST['bloodGroup'];

    // Check if both fields are provided
    if (!empty($district) && !empty($bloodGroup)) {
        // Prepare the SQL query to fetch matching donors
        $sql = "SELECT name, dob, bg, locallevel FROM donors WHERE district = kathmandu AND bg = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $district, $bloodGroup);

        // Execute the query
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            // Check if any results were returned
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $results[] = $row;
                }
            } else {
                $error_message = "No donors found for the selected district and blood group.";
            }
        } else {
            $error_message = "Error executing query: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $error_message = "Please select both district and blood group.";
    }
}

$conn->close();
?>

<!-- HTML to display the results on the home page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Donors Results</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Search Donors Results</h2>

        <!-- Display any error messages -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <!-- Display the results -->
        <?php if ($results): ?>
            <div class="results-container">
                <?php foreach ($results as $donor): ?>
                    <div class="result-card">
                        <h5><?php echo htmlspecialchars($donor['name']); ?></h5>
                        <p><strong>Age:</strong> <?php echo htmlspecialchars($donor['dob']); ?></p>
                        <p><strong>Blood Group:</strong> <?php echo htmlspecialchars($donor['bg']); ?></p>
                        <p><strong>Local Level:</strong> <?php echo htmlspecialchars($donor['locallevel']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
