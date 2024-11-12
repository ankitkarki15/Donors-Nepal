<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Pagination logic
$requestsPerPage = 5; 
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $requestsPerPage;

// Determine the category: New or Old requests based on a URL parameter
$category = isset($_GET['category']) ? $_GET['category'] : 'new';

// Calculate date 5 days ago
$dateThreshold = date('Y-m-d', strtotime('-5 days'));

// Fetch blood requests based on the category
if ($category === 'old') {
    $sql = "SELECT * FROM bloodreq WHERE br_date <= '$dateThreshold' ORDER BY br_date DESC LIMIT $requestsPerPage OFFSET $offset";
} else {
    $sql = "SELECT * FROM bloodreq WHERE br_date > '$dateThreshold' ORDER BY br_date DESC LIMIT $requestsPerPage OFFSET $offset";
}

$result = mysqli_query($conn, $sql);

// Fetch total number of blood requests for pagination calculation
$totalRequestsQuery = "SELECT COUNT(*) AS total FROM bloodreq WHERE br_date " . ($category === 'old' ? "<=" : ">") . " '$dateThreshold'";
$totalRequestsResult = mysqli_query($conn, $totalRequestsQuery);
$totalRequestsRow = mysqli_fetch_assoc($totalRequestsResult);
$totalRequests = $totalRequestsRow['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Requests</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
  /* Global Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
}

/* Card Styles */
.card {
    background-color: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    max-width: 100%;
    height: auto; /* Height is reduced */
    overflow: hidden;
    position: relative;
}

/* Card hover effect */
.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

/* Blood group circle */
.blood-group {
    display: inline-block;
    font-size: 18px;
    font-weight: bold;
    color: white;
    background-color: #ff5f6d;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    position: relative;
}

/* Blood group hover effect */
.blood-group:hover {
    background-color: #00b09b; /* Color change on hover */
    transition: background-color 0.3s ease;
}

/* Card Content */
.card-content {
    text-align: center;
}

.card-header {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
}

.card-body {
    font-size: 16px;
    color: #666;
    margin-bottom: 10px;
}

/* Button Styles */
.custom-btn {
    display: inline-block;
    padding: 12px 24px;
    background-color: #ff5f6d;
    background-image: linear-gradient(to right, #ff9966, #ff5f6d);
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
    text-decoration: none;
    border: none;
    border-radius: 50px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.custom-btn:hover {
    background-image: linear-gradient(to right, #ff5f6d, #ff9966);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

.custom-btn.active {
    background-image: linear-gradient(to right, #00b09b, #96c93d);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.custom-btn:hover::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 300%;
    height: 300%;
    background: rgba(255, 255, 255, 0.15);
    transform: rotate(45deg);
    transition: all 0.5s ease;
}

.custom-btn.active:hover {
    transform: translateY(-4px);
}

.custom-btn:not(:last-child) {
    margin-right: 15px;
}

/* Spacing adjustments */
.text-center {
    text-align: center;
}

/* Animation for moving requests to old after 5 days */
@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

/* Hidden old requests */
.old-request {
    display: none;
}

.new-request {
    display: block;
}


    </style>
</head>
<body>

<div class="blood-requests-page">
    <div class="container">
        <h1 class="text-center my-4">Blood Requests</h1>

        <!-- Toggle buttons for New and Old requests with modern design -->
        <div class="text-center mb-4">
            <a href="blood_requests.php?category=new" class="custom-btn <?= $category === 'new' ? 'active' : '' ?>">New Requests</a>
            <a href="blood_requests.php?category=old" class="custom-btn <?= $category === 'old' ? 'active' : '' ?>">Old Requests</a>
        </div>


        <!-- Render blood requests dynamically based on category (New or Old) -->
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="blood-request-card">
                <div class="card-body">
                    <h5 class="card-title">
                        <!-- Blood group with 50% border radius -->
                        <span class="badge bg-danger" style="border-radius: 50%; padding: 10px;"><?= $row['bg'] ?></span>
                        <i class="fas fa-map-marker-alt ml-2"></i> <?= $row['locallevel'] ?>
                    </h5>
                    <hr>
                    <p class="card-text"><strong>Contact Person: </strong><?= $row['patient_name'] ?></p>
                    <p class="card-text"><strong>Phone: </strong><?= $row['phone'] ?></p>
                    <p class="card-text"><strong>Required Pint: </strong><?= $row['req_pint'] ?></p>
                    <p class="card-text"><strong>Hospital: </strong><?= $row['hospital'] ?></p>
                    <p class="card-text"><strong>Case: </strong><?= $row['br_reason'] ?></p>
                    <p class="card-text"><strong>Date/Time: </strong><?= $row['req_date'] . " " . $row['req_time'] ?></p>
                    <div class="mt-3">
                        <a href="tel:<?= $row['phone'] ?>" class="btn btn-primary mr-2"><i class="fas fa-phone"></i> Call</a>
                        <a href="#" class="btn btn-secondary"><i class="fas fa-share"></i> Share</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

        <!-- Pagination logic -->
        <?php
        $totalPages = ceil($totalRequests / $requestsPerPage);
        if ($totalPages > 1) {
            echo '<ul class="pagination justify-content-center">';
            for ($i = 1; $i <= $totalPages; $i++) {
                $activeClass = ($i == $page) ? 'class="page-item active"' : 'class="page-item"';
                echo "<li $activeClass><a class='page-link' href='blood_requests.php?category=$category&page=$i'>$i</a></li>";
            }
            echo '</ul>';
        }
        ?>
    </div>
</div>

</body>
</html>



