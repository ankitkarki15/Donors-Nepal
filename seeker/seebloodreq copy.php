<?php
    include 'include/navbar.php';
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
            padding: 50px;
            background: linear-gradient(135deg, #f4f4f4, #e2e2e2);
        }
        .heading-background h2 {
            color: #333;
            font-size: 32px;
            border-bottom: 4px solid #d9534f;
        }
        .card {
            width: 100%;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            font-family: 'Arial', sans-serif;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
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
            color: black;
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
            color: black;
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
            place-items: center;
            border: 2px solid #fff;
        }
    </style>
</head>
<body>
    <div class="container-fluid heading-background">
        <h2 class="text-center mb-4">View Blood Requests</h2>
    </div>
    <div class="container mt-5">
        <div class="row">
            <?php
                $sql = "SELECT * FROM bloodreq ORDER BY br_date DESC";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <span class="badge"><?php echo $row['bg']; ?></span>
                            <span><i class="fas fa-map-marker-alt"></i> <?php echo $row['locallevel']; ?></span>
                        </h5>
                        <hr>
                        <p class="card-text"><strong>Contact Person: </strong><?php echo $row['patient_name']; ?></p>
                        <p class="card-text"><strong>Phone: </strong><?php echo $row['phone']; ?></p>
                        <p class="card-text"><strong>Required Pint: </strong><?php echo $row['req_pint']; ?></p>
                        <p class="card-text"><strong>Hospital: </strong><?php echo $row['hospital']; ?></p>
                        <p class="card-text"><strong>Case: </strong><?php echo $row['br_reason']; ?></p>
                        <p class="card-text"><strong>Date/Time: </strong><?php echo $row['req_date'] . " " . $row['req_time']; ?></p>
                        <hr>
                        <div class="user-id-calendar">
                            <small><i class="far fa-user"></i> : <?php echo $row['sid']; ?></small>
                            <small><i class="far fa-calendar"></i> <?php echo $row['br_date']; ?></small>
                        </div>
                        <div class="mt-3">
                            <a href="#" class="btn btn-primary mr-2"><i class="fas fa-share"></i> Share</a>
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
