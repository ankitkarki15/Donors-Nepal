<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb');

// Check if the connection was successful
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Assuming $donor_id is available (e.g., from session or user login)
$donor_id = 1; // Replace with the actual donor ID

// Fetch the total pints donated, total donations, and last donation date for this donor
$sql = "SELECT SUM(pints) as total_pints, COUNT(*) as total_donations, MAX(donation_date) as last_donated_on 
        FROM donations 
        WHERE donor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $donor_id);
$stmt->execute();
$result = $stmt->get_result();
$donor_stats = $result->fetch_assoc();

$total_pints = $donor_stats['total_pints'] ?? 0;
$total_donations = $donor_stats['total_donations'] ?? 0;
$last_donated_on = $donor_stats['last_donated_on'] ?? 'No donations yet';

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .dashboard-section {
            background-color: #f8f9fa;
            padding: 30px; /* Increased padding for more height */
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            text-align: center;
            min-height: 500px; /* Increased height */
        }

        .dashboard-section h2 {
            color: #000; /* Changed to black */
            font-size: 32px; /* Slightly increased font size */
            font-weight: 600;
            margin-bottom: 20px; /* Increased margin for spacing */
        }

        .statistics {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 25px; /* Increased padding */
            margin: 20px 0; /* Increased margin for spacing */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            min-height: 150px; /* Set minimum height for larger size */
        }

        .statistics h3 {
            color: #000; /* Changed to black */
            font-size: 24px; /* Increased font size */
            margin-bottom: 15px; /* Increased spacing */
        }

        .statistics p {
            font-size: 18px; /* Increased font size */
            color: #000; /* Changed text to black */
            margin: 10px 0; /* Increased margin */
        }

        @media (max-width: 768px) {
            .dashboard-section {
                padding: 20px;
                margin: 15px;
            }

            .dashboard-section h2 {
                font-size: 26px;
            }

            .statistics h3 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

<div id="home" class="dashboard-section">
    <h2>Welcome, Donor!</h2>

    <!-- Cards Section -->
    <div class="row">
        <!-- Total Blood Donated in Pints -->
        <div class="col-md-4">
            <div class="statistics">
                <h3>Total Blood Donated (Pints)</h3>
                <p><?php echo htmlspecialchars($total_pints); ?> Pints</p>
            </div>
        </div>

        <!-- Total Donations -->
        <div class="col-md-4">
            <div class="statistics">
                <h3>Total Donations</h3>
                <p><?php echo htmlspecialchars($total_donations); ?> Donations</p>
            </div>
        </div>

        <!-- Last Donated On -->
        <div class="col-md-4">
            <div class="statistics">
                <h3>Last Donated On</h3>
                <p><?php echo htmlspecialchars($last_donated_on); ?></p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
