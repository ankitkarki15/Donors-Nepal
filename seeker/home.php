
<?php
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Network</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
<?php
include('include/navbar.php');
?>
    <!-- Enhanced Hero Section -->
    <div class="relative bg-gradient-to-br from-red-700 via-red-600 to-red-800 min-h-[600px] overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-500 rounded-full opacity-20"></div>
            <div class="absolute left-1/4 top-1/3 w-24 h-24 bg-red-400 rounded-full opacity-10"></div>
            <div class="absolute right-1/3 bottom-1/4 w-32 h-32 bg-red-300 rounded-full opacity-15"></div>
        </div>

        <!-- Main Hero Content -->
        <div class="container mx-auto px-4 pt-16 pb-24 relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <!-- Left Column: Hero Text -->
                <div class="lg:w-1/2 text-left lg:text-left">
                    <h1 class="text-4xl md:text-4xl lg:text-6xl font-bold text-white leading-tight mb-6">
                        Every Drop of Blood,
                        <span class="block mt-2">Can Save a Life</span>
                    </h1>
                    <p class="text-xl text-red-100 mb-8 max-w-xl">
                        Connect with blood donors in your area instantly. Your contribution today could save someone's life tomorrow.
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                        <a href="#donate" class="bg-white text-red-600 hover:bg-red-50 px-8 py-3 rounded-full font-semibold transition duration-300 flex items-center text-decoration-none">
                            <i class="fas fa-heart mr-2"></i>
                            Donate Now
                        </a>
                        <a href="#learn" class="border-2 border-white text-white hover:text-red px-8 py-3 rounded-full font-semibold transition duration-300 flex items-center text-decoration-none">
                            <i class="fas fa-info-circle mr-2"></i>
                            About Us
                        </a>
                    </div>
                </div>

                <!-- Right Column: Search Form -->
                <div class="lg:w-1/2 w-full max-w-md mx-auto">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Find Blood Donors</h2>
                        <form id="searchForm" onsubmit="return handleSearch(event)" method="POST" class="space-y-6">
                            <!-- District Select -->
                            <div class="space-y-2">
                                <label class="block text-gray-700 text-sm font-semibold">District</label>
                                <div class="relative">
                                    <select name="district" class="w-full px-2 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent appearance-none"required>
                                        <option value="" disabled selected>Select your district</option>
                                        <?php foreach ($districts as $district): ?>
                                            <option value="<?php echo $district; ?>"><?php echo $district; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-red-500"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Blood Group Select -->
                            <div class="space-y-2">
                                <label class="block text-gray-700 text-sm font-semibold">Blood Group</label>
                                <div class="relative">
                                    <select name="bloodGroup" class="w-full px-2 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent appearance-none"required>
                                        <option value="" disabled selected>Select blood group</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                        <i class="fas fa-tint text-red-500"></i>
                                    </div>
                                </div>
                            </div>

                           <!-- Search Button -->
                        <button type="button" onclick="handleSearch()" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-2 rounded-xl transition duration-300 flex items-center justify-center">
                            <i class="fas fa-search mr-2"></i>
                            Search Donors
                        </button>

                        <script>
                            function handleSearch() {
                                // AJAX code to submit form data and retrieve results without refreshing
                                const formData = new FormData(document.getElementById("searchForm")); // assuming your form has id="searchForm"
                                
                                fetch("search_donors.php", { // Replace with your actual PHP script URL
                                    method: "POST",
                                    body: formData
                                })
                                .then(response => response.text())
                                .then(data => {
                                    document.getElementById("modal-content").innerHTML = data;
                                    openModal(); // open the modal with results loaded
                                })
                                .catch(error => console.error("Error:", error));
                            }
                        </script>


                            <!-- Donors Near Me Button -->
                            <button type="button" onclick="window.location.href='donorsnearme.php';" class="w-full bg-red-70 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-2 rounded-xl transition duration-300 flex items-center justify-center border border-gray-200">
                                <i class="fas fa-location-dot mr-2 text-red-500"></i>
                                Find Donors Near Me
                            </button>

                        </form>
                    </div>
                </div>
            </div>
            
 
                        <!-- Modal for Search Results -->
<div id="donorModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-900 bg-opacity-50" tabindex="-1" role="dialog" aria-labelledby="donorModalLabel" aria-hidden="true">
    <br>  <br>
    <div class="modal-dialog modal-lg w-full max-w-4xl bg-white rounded-lg shadow-xl">
        <div class="modal-content bg-white rounded-lg">
            <div class="modal-header border-b p-4">
            <h2 class="text-3xl font-semibold text-gray-800 border-b-4 border-red-600 pb-2 inline-block">Search Results</h2><br><br>
    
                <button type="button" class="close text-gray-600" onclick="closeModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-6">
                <div id="modal-content">
                    <!-- Search results will be injected here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Example button to open modal -->
<!-- <button onclick="openModal()" class="mt-4 p-2 bg-blue-500 text-white rounded">Open Modal</button> -->

<script>
    // Function to close the modal
    function closeModal() {
        document.getElementById("donorModal").classList.add("hidden");
    }

    // Function to open the modal
    function openModal() {
        document.getElementById("donorModal").classList.remove("hidden");
    }
</script>





            
            <!-- Statistics Bar -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-white mb-1">500+</div>
                    <div class="text-red-100 text-sm">Active Donors</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-white mb-1">24/7</div>
                    <div class="text-red-100 text-sm">Support Available</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-white mb-1">1000+</div>
                    <div class="text-red-100 text-sm">Pints Donated</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-white mb-1">Kathmandu</div>
                    <div class="text-red-100 text-sm">District Covered</div>
                </div>
            </div>
        </div>
    </div>

    <!-- How to Donate Section -->
    <div class="py-16 container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">
            How to Donate Blood
            <div class="w-24 h-1 bg-red-600 mx-auto mt-4"></div>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Why Card -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="text-red-600 text-4xl mb-4 flex justify-center">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-4">Why?</h3>
                    <p class="text-gray-600 text-center">
                        Donating blood saves lives. It is a simple, safe, and life-changing act that helps patients in need of blood transfusions.
                    </p>
                </div>
            </div>

            <!-- Where Card -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="text-red-600 text-4xl mb-4 flex justify-center">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-4">Where?</h3>
                    <p class="text-gray-600 text-center">
                        You can donate blood directly to seekers or find the nearest blood donation campaigns and donation centers.
                    </p>
                </div>
            </div>

            <!-- When Card -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="text-red-600 text-4xl mb-4 flex justify-center">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-4">When?</h3>
                    <p class="text-gray-600 text-center">
                        You can donate after 3 months from your last donation. Donors must be at least 17 years old and meet weight requirements.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Become a Donor Section -->
    <div class="bg-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Become a Blood Donor</h2>
            <p class="text-gray-600 mb-8">Join our cause and save lives today!</p>
            <div class="space-x-4">
                <a href="../donor/donorregister.php" class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 text-decoration-none">
                    <i class="fas fa-user-plus mr-2"></i>Join as Donor
                </a>
                <a href="makebloodreq.php" class="inline-block border-2 border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-semibold py-3 px-6 rounded-lg transition duration-300 text-decoration-none">
                    <i class="fas fa-hands-helping mr-2"></i>Make Request
                </a>
            </div>
        </div>
    </div>

    <!-- Urgent Call Section -->
    <div class="bg-gray-900 py-12">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-3xl font-bold text-white mb-4">
                Urgent <span class="bg-red-600 px-3 py-1 rounded">#RagatChaiyo</span> Helpline
            </h3>
            <div class="text-4xl font-bold text-red-600 mt-4">
                <i class="fas fa-phone mr-2"></i>+977-9801230045
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">
                What People Say
                <div class="w-24 h-1 bg-red-600 mx-auto mt-4"></div>
            </h2>
            
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <p class="text-gray-600 text-lg italic mb-4">
                        "Donating blood was a simple act, but it made a big difference in someone's life. I encourage everyone to donate and help save lives!"
                    </p>
                    <p class="text-gray-500 font-medium">— Jane Doe, Blood Donor</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="py-16 container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">
            Contact Us
            <div class="w-24 h-1 bg-red-600 mx-auto mt-4"></div>
        </h2>
        
        <div class="max-w-2xl mx-auto">
            <form id="contactForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                        <input type="text" value="<?php echo htmlspecialchars($name); ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent "readonly>

                    </div>
                    <div>
                    <label class="block text-gray-700 font-semibold mb-2">Message</label>
                    <textarea rows="5" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" required></textarea>
                </div>
                </div>
                
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
                    Send Message
                </button>
            </form>
        </div>
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