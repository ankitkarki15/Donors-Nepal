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
        
        body {
            font-family: 'Poppins', sans-serif;
            padding-top: 40px;
        }

        .navbar {
            background-color: #cc0000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar .nav-link {
            color:black;
            transition: color 0.3s;
        }
        .navbar .nav-link:hover {
            color: blue;
        }
        .navbar-brand-logo {
            color: #cc0000;
        }
        .navbar-brand-logo:hover {
            color: #cc0000;
        }
        .navbar-brand span.satisfy-regular {
            font-family: "Satisfy", cursive;
            font-weight: 400;
            font-style: normal;
            color: blue;
        }

        .dropdown-menu {
            color: #cc0000;
        }
        .dropdown-menu .dropdown-item {
            color: black;
        }
        .dropdown-menu .dropdown-item:hover {
            color: #ff6666;
        }

        .btn-primary {
            background-color: ;
            border: none;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-white bg-white fixed-top">
        <a class="navbar-brand navbar-brand-logo" href="front.php">
            <span style="color: #cc0000;"><b>DONORS</b></span>
            <span class="satisfy-regular">Nepal</span>
        </a>
        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->

        <!-- Nav items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="../seeker/front.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../seeker/frontaboutus.php">About Us</a>
                </li>
                <li class="nav-item">
                <a href="../donor/donorlogin.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors">
                Login <i class="fas fa-arrow-circle-right ml-2"></i>
                </a>
                </li>
            </ul>
        </div>
        <button class="block md:hidden text-gray-700 hover:text-red-500 transition-colors" id="navbar-toggle">
        <i class="fas fa-bars"></i>
      </button>
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
