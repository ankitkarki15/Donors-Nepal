<?php
// Start the session and connect to the database
session_start();
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');

if (!isset($_SESSION['user_id'])) {
    die('User not logged in');
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT fullname, email, latitude, longitude FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $fullname = $user['fullname'];
    $email = $user['email'];
    $userLat = $user['latitude'];
    $userLon = $user['longitude'];
} else {
    die('<span style="font-weight: bold;">User not found.</span>');
}

// Function to calculate Haversine distance
function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371) {
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
}

// Check if form was submitted
if (isset($_POST['bg']) && isset($_POST['district'])) {
    $bloodGroup = $_POST['bg'];
    $district = $_POST['district'];
    $radius = 10; // Set a default radius

    // Query to find nearby donors
    $sql = "SELECT user_id, fullname, latitude, longitude, bg FROM users WHERE bg = ? AND district = ? AND is_donor = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $bloodGroup, $district);
    $stmt->execute();
    $result = $stmt->get_result();

    $nearbyDonors = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $distance = haversineGreatCircleDistance($userLat, $userLon, $row['latitude'], $row['longitude']);
            if ($distance <= $radius) {
                $row['distance'] = $distance;
                $nearbyDonors[] = $row;
            }
        }
    }

    // Display results
    if (!empty($nearbyDonors)) {
        echo "<h2>Nearby Donors:</h2>";
        echo "<ul>";
        foreach ($nearbyDonors as $donor) {
            echo "<li>User ID: " . $donor['user_id'] . " - Name: " . $donor['fullname'] . " - Distance: " . $donor['distance'] . " km</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No donors found within the specified radius.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nearby Donors</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add your custom styles here */
    </style>
</head>
<body>
    <!-- Include navigation or any other common elements -->
    <?php include 'include/navbar.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <!-- PHP output will be displayed here -->
            </div>
        </div>
    </div>

    <!-- Include footer or any other common elements -->
    <?php include 'include/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
