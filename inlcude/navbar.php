<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        .navbar-brand{
            
        }
        .nav-item .nav-link {
            color: #cc0000; /* Navigation item color */
        }
        .nav-item .nav-link:hover {
            color: grey;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-white bg-white">
        <a class="navbar-brand" href="#"><span style="color: #cc0000; font-weight:bold;"><b>DONORS</b></span> Nepal</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-plus"></i> Add Request</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../user/register.php"><i class="fas fa-user-plus"></i> Become Donor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-tasks"></i> Blood Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-user"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</body>
</html>
