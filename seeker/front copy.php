<?php
// Start the session and check if the user is logged in
session_start();
if (isset($_SESSION['sid'])) {
    header("Location: home.php");
    exit();
}
?>
<?php 
include 'include/frontnavbar.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | DonorsNepal</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

      /* Full width container styling */
.full-width-container {
    width: 100%;
    height: 500px;
    padding: 5px 20px;
    margin: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Styling the row inside the full-width container */
.row {
    display: flex;
    width: 100%;
    align-items: center;
    justify-content: space-between;
}

/* Left column for text and buttons */
.text-column {
    flex: 1;
    padding: 20px;
    color: black;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: left;
}

/* Styling for the heading and paragraph */
.form-container h2 {
    border-bottom: 4px solid #cc0000;
    padding-bottom: 10px;
    font-size: 2rem;
    margin-bottom: 15px;
    color: black;
}

.form-container p {
    font-size: 1.2rem;
    margin-bottom: 30px;
    color: black;
}

/* Enhanced button styles */
/* Button Styles with Gradient and Shadow */
.btn-custom {
    display: inline-flex;
    align-items: center;
    padding: 12px 24px;
    font-size: 1rem;
    font-weight: bold;
    text-align: center;
    border-radius: 50px; /* Rounded corners */
    text-decoration: none;
    transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    margin: 10px;
    color: #fff; /* White text for better contrast */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
}

/* Gradient Background for Donor Button */
.btn-danger-custom {
    background: linear-gradient(135deg, #ff4757, #e84118); /* Gradient */
    border: none;
}

.btn-danger-custom:hover {
    transform: translateY(-2px); /* Slight upward movement on hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Enhanced shadow on hover */
}

/* Gradient Background for Seeker Button */
.btn-success-custom {
    background: linear-gradient(135deg, #2ed573, #26c6da); /* Gradient */
    border: none;
}

.btn-success-custom:hover {
    transform: translateY(-2px); /* Slight upward movement on hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Enhanced shadow on hover */
}

/* Adjust icon size */
.btn-custom i {
    margin-right: 10px; /* Space between icon and text */
    font-size: 1.5rem; /* Increased icon size */
}


/* Right column for the image */
.image-column {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.custom-image {
    padding-top: 140px;
 width: 70%; 
height: 40%;
margin: 10px;
    
}


        .section {
            padding: 60px 0;
        }

        .section h2 {
            color: #cc0000;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .card-custom {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
        }

        .card-body-custom {
            padding: 20px;
        }

        .card-body-custom h3 {
            color: #cc0000;
            margin-bottom: 15px;
            font-size: 1.25rem;
        }

        .card-body-custom p {
            color: #333;
            font-size: 14px;
        }

        .urgent-call {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 40px 20px;
        }

        .urgent-call h1 {
            color: #cc0000;
            font-size: 2.5rem;
            margin: 0;
        }

        .urgent-call h3 {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .urgent-call i {
            color: #cc0000;
            font-size: 1.5rem;
        }

        .fas {
            color: #cc0000;
        }
    </style>
</head>
<body>

<!-- Full Width Hero Section -->
<div class="container-fluid full-width-container">
    <div class="row align-items-center">
        <!-- Left Column for Text and Buttons -->
        <div class="col-md-6 text-column">
            <div class="form-container">
                <h3>Welcome to DonorsNepal</h3>
                <p style="font-size: 16px;">Be the reason someone smiles today.Give blood, give life.</p>
            
                <a href="../donor/donorlogin.php" class="btn btn-danger-custom btn-custom">
        <i class="fas fa-user-md"></i> Login as Donor
    </a>
    <a href="login.php" class="btn btn-success-custom btn-custom">
        <i class="fas fa-user-friends"></i> Login as Seeker
    </a></div>
        </div>

        <!-- Right Column for Image -->
        <div class="col-md-6 image-column text-center">
            <img src="../assests/image/mobilemap.png" alt="Blood Donation" class="img-fluid custom-image">
        </div>
    </div>
</div>

<!-- Donors Recommended Section -->
<div class="container section">
    <h2>Donors Recommended for You</h2>
    <div class="row">
        <!-- Sample donor card -->
        <div class="col-md-4">
            <div class="card card-custom">
                <div class="card-body card-body-custom">
                    <h3>John Doe (A+)</h3>
                    <p><strong>Address:</strong> Kathmandu, Nepal</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom">
                <div class="card-body card-body-custom">
                <h3>John Doe (A+)</h3>
                    <p><strong>Address:</strong> Kathmandu, Nepal</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom">
                <div class="card-body card-body-custom">
                <h3>John Doe (A+)</h3>
                    <p><strong>Address:</strong> Kathmandu, Nepal</p>
                </div>
            </div>
        </div>
      
    </div>
</div>

<!-- Blood Requests Section -->
<div class="container section">
    <h2>Blood Requests</h2>
    <div class="row">
        <!-- Sample blood request card -->
        <div class="col-md-4">
            <div class="card card-custom">
                <div class="card-body card-body-custom">
                    <h3>Urgent Need for O+</h3>
                    <p><strong>Location:</strong> Kathmandu</p>
                    <p><strong>Contact:</strong> +977-9801234567</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom">
                <div class="card-body card-body-custom">
                    <h3>John Doe</h3>
                    <p><strong>Blood Group:</strong> A+</p>
                    <p><strong>Address:</strong> Kathmandu, Nepal</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom">
                <div class="card-body card-body-custom">
                    <h3>John Doe</h3>
                    <p><strong>Blood Group:</strong> A+</p>
                    <p><strong>Address:</strong> Kathmandu, Nepal</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Why DonorsNepal Section -->
<div class="container section">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-custom">
                <div class="card-body card-body-custom">
                    <i class="fas fa-heartbeat fa-3x"></i> <br>
                    <br>
                    <h3>Why Donate?</h3>
                    <p>Donating blood saves lives. It is a simple, safe, and life-changing act that helps patients in need of blood transfusions.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom">
                <div class="card-body card-body-custom">
                    <i class="fas fa-map-marker-alt fa-3x"></i>
                    <br>
                    <br>
                    <h3>Where to Donate?</h3>
                    <p>You can donate blood through our DonorsNepal system or find the nearest blood donation campaigns, donation centers, and community health centers.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom">
                <div class="card-body card-body-custom">
                    <i class="fas fa-calendar-alt fa-3x"></i>
                    <br>
                    <br>
                    <h3>When to Donate?</h3>
                    <p>After at least 3 months from your last donation. Additionally, donors must be at least 17 years old and meet weight requirements.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Urgent Blood Requests Section -->
<div class="container-fluid urgent-call">
    <div class="form-container">
        <h3>Urgent <span style="background-color:#cc0000; padding: 5px 10px; border-radius: 5px; font-size: 1.5rem;">#RagatChaiyo</span> Helpline</h3>
        <h1><i class="fas fa-phone"></i> +977-9801230045</h1>
    </div>
</div>

<!-- Footer -->
<?php include 'include/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
