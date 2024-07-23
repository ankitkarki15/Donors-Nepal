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
            /* background: rgba(255, 255, 255, 0.8); */
            padding: 120px;
            border-radius: 10px;
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 1); */
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
        /* .why-donate {
            background-color: #f8f9fa;
            padding: 50px 20px;
        } */
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
            /* width: 120px;
            height: 120px; */
            /* border-radius: 4px; */
            /* background-color: #007bff;   */
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            font-size: 1.2rem;
        }
        /* .footer {
            background-color: #343a40;
            color: white;
        } */

  
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

        <form id="searchDonorsForm">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="input-group">
                        <select class="form-control" id="district">
                            <option value="" disabled selected>Select District</option>
                            <option value="Kathmandu">Kathmandu</option>
                            <option value="Bhaktapur">Bhaktapur</option>
                        </select>
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <!-- <i class="fas fa-map-marker-alt" style="color:red !important;"></i> -->
                                <i class="lni lni-map-marker"style="color:red !important;"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group">
                        
                        <select class="form-control" id="bloodGroup">
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
            <a href="#" class="btn btn-danger btn-lg">Search Donors</a>
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

    
    <br> <br>
    

<!-- Container for "Contact Us" Form -->
<!-- Container for "Contact Us" Form -->
<div class="container mt-4">
        <h2 style="border-bottom: 4px solid #cc0000; color: Black; display: inline-block;margin: 0;
            position: relative;
            padding-bottom:10px; text-align:center;">Contact Us</h2><br><br>
        <form id="contactForm">
            <div class="form-group">
                <div class="col-md-12"><label class="labels">Full Name</label><input type="text" class="form-control" value="<?php echo $fullname; ?>"></div>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" id="contactEmail" value="<?php echo $email; ?>" placeholder="Your Email" required>
            </div>
            <div class="form-group">
                <textarea class="form-control" id="contactMessage" rows="5" placeholder="Your Message" required></textarea>
            </div>
            <a href="#" class="btn btn-danger btn-lg">Contact Us</a>
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
