<?php
session_start();

// Connect to the database
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');

// Function to calculate distance between two points using Haversine formula
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

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user's location, blood group, and availability
    $user_query = "SELECT latitude, longitude, bloodgroup, district FROM users WHERE user_id = '$user_id'";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows == 1) {
        $user_data = $user_result->fetch_assoc();
        $userLat = $user_data['latitude'];
        $userLon = $user_data['longitude'];
        $bloodGroup = $user_data['bloodgroup'];
        $district = $user_data['district'];

        // Query nearby donors within a default radius who are available
        $radius = 10; // Default radius in kilometers
        $sql = "SELECT user_id, fullname, latitude, longitude FROM users WHERE bloodgroup = '$bloodGroup' AND district = '$district' AND availability = 1";
        $result = $conn->query($sql);

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
    } else {
        echo "User location not found.";
    }
} else {
    echo "User not logged in.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Recommendations</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="text-center">Nearby Donors</h2>
                <p class="text-center">Recommended donors based on your location and selected blood group.</p>
                <div class="card">
                    <div class="card-body">
                        <?php if (!empty($nearbyDonors)): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($nearbyDonors as $donor): ?>
                                    <li class="list-group-item">
                                        <strong><?php echo $donor['fullname']; ?></strong> 
                                        <span class="badge badge-primary badge-pill"><?php echo round($donor['distance'], 2); ?> km</span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-center">No donors found within the specified radius.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

