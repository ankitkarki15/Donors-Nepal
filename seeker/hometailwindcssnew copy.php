<?php
// Start the session
session_start();
if (!isset($_SESSION['sid'])) {
    header("Location: front.php");
    exit();
}

// Include database connection
include('include/db.php');

// Fetch available districts and blood groups for search filters
$districts = [];
$bloodGroups = [];

// Fetch distinct districts
$sql = "SELECT DISTINCT district FROM donors";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $districts[] = $row['district'];
}

// Fetch distinct blood groups
$sql = "SELECT DISTINCT bg FROM donors";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $bloodGroups[] = $row['bg'];
}

// Close connection
$conn->close();
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
    <link rel="stylesheet" href="assests/style/home.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

</head>
<body>

<?php include 'include/navbar.php'; ?>
<!-- Main Content -->
<div class="container-fluid full-width-container">
  <div class="search-container mx-auto p-4">
    <h2 class="text-center font-weight-bold text-white mb-2" style="border-bottom: 4px solid #cc0000;padding-bottom: 10px;">Welcome to Donors Nepal</h2><br>

    <!-- Search Form -->
    <form class="search-form" id="searchForm" method="POST">
      <div class="form-row">
        <!-- District Dropdown -->
        <div class="form-group col-md-12">
          <div class="input-group">
            <select class="form-control" id="district" name="district" required aria-label="Select District">
              <option value="" disabled selected>Select Districts</option>
              <?php foreach ($districts as $district): ?>
                <option value="<?php echo $district; ?>"><?php echo $district; ?></option>
              <?php endforeach; ?>
            </select>
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="lni lni-map-marker"></i>
              </span>
            </div>
          </div>
        </div>

        <!-- Blood Group Dropdown -->
        <div class="form-group col-md-12">
          <div class="input-group">
            <select class="form-control" id="bloodGroup" name="bloodGroup" required aria-label="Select Blood Group">
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
                <i class="lni lni-drop"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <button type="submit" name="search" class="btn btn-danger btn-block">Search Donors</button>
    </form>

    <!-- Donors Near Me Button -->
    <form id="donorsnearme" method="POST" action="donorsnearme.php" class="mt-3">
      <button type="submit" class="btn btn-primary btn-block">
        <i class="fas fa-map-marker-alt mr-2"></i> Find Donors Near Me
      </button>
    </form>
  </div>
</div>

<!-- Modal for Search Results -->
<div id="donorModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="donorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="donorModalLabel" style="color:black;">Search Results</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="modal-content">
          <!-- Search results will be injected here -->
        </div>
      </div>
    </div>
  </div>
</div>  
<!-- Second Container: Why Donate -->
<div class="container mt-5 why-donate" style="padding: 3rem 0;">
<h2 style="text-align: center; margin-bottom: 2rem; color: #cc0000; font-size: 2.5rem; font-weight: 600; position: relative; display: inline-block; text-transform: uppercase;">
       How to donate blood
        <span style="display: block; height: 4px; width: 50%; background-color: #cc0000; margin: 0.5rem auto 0; border-radius: 2px;"></span>
    </h2>
    <div class="row text-center">
        <!-- Card 1: Why? -->
        <div class="col-md-4" style="animation: fadeInUp 0.8s;">
            <a href="#" style="text-decoration: none; color: inherit;">
                <div class="card" style="border: none; box-shadow: 0 8px 20px rgba(0,0,0,0.1); height: 100%; transition: transform 0.3s ease-in-out;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center" style="padding: 2rem; height: 100%; text-align: center;">
                        <div style="font-size: 3rem; color: #cc0000;"><i class="fas fa-heartbeat"></i></div>
                        <h3 style="margin-top: 10px;"><b>Why?</b></h3>
                        <p class="text-center mt-4" style="color: black; font-size: 1rem;">Donating blood saves lives. It is a simple, safe, and life-changing act that helps patients in need of blood transfusions.</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 2: Where? -->
        <div class="col-md-4" style="animation: fadeInUp 1s;">
            <a href="#" style="text-decoration: none; color: inherit;">
                <div class="card" style="border: none; box-shadow: 0 8px 20px rgba(0,0,0,0.1); height: 100%; transition: transform 0.3s ease-in-out;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center" style="padding: 2rem; height: 100%; text-align: center;">
                        <div style="font-size: 3rem; color: #cc0000;"><i class="fas fa-map-marker-alt"></i></div>
                        <h3 style="margin-top: 10px;"><b>Where?</b></h3>
                        <p class="text-center mt-4" style="color: black; font-size: 1rem;">You can donate blood directly to seekers or find the nearest blood donation campaigns and donation centers.</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 3: When? -->
        <div class="col-md-4" style="animation: fadeInUp 1.2s;">
            <a href="" style="text-decoration: none; color: inherit;">
                <div class="card" style="border: none; box-shadow: 0 8px 20px rgba(0,0,0,0.1); height: 100%; transition: transform 0.3s ease-in-out;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center" style="padding: 2rem; height: 100%; text-align: center;">
                        <div style="font-size: 3rem; color: #cc0000;"><i class="fas fa-calendar-alt"></i></div>
                        <h3 style="margin-top: 10px;"><b>When?</b></h3>
                        <p class="text-center mt-4" style="color: black; font-size: 1rem;">You can donate after 3 months from your last donation. Donors must be at least 17 years old and meet weight requirements.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Keyframes for Animation -->
<style>
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hover effect for cards */
.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
}
</style>


<br><br>
<!-- Container for "Become a Donor" -->
<div class="container-fluid" style="background-color:#ffff; padding: 5rem 0;">
    <div class="form-container text-center" style="padding: 3rem; border-radius: 10px; margin: auto;">
        <h2 style="margin-bottom: 1.5rem;">Become a Blood Donor</h2>
        <p style="color: #333; margin-bottom: 2rem;">Join our cause and save lives today!</p>
        <!-- "Join as Donor" button with icon -->
        <a href="../donor/donorregister.php" class="btn btn-success btn-lg" style="margin-right: 1rem;">
            <i class="fas fa-user-plus mr-2"></i>Join as Donor
        </a>
        <!-- "Make Request" button with icon -->
        <a href="makebloodreq.php"  class="btn btn-outline-danger btn-lg">
            <i class="fas fa-hands-helping mr-2"></i>Make Request
        </a>
    </div>
</div>


<!-- Urgent Call Container -->
<div class="container-fluid full-width-container urgent-call bg-dark text-white py-5">
    <div class="form-container text-center">
        <h3 class="mb-3" style="color: white; font-weight: 600; font-size: 32px;">
            Urgent <span style="background-color: #cc0000; padding: 0.2rem 0.5rem; color: white; border-radius: 2px;">#RagatChaiyo</span> Helpline
        </h3>
        <h1 style="color: #cc0000; font-size: 42px; font-weight: 700; margin-top: 1.5rem;">
            <i class="fas fa-phone mr-2"></i> +977-9801230045
        </h1>
    </div>
</div>


<!-- Testimonials Container -->
<div class="container-fluid text-center" style="background-color: #f5f5f5; padding: 5rem 0;">
    <h2 style="text-align: center; margin-bottom: 2rem; color: #cc0000; font-size: 2.5rem; font-weight: 600; position: relative; display: inline-block; text-transform: uppercase;">
        What People Say
        <span style="display: block; height: 4px; width: 50%; background-color: #cc0000; margin: 0.5rem auto 0; border-radius: 2px;"></span>
    </h2>
    
    <div class="row justify-content-center" style="padding: 0 2rem;">
        <!-- Testimonial 1 -->
        <div class="col-md-4" style="margin-bottom: 2rem; animation: fadeInUp 1s;">
            <div style="background-color: #fff; border-radius: 10px; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1); padding: 2rem; transition: all 0.3s ease-in-out;">
                <p style="font-size: 1.1rem; color: #333; line-height: 1.6; margin-bottom: 1.5rem;">"Donating blood was a simple act, but it made a big difference in someone’s life. I encourage everyone to donate and help save lives!"</p>
                <p style="font-size: 0.95rem; color: #666; font-style: italic;">— Jane Doe, Blood Donor</p>
            </div>
        </div>

        <!-- Testimonial 2 -->
        <div class="col-md-4" style="margin-bottom: 2rem; animation: fadeInUp 1.2s;">
            <div style="background-color: #fff; border-radius: 10px; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1); padding: 2rem; transition: all 0.3s ease-in-out;">
                <p style="font-size: 1.1rem; color: #333; line-height: 1.6; margin-bottom: 1.5rem;">"As someone who has received blood in a critical moment, I am incredibly grateful to the donors who made it possible. Thank you for your selfless act of kindness!"</p>
                <p style="font-size: 0.95rem; color: #666; font-style: italic;">— John Smith, Blood Recipient</p>
            </div>
        </div>

        <!-- Testimonial 3 -->
        <div class="col-md-4" style="margin-bottom: 2rem; animation: fadeInUp 1.4s;">
            <div style="background-color: #fff; border-radius: 10px; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1); padding: 2rem; transition: all 0.3s ease-in-out;">
                <p style="font-size: 1.1rem; color: #333; line-height: 1.6; margin-bottom: 1.5rem;">"The process of donating blood was smooth, and the experience was fulfilling. I highly recommend people to contribute to such a noble cause."</p>
                <p style="font-size: 0.95rem; color: #666; font-style: italic;">— Sarah Lee, Blood Donor</p>
            </div>
        </div>
    </div>
</div>

<!-- Keyframes for animation -->
<style>
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }

    /* Hover effect for testimonial cards */
    .col-md-4 div:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }
}
</style>

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
        <button type="submit" class="btn btn-primary">Send Message</button>
 </form>
</div>

<br><br><br>
<?php include 'include/footer.php'; ?>

<!-- jQuery and Bootstrap scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- Script to handle the modal display for search results -->
<script>
    $(document).ready(function() {
        $('#searchForm').on('submit', function(event) {
            event.preventDefault();  // Prevent the form from submitting normally
            var formData = $(this).serialize();  // Serialize form data

            // Send an AJAX request to search_donors.php
            $.ajax({
                type: 'POST',
                url: 'search_donors.php',
                data: formData,
                success: function(response) {
                    // Inject the search results into the modal body
                    $('#modal-content').html(response);
                    // Show the modal
                    $('#donorModal').modal('show');
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>


</body>
</html>