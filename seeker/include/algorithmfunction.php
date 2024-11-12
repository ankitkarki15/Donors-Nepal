<?php

// include'db.php';
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$recommendations = [];
// start formula
function haversineDistance($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371;

    $lat1Rad = deg2rad($lat1);
    $lon1Rad = deg2rad($lon1);
    $lat2Rad = deg2rad($lat2);
    $lon2Rad = deg2rad($lon2);

    $deltaLat = $lat2Rad - $lat1Rad;
    $deltaLon = $lon2Rad - $lon1Rad;

    $a = sin($deltaLat / 2) ** 2 +
        cos($lat1Rad) * cos($lat2Rad) * sin($deltaLon / 2) ** 2;

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earthRadius * $c;
}
// End 

if (!isset($_SESSION['sid'])) {
    die("Seeker is not logged in.");
}

$seekerSid = $_SESSION['sid'];

$seekerQuery = "SELECT latitude, longitude FROM seekers WHERE sid = ?";
$stmt = $conn->prepare($seekerQuery);
$stmt->bind_param("s", $seekerSid);
$stmt->execute();
$seekerResult = $stmt->get_result();

if ($seekerResult->num_rows === 0) {
    die("Seeker not found.");
}

$seeker = $seekerResult->fetch_assoc();
$seekerLat = $seeker['latitude'];
$seekerLon = $seeker['longitude'];

$selectedBloodType = isset($_GET['blood_type']) ? $_GET['blood_type'] : '';

$donorQuery = "SELECT drid,name, email, phone, bg, dob, gender, district, locallevel, last_donation, donation_count, availability, latitude, longitude, medical_conditions, is_eligible, status, created_at, personal_documents, medical_documents FROM donors WHERE status = 'approved'";
$params = [];
$types = '';

if ($selectedBloodType) {
    $donorQuery .= " AND (bg = ? OR bg = 'O-')";
    $params[] = $selectedBloodType;
    $types .= 's';
}

$stmt = $conn->prepare($donorQuery);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$donorsResult = $stmt->get_result();

$maxDistance = 6;

while ($donor = $donorsResult->fetch_assoc()) {
    $donorLat = $donor['latitude'];
    $donorLon = $donor['longitude'];
    $distance = haversineDistance($seekerLat, $seekerLon, $donorLat, $donorLon);

    if ($distance <= $maxDistance) {
        $recommendations[] = [
            'drid' => $donor['drid'],
            'name' => $donor['name'],
            'email' => $donor['email'],
            'availability' => $donor['availability'],
            'phone' => $donor['phone'],
            'donation_count' => $donor['donation_count'],
            'bg' => $donor['bg'],
            'district' => $donor['district'],
            'locallevel' => $donor['locallevel'],
            'distance' => $distance
        ];
    }
}

$conn->close();

usort($recommendations, function($a, $b) {
    return $a['distance'] <=> $b['distance'];
});

?>
