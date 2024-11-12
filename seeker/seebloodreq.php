<?php
    include 'include/navbar.php';
   
?>
<?php

    $conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Blood Requests</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
       .heading-background {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 40px;
    background: linear-gradient(135deg, #f9f9f9, #e0e0e0);
}

.heading-background h2 {
    color: #444;
    font-size: 28px;
    border-bottom: 4px solid #d9534f;
    padding-bottom: 10px;
}

.card {
    width: 100%;
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 10px;
    margin-bottom: 20px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    font-family: 'Arial', sans-serif;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
}

.card-body {
    padding: 20px;
}

.card-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    font-size: 18px;
    font-weight: bold;
}

.card-text {
    margin-bottom: 10px;
    color: #555;
}

.btn {
    margin-top: 10px;
    font-size: 14px;
    border-radius: 20px;
    padding: 10px 15px;
    background-color: #d9534f;
    border: none;
    color: #fff;
}

.btn:hover {
    background-color: #c0392b;
}

.user-id-calendar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 15px;
    font-size: 18px;
    color: #555;
}

.user-id-calendar small {
    display: flex;
    align-items: center;
}

.user-id-calendar i {
    margin-right: 5px;
}

.card-title .badge {
    background-color: #d9534f;
    color: #fff;
    border-radius: 50px;
    height: 40px;
    width: 40px;
    font-size: 18px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #fff;
}

.container {
    max-width: 1200px;
    margin: auto;
}

@media (max-width: 768px) {
    .card {
        margin-bottom: 15px;
    }

    .btn {
        padding: 8px 12px;
    }
}

    </style>
</head>
<body>
    <div class="container-fluid heading-background">
        <h2 class="text-center mb-4">View Blood Requests</h2>
    </div>

    <!-- Location Filter -->
    <div class="container mt-3">
        <form method="POST" id="locationFilterForm">
            <div class="form-group row">
                <label for="locationFilter" class="col-sm-2 col-form-label">Filter by Location:</label>
                <div class="col-sm-6">
                    <select name="locationFilter" id="locationFilter" class="form-control">
                        <option value="">All Locations</option>
                        <?php
                            $locationSql = "SELECT DISTINCT locallevel FROM bloodreq ORDER BY locallevel ASC";
                            $locationResult = mysqli_query($conn, $locationSql);
                            if (mysqli_num_rows($locationResult) > 0) {
                                while($locationRow = mysqli_fetch_assoc($locationResult)) {
                                    echo "<option value='".$locationRow['locallevel']."'>".$locationRow['locallevel']."</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-danger">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Blood Requests -->
    <div class="container mt-3">
        <div class="row">
            <?php
                // If filter is applied
                $locationFilter = '';
                if (isset($_POST['locationFilter']) && $_POST['locationFilter'] != '') {
                    $locationFilter = $_POST['locationFilter'];
                    $sql = "SELECT * FROM bloodreq WHERE locallevel = '$locationFilter' ORDER BY br_date DESC";
                } else {
                    $sql = "SELECT * FROM bloodreq ORDER BY br_date DESC";
                }

                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-md-4 blood-request-item">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Blood Group: <?php echo $row['bg']; ?></h5>
                        <p class="card-text"><strong>Location:</strong> <?php echo $row['locallevel']; ?></p>
                        <p class="card-text"><strong>Contact:</strong> <?php echo $row['patient_name']; ?> (<?php echo $row['phone']; ?>)</p>
                        <p class="card-text"><strong>Hospital:</strong> <?php echo $row['hospital']; ?></p>
                        <p class="card-text"><strong>Date/Time:</strong> <?php echo $row['req_date'] . " " . $row['req_time']; ?></p>
                        <div class="text-right">
                            <a href="#" class="btn btn-info"><i class="fas fa-share"></i> Share</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                } else {
                    echo "<div class='col-12'><p class='text-center'>No blood requests found.</p></div>";
                }
            ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
<?php
    mysqli_close($conn);
    include 'include/footer.php';
?>
</html>
