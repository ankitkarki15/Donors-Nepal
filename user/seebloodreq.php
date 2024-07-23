<?php
    include 'include/navbar.php'; 
    // Establish database connection
    $conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');
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
            background-color: #cf3d3c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            height: 200px; 
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            
        }
        .heading-background h2 {
            margin: 0;
            position: relative;
            padding-bottom: 10px; 
            border-bottom: 4px solid white; 
        }
        .card {
    width: 100%;
    background-color: #f8f9fa; /* Light gray background */
    border: 1px solid #ced4da; /* Gray border */
    border-radius: 10px; /* Rounded corners */
    margin-bottom: 20px; /* Spacing between cards */
    overflow: hidden; /* Hide overflow content */
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* Smooth transition for hover effect */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.card:hover {
    transform: translateY(-5px); /* Slight lift on hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4); /* Deeper shadow on hover */
}

.card-body {
    padding: 20px;
    background-color: #fff; /* White background */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow */
}

.card-text {
    margin-bottom: 0; /* Remove default margin */
    color: #000; /* Black text */
}

        .card-title {
            margin-bottom: 15px; /* Add spacing below title */
            font-size:15px;
        }

        .btn {
    margin-top: 10px; /* Add spacing above buttons */
    font-size: 14px; /* Adjust font size */
    border-radius: 20px; /* Rounded corners for buttons */
    padding: 8px 12px; /* Padding for buttons */
}

.user-id-calendar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 15px; /* Add spacing above user id and calendar */
}

.user-id-calendar small {
    color: #777; /* Lighter text color */
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
           // Fetch data from bloodreq table ordered by request date in descending order
        $sql = "SELECT * FROM bloodreq ORDER BY br_date DESC ";
            // $sql = "SELECT * FROM bloodreq";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while($row = mysqli_fetch_assoc($result)) {
            ?>
            <!-- Blood Request Card -->
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body"> 
                        <h5 class="card-title"><strong>Req Blood:</strong> 
                            <span id="bloodGroup" style="color: red;font-weight: bold;">
                                <strong><?php echo $row['bg']; ?></strong></span>
                                <i class="fas fa-map-marker-alt ml-2"></i><?php echo $row['district']; ?>
                            
                        </h5>
                        <hr>
                        <p class="card-text"><strong>Contact Person: </strong><?php echo $row['contact_person']; ?></p>
                        <p class="card-text"><strong>Phone: </strong><?php echo $row['phone']; ?></p>
                        <p class="card-text"><strong>Required Pint: </strong><?php echo $row['req_pint']; ?></p>
                        <p class="card-text"><strong>Hospital: </strong><?php echo $row['hospital']; ?></p>
                        <p class="card-text"><strong>Case: </strong><?php echo $row['br_reason']; ?></p>
                        <p class="card-text"><strong>Date/Time: </strong><?php echo $row['req_date'] . " " . $row['req_time']; ?></p>
                        <hr>
                        <div class="user-id-calendar">
                            <small><i class="far fa-user"></i> : <?php echo $row['user_id'];?></small>
                            <small><i class="far fa-calendar"></i> : <?php echo $row['br_date']; ?></small>
                        </div>

                        <div class="mt-0">
                            <a href="tel:<?php echo $row['phone']; ?>" class="btn btn-primary mr-2"><i class="fas fa-phone"></i> Call</a>
                            <a href="#" class="btn btn-secondary"><i class="fas fa-share"></i> Share</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                echo "No blood requests found.";
            }
            ?>
        </div>
    </div>

    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
<?php 
    // Close database connection
    mysqli_close($conn);
    include 'include/footer.php'; 
    ?>
</html>
