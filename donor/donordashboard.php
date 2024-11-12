<?php
session_start();
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Check if the user is logged in
if (!isset($_SESSION['drid'])) {
    header('Location: donorlogin.php');
    exit();
}

$drid = $_SESSION['drid'];

// Fetch donor information
$query = "SELECT * FROM donors WHERE drid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $drid);
$stmt->execute();
$donor = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch other donors
$donorsQuery = "SELECT * FROM donors WHERE drid != ?";
$stmt = $conn->prepare($donorsQuery);
$stmt->bind_param('s', $drid);
$stmt->execute();
$donorsResult = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="assests/style/donordash.css">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">DONORS <span class="satisfy-regular">Nepal</span></a>
                </div>
            </div>
<!-- start of sidebar nav -->
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="?page=home" class="sidebar-link">
                    <i class="lni lni-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="?page=blood_requests" class="sidebar-link">
                        <i class="lni lni-popup"></i>
                        <span>View Blood Requests</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#request" aria-expanded="false" aria-controls="auth">
                        <!-- <i class="lni lni-consulting"></i> -->
                        <i class="lni lni-slideshare"></i>
                        <span>History</span>
                    </a>
                    <ul id="request" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="?page=update_donation" class="sidebar-link">Update Donation date</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="?page=donation_history"  class="sidebar-link">My Donation History</a>
                        </li>
                    </ul>
                </li>
                
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#donors" aria-expanded="false" aria-controls="auth">
                        <i class="lni lni-users"></i>
                        <span>Profile&Settings</span>
                    </a>
                    <ul id="donors" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="?page=profile" class="sidebar-link">My Profile</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="?page=setting"  class="sidebar-link">Setting</a>
                        </li>
                    </ul>
                </li>
                
                <li class="sidebar-item">
                    <a href="?page=notifications" class="sidebar-link">
                        <i class="lni lni-popup"></i>
                        <span>Notification</span>
                    </a>
                </li>
                <li class="sidebar-item">
                <a href="?page=otherdonors" class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Other Donors</span>
                    </a>
                </li>
                
            </ul>

            <div class="sidebar-footer">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <!-- end of sidebar -->
        <div class="main">
            <nav class="navbar navbar-expand px-4 py-3">
                <form action="#" class="d-none d-sm-inline-block">
                <div class="input-group input-group-nabar">
                <input type="text" class="form-control border=0 rounded=0" placeholder="search..">
                <button class="btn border=0 rounded=0" type="button">
                   search
                </button>
                </div>
             </form>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                            <i class="lni lni-popup"></i>
                            </a>
                    </li>
                    <li class="nav-item dropdown ms-3">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <i class="lni lni-user"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end rounded">
                            <a href="" class="dropdown-item">
                            <i class="lni lni-cog"></i>
                            <span>Settings</span>
                            </a>

                            <a href="" class="dropdown-item">
                            <i class="lni lni-cog"></i>
                            <span>Analytics</span>
                            </a>

                            <a href="" class="dropdown-item">
                            <i class="lni lni-exit"></i>
                            <span>Logout</span>
                            </a>
                            </div>
                        </li>
                    </ul>
                    
                </div>
            </nav>            
            <main>
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                $pageFile = "pages/$page.php";
                if (file_exists($pageFile)) {
                    include($pageFile);
                } else {
                    echo "<h1>Page not found</h1>";
                }
                ?>
            </main>
            <br><br><br><br>
            <?php
                include'include/footer.php'
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="assests/js/script.js"></script>
    <script>
function showContent(id) {
  // Hide all content elements
  const contents = document.querySelectorAll('.content');
  contents.forEach(content => content.classList.remove('active'));

  // Show the selected content element
  const selectedContent = document.getElementById(id);
  selectedContent.classList.add('active');
}
    </script>
</body>

</html>