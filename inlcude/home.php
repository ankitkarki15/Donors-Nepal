<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | DN</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .full-width-container {
            width: 100%;
            padding: 40px 20px;
            margin: 0;
            min-height: 100vh; /* Ensure the container takes up at least the full height of the viewport */
            background-image: url('../assests/image/bg1.jpg');
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
        
        .why-donate {
            background-color: #f8f9fa;
            padding: 50px 20px;
        }
        .become-donor {
            background-color: #e9ecef;
            padding: 40px 40px;
        }
        .stats {
            /* background-color: #f8f9fa; */
            padding: 40px 20px;
        }
        .card {
            width: 120px;
            height: 120px;
            border-radius: 4px;
            /* background-color: #007bff; */
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            font-size: 1rem;
        }
        .footer {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Include navbar.php -->
    <?php 
    //  include '../include/db.php';
    include '../include/navbar.php'; 
    ?>

    <!-- First Container: Search Donors -->
    <div class="container-fluid full-width-container">
    <!-- <h2 style="color:white;">Donate the blood, Save the life</h2> -->
        <h2 style="border-bottom: 6px solid #cc0000; ; display: inline-block;">Search Donors</h2><br> 
        <form id="searchDonorsForm">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <select class="form-control" id="district" required>
                        <option value="" disabled selected>Select District</option>
                        <option value="Kathmandu">Kathmandu</option>
                        <option value="Bhaktapur">Bhaktapur</option>
                        <!-- Add options for other districts -->
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <select class="form-control" id="bloodGroup" required>
                        <option value="" disabled selected>Select  Blood </option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <!-- Second Container: Why Donate, Where to Donate, Donation Importance -->
    <div class="container mt-5 why-donate">
        <div class="row text-center">
            <div class="col-md-4">
                <h3>01.Why Donate?</h3>
                <p>Donating blood saves lives. It is a simple, safe, and life-changing act that helps patients in need of blood transfusions.</p>
            </div>
            <div class="col-md-4">
                <h3>02.Where to Donate?</h3>
                <p>You can donate blood at local hospitals, blood donation camps, and community health centers. Find the nearest donation center and make a difference.</p>
            </div>
            <div class="col-md-4">
                <h3>03.Donation Importance</h3>
                <p>Blood donations are crucial for surgeries, cancer treatments, chronic illnesses, and traumatic injuries. Your donation can make a significant impact.</p>
            </div>
        </div>
    </div>
 <!-- Fourth Container: Total Donors, Total People Served, Total Blood Units Collected -->
 <div class="container mt-5 stats">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card">
                    <div>
                        <i class="fas fa-users"></i>
                        <p>Total Donors</p>
                        <p>1500</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div>
                        <i class="fas fa-hand-holding-heart"></i>
                        <p>Total People Served</p>
                        <p>1200</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div>
                        <i class="fas fa-tint"></i>
                        <p>Total Blood Units</p>
                        <p>900</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Third Container: Become a Donor, Register -->
    <div class="container mt-5 become-donor text-center">
        <div class="row">
            <div class="col-md-6">
                <a href="become_donor.php" class="btn btn-success btn-lg">Become a Donor</a>
            </div>
            <div class="col-md-6">
                <a href="register.php" class="btn btn-primary btn-lg">Register</a>
            </div>
        </div>
    </div>

   

    <!-- Footer -->
    <footer class="footer mt-5 py-3 text-center">
        <div class="container">
            <span>&copy; 2024 DonorsNepal</span>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
