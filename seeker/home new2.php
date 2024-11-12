<?php
// Start the session and connect to the database
session_start();
if (!isset($_SESSION['sid'])) {
    header("Location: front.php");
    exit();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMZFpD3YHtK8hZ+60t3M/I8OgK7c6cZ6K8kHfE" crossorigin="anonymous">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
    <link rel="stylesheet" href="include/assests/css/home.css">
</head>
<body>

<div class="container-fluid full-width-container">
    <div class="form-container">
        <h2 style="border-bottom: 4px solid #cc0000; color: black; display: inline-block; margin: 0; position: relative; padding-bottom: 10px;">Welcome to Donors Nepal</h2><br><br>
        <form method="POST" action="search_donors.php">
            <div class="form-row">
                <div class="form-group">
                    <div class="input-group">
                        <select class="form-control" id="district" name="district" required>
                            <option value="" disabled selected>Select Districts</option>
                            <?php
                            // Fetch districts from database and populate dropdown options
                            $conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');
                            $query = "SELECT DISTINCT district FROM donors ORDER BY district";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value=\"{$row['district']}\">{$row['district']}</option>";
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
                <div class="form-group">
                    <div class="input-group">
                        <select class="form-control" id="bloodGroup" name="bloodGroup" required>
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
                <div class="form-group">
                    <button type="submit" name="search" class="btn btn-danger" data-toggle="modal" data-target="#searchResultsModal">Search Donors</button>
                </div>
            </div>
        </form>

        <!-- Donors near me -->
        <form id="donorsnearme" method="POST" action="donorsnearme.php">
            <hr class="border-b border-white">
            <button type="submit" class="donor-text bg-red-600 text-black font-bold py-2 px-4 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 flex items-center">
                <i class="fas fa-search mr-2"></i>
                Find Donors near me
            </button>
        </form>
    </div>
</div>

<!-- Second Container: Why Donate -->
<div class="container mt-5 why-donate">
    <div class="row text-center">
        <div class="col-md-4">
            <div class="card" style="border: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1); height: 100%;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="padding: 2rem; height: 100%; text-align: center;">
                    <div style="font-size: 3rem; color: #cc0000;"><i class="fas fa-heartbeat"></i></div>
                    <h3 style="margin-top: 10px;"><b>Why?</b></h3>
                    <p class="text-center mt-4" style="color: black;font-size: 1rem;">Donating blood saves lives. It is a simple, safe, and life-changing act that helps patients in need of blood transfusions.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="border: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1); height: 100%;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="padding: 2rem; height: 100%; text-align: center;">
                    <div style="font-size: 3rem; color: #cc0000;"><i class="fas fa-map-marker-alt"></i></div>
                    <h3 style="margin-top: 10px;"><b>Where?</b></h3>
                    <p class="text-center mt-4" style="color: black;font-size: 1rem;">You can donate blood through us directly to seekers or find the nearest blood donation campaigns, donation centers.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="border: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1); height: 100%;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center" style="padding: 2rem; height: 100%; text-align: center;">
                    <div style="font-size: 3rem; color: #cc0000;"><i class="fas fa-calendar-alt"></i></div>
                    <h3 style="margin-top: 10px;"><b>When?</b></h3>
                    <p class="text-center mt-4" style="color: black;font-size: 1rem;">After at least 3 months from your last donation. Additionally, donors must be at least 17 years old and meet weight requirements.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br>
<!-- Container for "Become a Donor" -->
<div class="container-fluid" style="background-color:#fbfbfb; padding: 5rem 0;">
    <div class="form-container text-center" style="padding: 3rem; border-radius: 10px; margin: auto;">
        <h2 style="margin-bottom: 1.5rem;">Become a Blood Donor</h2>
        <p style="color: #333; margin-bottom: 2rem;">Join our cause and save lives today!</p>
        <a href="../donor/donorregister.php" class="btn btn-danger btn-lg" style="margin-right: 1rem;">Join as Donor</a>
        <a href="makerequest.php" class="btn btn-danger btn-lg">Make Request</a>
    </div>
</div>

<!-- Urgent Call Container -->
<div class="container-fluid full-width-container urgent-call bg-dark text-white py-5">
    <div class="form-container text-center">
        <h3 style="color:white;">Urgent <span style="background-color:#cc0000; font-size:28px;">#RagatChaiyo</span> helpline</h3>
        <h1 style="color:#cc0000;"><i class="fas fa-phone"></i> +977-9801230045</h1>
    </div>
</div>

<!-- Testimonials Container -->
<div class="container-fluid text-center" style="background-color: #f5f5f5; padding: 5rem 0;">
    <h2 style="text-align: center; margin-bottom: 2rem; color: #cc0000; position: relative; display: inline-block;">
        What People Say
        <span style="display: block; height: 4px; width: 50%; background-color: #cc0000; margin: 0.5rem auto 0;"></span>
    </h2>
    <div class="row text-center" style="padding: 0 2rem;">
        <!-- Testimonial 1 -->
        <div class="col-md-4">
            <div class="testimonial">
                <p style="font-size: 1rem; color: #333; margin-bottom: 1rem;">"Donating blood was a simple act, but it made a big difference in someone’s life. I encourage everyone to donate and help save lives!"</p>
                <p style="font-size: 0.875rem; color: #666;">— Jane Doe, Blood Donor</p>
            </div>
        </div>

        <!-- Testimonial 2 -->
        <div class="col-md-4">
            <div class="testimonial">
                <p style="font-size: 1rem; color: #333; margin-bottom: 1rem;">"As someone who has received blood in a critical moment, I am incredibly grateful to the donors who made it possible. Thank you for your selfless act of kindness!"</p>
                <p style="font-size: 0.875rem; color: #666;">— John Smith, Blood Recipient</p>
            </div>
        </div>

        <!-- Testimonial 3 -->
        <div class="col-md-4">
            <div class="testimonial">
                <p style="font-size: 1rem; color: #333; margin-bottom: 1rem;">"Donating blood was a simple act, but it made a big difference in someone’s life. I encourage everyone to donate and help save lives!"</p>
                <p style="font-size: 0.875rem; color: #666;">— Jane Doe, Blood Donor</p>
            </div>
        </div>
    </div>
</div>

<!-- Contact Us Form Container -->
<div class="container mt-4">
    <h2 style="border-bottom: 4px solid #cc0000; color: Black; display: inline-block; margin: 0; position: relative; padding-bottom: 10px; text-align: center;">Contact Us</h2><br><br>
    <form id="contactForm" class="contact-form">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="labels" for="fullName" style="font-weight: bold;">Full Name</label>
                <input type="text" id="fullName" class="form-control" value="<?php echo $fullname; ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label class="labels" for="contactEmail" style="font-weight: bold;">Email</label>
                <input type="email" id="contactEmail" class="form-control" value="<?php echo $email; ?>" placeholder="Your Email" required>
            </div>
        </div>
        <div class="form-group">
            <label class="labels" for="contactMessage" style="font-weight: bold;">Message</label>
            <textarea class="form-control" id="contactMessage" rows="5" placeholder="Your Message" required></textarea>
        </div>
        <button type="submit" class="btn btn-danger btn-lg">Send Message</button>
    </form>
</div>

<br><br><br>
<?php
include 'include/footer.php';
?>

</body>
</html>
