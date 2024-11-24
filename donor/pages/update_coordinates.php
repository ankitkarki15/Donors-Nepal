<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Google API Key
$apiKey = '';
// $batchSize = 10;

// Function to get and store coordinates for a specific local level
function updateCoordinatesForLocalLevel($conn, $localLevelName, $apiKey) {
    // Get coordinates using Google Maps Geocoding API
    $coordinates = getLocalLevelCoordinates($localLevelName, $apiKey);
    
    if ($coordinates['lat'] !== null && $coordinates['lon'] !== null) {
        // Store coordinates in the database
        storeCoordinates($conn, $localLevelName, $coordinates['lat'], $coordinates['lon']);
    } else {
        echo "Coordinates not found for the local level: " . htmlspecialchars($localLevelName) . "<br>";
    }
}

// Function to get coordinates from Google Maps Geocoding API
function getLocalLevelCoordinates($localLevel, $apiKey) {
    $address = urlencode("{$localLevel}, Kathmandu");
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$apiKey}";

    // Fetch the response from the API
    $response = @file_get_contents($url);

    if ($response === FALSE) {
        error_log("Error fetching data from Google Maps API for address: $address");
        return ['lat' => null, 'lon' => null];
    }

    $data = json_decode($response, true);

    // Log the API response for debugging
    error_log("Google Maps API response: " . print_r($data, true));

    if (isset($data['error_message'])) {
        error_log("Google Maps API error: " . $data['error_message']);
    }

    if (!empty($data['results']) && isset($data['results'][0]['geometry']['location'])) {
        $location = $data['results'][0]['geometry']['location'];
        return ['lat' => $location['lat'], 'lon' => $location['lng']];
    } else {
        return ['lat' => null, 'lon' => null];
    }
}

// Function to store coordinates in the database
function storeCoordinates($conn, $localLevelName, $lat, $lon) {
    $stmt = $conn->prepare("UPDATE locallevels SET latitude = ?, longitude = ? WHERE locallevel_name = ?");
    $stmt->bind_param('dds', $lat, $lon, $localLevelName);

    if ($stmt->execute()) {
        echo "Coordinates updated successfully for local level: " . htmlspecialchars($localLevelName) . "<br>";
    } else {
        error_log("Error storing coordinates: " . $stmt->error);
    }

    $stmt->close();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['locallevel_name'])) {
    $localLevelName = $_POST['locallevel_name'];
    updateCoordinatesForLocalLevel($conn, $localLevelName, $apiKey);
}

// HTML form for user input
?>

<form method="post" action="">
    <label for="locallevel_name">Enter Local Level Name:</label>
    <input type="text" id="locallevel_name" name="locallevel_name" required>
    <input type="submit" value="Update Coordinates">
</form>

<?php
$conn->close();
?>