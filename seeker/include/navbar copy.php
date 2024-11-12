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
            padding-top:50px;
        }

        .navbar {
            background-color: #cc0000;
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
            /* color: #cc0000; */
            /* font-weight: bold; */
        }
        .navbar-brand-logo:hover {
            color: #cc0000; 
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
        .profile-btn {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-white bg-white fixed-top">
          <a class="navbar-brand navbar-brand-logo" href="home.php" style="color: blue;">
            <span style="color: #cc0000;"><b>DONORS</b></span>
            <span class="satisfy-regular">Nepal</span>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../seeker/home.php"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../seeker/makebloodreq.php"><i class="fas fa-plus"></i> Add Request</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="../seeker/donorrequests.php"><i class="fas fa-user-plus"></i> Become Donor</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="../seeker/seebloodreq.php"><i class="fas fa-tasks"></i> Blood Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../seeker/aboutus.php"><i class="fas fa-users"></i> About Us</a>
                </li>
                <!--  -->

                <button class="btn btn-light profile-btn" onclick="toggleProfileLinks()">
                <i class="fas fa-user"></i>
            </button>
            <div class="profile-links" id="profileLinks">
                <a href="../seeker/myprofile.php"><i class="fas fa-user"></i> My Profile</a>
                <a href="../seeker/myhistory.php"><i class="fas fa-history"></i> My History</a>
                <a href="../healthcalculator/donationcalculator.php"><i class="fas fa-calculator"></i> Health Calculator</a>
                <a href="./include/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <!-- JavaScript for toggling profile links -->
    <script>
        function toggleProfileLinks() {
            var profileLinks = document.getElementById("profileLinks");
            profileLinks.style.display = profileLinks.style.display === "block" ? "none" : "block";
        }
    </script>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>