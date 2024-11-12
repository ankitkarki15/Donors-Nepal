<?php
session_start();
if (!isset($_SESSION['sid'])) {
    header("Location: front.php");
    exit();
}

$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb');
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$sid = $_SESSION['sid'];


$query = "SELECT DISTINCT donors.drid, donors.email, blooddonationrequests.donation_status, donors.availability
          FROM donors
          JOIN blooddonationrequests ON donors.drid = blooddonationrequests.drid
          WHERE blooddonationrequests.sid = ? AND blooddonationrequests.status = 'accepted'";
$statement = $conn->prepare($query);
$statement->bind_param("s", $sid);  
$statement->execute();
$result = $statement->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accepted Donors</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-bottom: 20px;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-warning {
            background-color: #ffc107;
        }
        .badge-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Accepted Donors</h1>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['email']); ?></h5>
                        <p class="card-text">Donor ID: <?php echo htmlspecialchars($row['drid']); ?></p>
                        <p class="card-text">Donation Status: <strong><?php echo htmlspecialchars($row['donation_status']); ?></strong></p>
                        <p class="card-text">
                            Availability: 
                            <?php if ($row['availability'] == 1): ?>
                                <span class="badge badge-success">Available</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Not Available</span>
                            <?php endif; ?>
                        </p>
                        <button class="btn btn-dark" onclick="window.location.href='givereviews.php?drid=<?php echo htmlspecialchars($row['drid']); ?>'">Rate Donor</button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                No donors have accepted your request yet.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$statement->close();
$conn->close();
?>
