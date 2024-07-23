<?php
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');

// Check if district_id is provided via GET request
if (isset($_GET['district_id'])) {
    $districtId = $_GET['district_id'];
    
    // Query to fetch local levels based on district_id
    $query = "SELECT * FROM locallevels WHERE district_id = ?";
    $statement = $conn->prepare($query);
    $statement->bind_param("i", $districtId);
    $statement->execute();
    $result = $statement->get_result();
    
    // Build array of local levels
    $localLevels = array();
    while ($row = $result->fetch_assoc()) {
        $localLevels[] = array(
            'id' => $row['id'],
            'locallevel_name' => $row['locallevel_name']
        );
    }
    
    // Close statement and database connection
    $statement->close();
    $conn->close();
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($localLevels);
} else {
    // Handle case when district_id is not provided
    echo json_encode(array('error' => 'District ID not provided'));
}
?>
