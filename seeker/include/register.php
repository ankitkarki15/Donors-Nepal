<?php
session_start();

$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb');
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

function generateMembershipID($conn) {
    $prefix = "DN";
    $lastNumber = 0;

    $sql = "SELECT MAX(CAST(SUBSTRING(mem_id, 3) AS UNSIGNED)) AS last_number FROM seekers";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastNumber = intval($row['last_number']);
    }

    $newNumber = $lastNumber + 1;

    $mem_id = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

    return $mem_id;
}

$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $bg = $_POST['bg'];
    $district = $_POST['district'];
    $locallevel = $_POST['locallevel'];
    $email = $_POST['email'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $mem_id = generateMembershipID($conn);

    $sql = $conn->prepare("INSERT INTO seekers (mem_id, name, bg, district, locallevel, email, latitude, longitude, password)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if ($sql === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $sql->bind_param("ssssssdds", $mem_id, $name, $bg, $district, $locallevel, $email, $latitude, $longitude, $password);
    
    if ($sql->execute()) {
        $message = 'Registration successful. <a href="login.php">Login Here</a>';
    } else {
        $message = "Registration failed: " . htmlspecialchars($sql->error);
    }

    $sql->close();
} else {
    $message = "Invalid request method.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .message {
            margin: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

    <div class="message">
        <?php echo $message; ?>
    </div>

</body>
</html>
