<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Fetch blood requests from the database
$sql = "SELECT * FROM bloodreq ORDER BY br_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Requests</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Overall Page Styling */
            /* Overall Page Styling */
        .blood-requests-page {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 30px;
            background-color: #FAF9F6;
        }

        /* Container to limit the width of the page */
        .blood-requests-page .container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Heading Style */
        .blood-requests-page h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.8rem; /* Slightly reduced size */
            font-weight: 600;
            color: #343a40;
        }

        /* Grid Layout for Cards */
        .blood-requests-page .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Keep 2 columns */
            grid-gap: 10px; /* Smaller gap between cards */
            justify-items: center;
        }

        /* Styling for individual cards */
        .blood-requests-page .blood-request-card {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px; /* Reduce border-radius for a sharper look */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Lighter shadow */
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            width: 100%;
            max-width: 300px; /* Reduced max-width to shrink card size */
        }

        /* Hover Effect */
        .blood-requests-page .blood-request-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Card Body */
        .blood-requests-page .card-body {
            padding: 10px; 
        }

        /* Title and Badge Styling */
        .blood-requests-page .blood-request-card h5 {
            font-size: 1.1rem; /* Slightly smaller text */
            margin-bottom: 10px; /* Reduced spacing */
            display: flex;
            align-items:center;
            justify-content: space-between;
            margin-top: 10px;
            color: black;
        }

        /* Badge size */
        .blood-requests-page .blood-request-card .badge {
            background-color: red;
            color: white;
            border-radius: 58%;
            width: 44px; /* Reduced size */
            height: 44px; /* Reduced size */
            font-size: 1rem; /* Smaller font */
            text-align: center;
            line-height: 40px;
            margin-right: 10px; /* Less margin */
        }

        /* General Paragraph Styling */
        .blood-requests-page .blood-request-card p {
            font-size: 0.9rem; /* Reduced text size */
            margin-bottom: 8px; /* Smaller margins */
            color: #6c757d;
        }

        /* Strong text styling */
        .blood-requests-page .blood-request-card strong {
            font-weight: 600;
            color: #495057;
        }

        /* User and Date Info */
        .blood-requests-page .user-id-calendar {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 1rem; /* Reduced font size */
            color: #6c757d;
        }

        /* Button Styling */
        .blood-requests-page .btn {
            margin: 8px 4px; /* Reduced margin */
            padding: 8px 15px; /* Smaller buttons */
            font-size: 0.85rem; /* Reduced font size */
        }

        .blood-requests-page .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .blood-requests-page .btn-primary:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .blood-requests-page .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .blood-requests-page .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .blood-requests-page .grid {
                grid-template-columns: 1fr; /* Single column for small screens */
            }
        }

    </style>
</head>
<body>

<div class="blood-requests-page">
    <div class="container">
        <h1>Blood Requests</h1>

        <div class="grid">
            <?php
            // Display each blood request inside a card
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="blood-request-card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <span class="badge"><?php echo $row['bg']; ?></span> 
                                <i class="fas fa-map-marker-alt ml-2"></i> <?php echo $row['locallevel']; ?>
                            </h5>
                            <hr>
                            <p class="card-text"><strong>Contact Person: </strong><?php echo $row['patient_name']; ?></p>
                            <p class="card-text"><strong>Phone: </strong><?php echo $row['phone']; ?></p>
                            <p class="card-text"><strong>Required Pint: </strong><?php echo $row['req_pint']; ?></p>
                            <p class="card-text">
                                <strong style="color:blue;"><?php echo $row['hospital']; ?></strong> at <?php echo $row['req_time'] . " on " . $row['req_date']; ?>
                            </p>
                            <p class="card-text"><strong>Case: </strong><?php echo $row['br_reason']; ?></p>
                            <hr>
                            <div class="user-id-calendar">
                                <small><i class="far fa-user"></i> ID: <?php echo $row['sid']; ?></small>
                                <small><i class="far fa-calendar"></i> <?php echo $row['br_date']; ?></small>
                            </div>
                            <div class="mt-3">
                                <a href="tel:<?php echo $row['phone']; ?>" class="btn btn-primary"><i class="fas fa-phone"></i> Call</a>
                                <a href="#" class="btn btn-secondary"><i class="fas fa-share"></i> Share</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No blood requests found.</p>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>

<?php
// Close the connection
mysqli_close($conn);
?>
