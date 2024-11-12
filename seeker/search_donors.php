<?php
// Start the session and connect to the database
session_start();
if (!isset($_SESSION['sid'])) {
    header("Location: front.php");
    exit();
}

include('include/db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $district = $_POST['district'];
    $bg = $_POST['bloodGroup'];

    // Prepare the SQL query to search for donors
    $sql = "SELECT * FROM donors WHERE district = ? AND bg = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $district, $bg);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the donors
    $donors = [];
    while ($row = $result->fetch_assoc()) {
        $donors[] = $row;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Donors | DN</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<div class="container mx-auto mt-12 px-4">
    
    <?php if (count($donors) > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($donors as $donor): ?>
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h5 class="text-xl font-semibold text-red-600 mb-2"><?php echo $donor['name']; ?></h5>
                    <p><strong>Blood Group:</strong> <?php echo $donor['bg']; ?></p>
                    <p><strong>District:</strong> <?php echo $donor['district']; ?></p>
                    <p><strong>Contact:</strong> <?php echo $donor['phone']; ?></p>
                    <button class="btn text-gray-400 border-gray-400 py-2 px-4 rounded" disabled>
                                <i class="fas fa-envelope"></i> Send Email
                            </button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-lg text-gray-600">No donors found matching your criteria.</p>
    <?php endif; ?>
</div>

</body>
</html>
