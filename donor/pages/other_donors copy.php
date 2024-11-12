<?php
// Ensure the database connection is included if it's not already
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Fetch the donor information from session
$drid = $_SESSION['drid'];

// Fetch other donors
$donorsQuery = "SELECT name, email, last_donation, bg, locallevel, district FROM donors WHERE drid != ?";
$stmt = $conn->prepare($donorsQuery);
$stmt->bind_param('s', $drid);
$stmt->execute();
$donorsResult = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Cards</title>
    <style>
        /* Base styles */
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            margin: 40px auto;
            max-width: 1200px;
            padding: 0 20px;
        }

        h3 {
            text-align: center;
            color: #007bff;
            margin-bottom: 40px;
            font-size: 2rem;
        }

        .row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Two columns, responsive */
            gap: 20px;
        }

        /* Card styles */
        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #007bff, #28a745);
            z-index: 1;
        }

        .card-content {
            padding: 20px;
            display: flex;
            align-items: center;
        }

        .blood-group-circle {
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background-color: #dc3545;
            color: #fff;
            width: 90px;
            height: 90px;
            font-size: 22px;
            font-weight: bold;
            margin-right: 20px;
        }

        .card-body {
            flex-grow: 1;
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 8px;
            color: #333;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
        }

        .highlight {
            color: #28a745;
            font-weight: bold;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            background-color: blue;
            /* color: white; */
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            /* background-color: grey; */
            border:1px solid blue;
            color:blue;
        }

        .btn i {
            margin-right: 8px;
        }

        /* Responsive behavior */
        @media (max-width: 768px) {
            .row {
                grid-template-columns: 1fr; /* One column layout on small screens */
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h3>Other Donors</h3>
        <div class="row">
            <?php if ($donorsResult->num_rows > 0): ?>
                <?php while ($donor = $donorsResult->fetch_assoc()): ?>
                    <div class="card">
                        <div class="card-content">
                            <!-- Blood Group Circle -->
                            <div class="blood-group-circle">
                                <?php echo htmlspecialchars($donor['bg']); ?>
                            </div>
                            
                            <!-- Card Body -->
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($donor['name']); ?></h5>
                                <p class="card-text">
                                    Email: <?php echo htmlspecialchars($donor['email']); ?><br>
                                    Last Donation: <?php echo htmlspecialchars($donor['last_donation']); ?><br>
                                    From: <span class="highlight"><?php echo htmlspecialchars($donor['locallevel']); ?></span>, <span class="highlight"><?php echo htmlspecialchars($donor['district']); ?></span>
                                </p>
                                <button class="btn" onclick="sendMail('<?php echo htmlspecialchars($donor['email']); ?>')">
                                    <i class="fas fa-envelope"></i>
                                    Mail Donor
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No other donors found.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function sendMail(email) {
            // Here you can replace with real mail logic, e.g., using an API or server-side logic
            alert(`An email will be sent to ${email}`);
        }
    </script>
</body>
</html>

