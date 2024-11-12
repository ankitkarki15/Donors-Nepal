<?php
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');


if (isset($_GET['district_id'])) {
    $districtId = $_GET['district_id'];
    
    
    $query = "SELECT * FROM locallevels WHERE district_id = ?";
    $statement = $conn->prepare($query);
    $statement->bind_param("i", $districtId);
    $statement->execute();
    $result = $statement->get_result();
    
    $localLevels = array();
    while ($row = $result->fetch_assoc()) {
        $localLevels[] = array(
            'id' => $row['id'],
            'locallevel_name' => $row['locallevel_name']
        );
    }

    $statement->close();
    $conn->close();
    

    header('Content-Type: application/json');
    echo json_encode($localLevels);
} else {
   
    echo json_encode(array('error' => 'District ID not provided'));
}
?>
