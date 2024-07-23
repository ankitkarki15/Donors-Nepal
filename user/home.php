<?php
// Start the session and connect to the database
session_start();
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');

if (!isset($_SESSION['user_id'])) {
    die('User not logged in');
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT fullname, email FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $fullname = $user['fullname'];
    $email = $user['email'];
} else {
    die('<span style="font-weight: bold;">User not found.</span>');
}
?>
<?php
// session_start();

$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');

function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371) {
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_query = "SELECT latitude, longitude FROM users WHERE user_id = '$user_id'";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows == 1) {
        $user_data = $user_result->fetch_assoc();
        $userLat = $user_data['latitude'];
        $userLon = $user_data['longitude'];

        if (isset($_POST['bg']) && isset($_POST['district'])) {
            $bg = $_POST['bg'];
            $district = $_POST['district'];
            $radius = 10; // You can set a default radius or get it from the user

            $sql = "SELECT user_id, fullname, latitude, longitude, bg FROM users WHERE blood_group = '$bloodGroup' AND district = '$district' AND is_donor = 1";
            $result = $conn->query($sql);

            $nearbyDonors = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $distance = haversineGreatCircleDistance($userLat, $userLon, $row['latitude'], $row['longitude']);
                    if ($distance <= $radius) {
                        $row['distance'] = $distance;
                        $nearbyDonors[] = $row;
                    }
                }
            }

            if (!empty($nearbyDonors)) {
                echo "<h2>Nearby Donors:</h2>";
                echo "<ul>";
                foreach ($nearbyDonors as $donor) {
                    echo "<li>User ID: " . $donor['user_id'] . " - Name: " . $donor['fullname'] . " - Distance: " . $donor['distance'] . " km</li>";
                }
                echo "</ul>";
            } else {
                echo "No donors found within the specified radius.";
            }
        }
    } else {
        echo "User location not found.";
    }
} else {
    echo "User not logged in.";
}
?>

 <?php 

    include 'include/navbar.php'; 
    
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | DN</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- font-awesome -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
    <style>
        
.full-width-container {
            width: 100%;
            height:490px;
            padding: 5px 20px;
            margin: 0;
            background-image: url('../assests/image/header.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .form-container {
            width: 100%;
            max-width: 650px;
         
            padding: 120px;
            border-radius: 10px;
            
            text-align: center;
        }
        .text-black{
            color:black;
            text-align: justify;
            margin-top: 20px; 
        }
    
    .btn-primary {
        background-color: #cc0000; 
        width: 150px;
        border-radius:4px;
    }

    .donor-text a {
        color: white; 
        font-size:20px;
    }
    .donor-text a:hover {
        color: #cc0000;
        text-decoration:none;
    }
     
        .become-donor {
            background-color: #e9ecef;
            padding: 40px 40px;
        }
        .stats {
            background-color: #cc0000;
            padding: 40px 20px;
        }

        .bg-image {
    background-image: url('../assests/image/bg3.jpg');
    background-size: cover; /* Adjust this based on your image size */
    background-position: center;
    height:200px;
}
.urgent-call{
    background-image: url('../assests/image/bg1.jpg');
    background-size: cover; /* Adjust this based on your image size */
    background-position: center;
    height:200px;
}
        .card {
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            font-size: 1.2rem;
        }
        
    </style>
</head>
<body>
   
    
    
    <!-- First Container: Search Donors -->
    <div class="container-fluid full-width-container">
    <div class="form-container">
    <!-- <h2 style="color:white;">Donate the blood, Save the life</h2> -->
    <h2 style="border-bottom: 4px solid #cc0000; color: white; display: inline-block;margin: 0;
            position: relative;
            padding-bottom: 10px;">Search DN-Donors</h2><br><br>

<form id="searchDonorsForm" method="POST" action="">
    <div class="form-row">
        <div class="form-group col-md-6">
            <div class="input-group">
            <select class="form-control" id="district" name="district">
                    <option value="" disabled selected>Select District</option>
                    <?php
                    // Fetch districts from database and populate dropdown options
                    $query = "SELECT * FROM districts ORDER BY district_name";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"{$row['id']}\">{$row['district_name']}</option>";
                    }
                    ?>
                </select>
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="lni lni-map-marker" style="color:red !important;"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="input-group">
                <select class="form-control" id="bloodGroup" name="bloodGroup">
                    <option value="" disabled selected>Select Blood group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="lni lni-drop" style="color:red !important;"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-danger btn-lg">Search Donors</button>
    <hr style="border-bottom: 1px solid white;">
    <p class="donor-text" style="font-size:20px;">
        <a href="donorrequests.php">[ Become donor ]</a>
        <a class="nav-link" href="#" id="loginLink">[Login]</a>
    </p>
</form>

            <!-- Include modal -->
            <?php
             include 'loginmodal.php';
             ?>

    </div>
    </div>
    
    <!-- Second Container: Why Donate, Where to Donate, Donation Importance -->
    
    <div class="container mt-5 donorrecommendation">
        <div class="row text-center">
            <div class="col-md-4">
                <h3>
                <span style="text-decoration:none;"><b>Donors For you</b></span>
                    </h3>
                    <p class="text-center mt-4 text-black">Recommenddation</p>
            </div>
            
        </div>
    </div>
    
    <div class="container mt-5 why-donate">
        <div class="row text-center">
            <div class="col-md-4">
                <h3>
                <span style="text-decoration:underline;"><b>Why?</b></span>
                    </h3>
                    <p class="text-center mt-4 text-black">Donating blood saves lives. It is a simple, safe, and life-changing act that helps patients in need of blood transfusions.</p>
            </div>
            <div class="col-md-4">
            <h3><span style="text-decoration:underline;"><b>Where?</b></span></h3>
            <p class="text-center mt-4 text-black">You can donate blood through our DonorsNepal system or find the nearest blood donation campaigns,donation center and community health centers.</p>

            </div>
            <div class="col-md-4">
                <h3><span style="text-decoration:underline;"><b>When?</b></span></h3>
                <p class="text-center mt-4 text-black">After at least 3 months from your last donation. Additionally, donors must be at least 17 years old and meet weight requirements.</p>

            </div>
        </div>
    </div>
<br><br>
    <!-- Container for "Become a Donor" -->
    <div class="container-fluid full-width-container bg-image bg-dark text-white py-5">
    <div class="form-container text-center">
        <h2>Become a Blood Donor</h2>
        <p style="color:white;">Join our cause and save lives today!</p>
        <a href="register.php" class="btn btn-danger btn-lg">Donate Blood</a>
        <a href="makerequest.php" class="btn btn-danger btn-lg">View Requests</a>
    </div>
</div>

 <!-- Fourth Container: Total Donors, Total People Served, Total Blood Units Collected -->
 <div class="container mt-5 stats">
    <div class="row text-center">
        <div class="col-md-4">
            <div class="card3">
                <div style="font-weight: bold;">
                    <!-- <i class="fas fa-users"></i> -->
                    <p style="font-weight: bold; font-size:40px; color:white;">15+</p>
                    <p style="text-transform: uppercase; font-size:17px; color:white;">Total Donors</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card3">
                <div style="font-weight: bold;">
                    <!-- <i class="fas fa-hand-holding-heart"></i> -->
                    <p style="font-weight: bold; font-size:40px; color:white;">40+</p>
                    <p style="text-transform: uppercase; bold; font-size:17px; color:white;">Total people served</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card3">
                <div style="font-weight: bold;">
                    <!-- <i class="fas fa-tint"></i> -->
                    <p style="font-weight: bold; font-size:40px; color:white;">55+</p>
                    <p style="text-transform: uppercase; font-size:17px; color:white;">Total units collection</p>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
<div class="container-fluid full-width-container urgent-call bg-dark text-white py-5">
    <div class="form-container text-center">
        <h3 style="color:white;">Urgent <span style="background-color:#cc0000;font-size:28px;">#RagatChaiyo</span> helpline</h3>
        <h1 style="color:#cc0000;"><i class="fas fa-phone"></i> +977-9801230045</h1>
    </div>
</div>

    
    <br> 
    

    <div class="container mt-4">
    <h4 style=" color: black; text-align: left;">Send us messages!</h4>
    <form id="contactForm">
        <div class="form-group">
            <input type="text" class="form-control" value="<?php echo $fullname; ?>" placeholder="Full Name">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" id="contactEmail" value="<?php echo $email; ?>" placeholder="Your Email" required>
        </div>
        <div class="form-group">
            <textarea class="form-control" id="contactMessage" rows="3" placeholder="Your Message" required></textarea>
        </div>
        <button type="submit" class="btn btn-danger btn-block">Contact Us</button>
    </form>
</div>

<br><br><br>
    <?php 
    include 'include/footer.php'; 
    ?>
    
    <!-- Bootstrap JS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

</script>

</body>
</html>
