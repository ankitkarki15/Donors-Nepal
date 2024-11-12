<?php
session_start(); // Ensure session is started

if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
} else {
    header("Location: front.php"); // Redirect to login page
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | DN</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Shadows+Into+Light&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Satisfy&display=swap');
        .satisfy-regular {
            font-family: "Satisfy", cursive;
            font-weight: 400;
            font-style: normal;
            color:blue;
        }
        body {
            font-family: 'Poppins', sans-serif;
            padding-top: 50px;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .nav-item .nav-link {
            color: #cc0000;
            transition: color 0.3s;
        }
        .nav-item .nav-link:hover {
            color: blue;
        }
        .navbar-brand-logo {
            color: blue;
        }
        .profile-links {
            display: none; /* Hidden by default */
            position: absolute;
            top: 56px; 
            right: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }
        .profile-links a {
            text-decoration: none;
            color: #000;
            display: block;
            padding: 5px 10px;
        }
        .profile-links a:hover {
            background-color: #f0f0f0;
        }
       
        
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-white bg-white fixed-top">
        <a class="navbar-brand navbar-brand-logo" href="home.php">
            <span style="color: #cc0000;"><b>DONORS</b></span>
            <span class="satisfy-regular">Nepal</span>
        </a>

        <!-- Navbar Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../seeker/home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../seeker/makebloodreq.php">Add Request</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../seeker/seebloodreq.php">Blood Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../seeker/aboutus.php">About Us</a>
                </li>

                <!-- Profile Button with name inside the button -->
                <li class="nav-item">
                    <button class="btn profile-btn" onclick="toggleProfileLinks()">
                    <?php echo $name; ?>  <!-- Name dynamically inserted here -->
                    </button>
                </li>

                
            </ul>
        </div>
    </nav>

    <!-- Profile Links -->
    <div class="profile-links" id="profileLinks">
        <a href="../seeker/myprofile.php"><i class="fas fa-user"></i> My Profile</a>
        <a href="../seeker/myhistory.php"><i class="fas fa-history"></i> My History</a>
        <a href="../healthcalculator/donationcalculator.php"><i class="fas fa-calculator"></i> Health Calculator</a>
        <a href="./include/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- JavaScript for toggling profile links -->
    <script>
        function toggleProfileLinks() {
    var profileLinks = document.getElementById("profileLinks");
    if (profileLinks.style.display === "none" || profileLinks.style.display === "") {
        profileLinks.style.display = "block";
    } else {
        profileLinks.style.display = "none";
    }
}

    </script>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
