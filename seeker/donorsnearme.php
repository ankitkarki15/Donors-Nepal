<?php
// session_start();
include 'include/navbar.php';

// Ensure that the session variables for the logged-in seeker are set
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
$sid = isset($_SESSION['sid']) ? $_SESSION['sid'] : ''; // Use 'sid' instead of 'seeker_id'

// Initialize variables
$selectedBloodType = isset($_GET['blood_type']) ? $_GET['blood_type'] : '';
$scheduled_time = isset($_GET['scheduled_time']) ? $_GET['scheduled_time'] : ''; // Get the scheduled time from the GET request
$donation_count = isset($_GET['donation_count']) ? $_GET['donation_count'] : '';
// Get today's date and the date 7 days from now
$today = date('Y-m-d');
$maxDate = date('Y-m-d', strtotime('+7 days'));

// Validate date if the form has been submitted
$error_message = '';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($scheduled_time)) {
        if ($scheduled_time < $today || $scheduled_time > $maxDate) {
            $error_message = "Please select a date between today and the next 7 days.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donors For You</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<?php include 'include/algorithmfunction.php'; ?>

<div class="container mt-10 donorrecommendation mx-auto px-4">
    <div class="header text-center mb-10">
        <h4 class="text-center text-red-700 text-4xl font-bold uppercase relative inline-block">
            Donors Near Me
            <span class="block h-1 w-1/2 bg-red-700 mx-auto mt-2 rounded-md"></span>
        </h4>
    </div>

    <?php if (isset($_GET['message'])): ?>
        <div class="alert <?php echo strpos($_GET['message'], 'could not be sent') !== false ? 'bg-red-200 text-red-700' : 'bg-green-200 text-green-700'; ?> p-4 rounded mb-6">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
        <div class="alert bg-red-200 text-red-700 p-4 rounded mb-6"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <div class="search-form mb-8">
        <form method="get" action="" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="blood_type" class="block text-gray-700 font-medium">Select Blood Type:</label>
                    <select id="blood_type" name="blood_type" class="form-control w-full rounded-md border-gray-300">
                        <option value="">All</option>
                       
                <option value="A+" <?php if ($selectedBloodType === 'A+') echo 'selected'; ?>>A+</option>
                <option value="A-" <?php if ($selectedBloodType === 'A-') echo 'selected'; ?>>A-</option>
                <option value="B+" <?php if ($selectedBloodType === 'B+') echo 'selected'; ?>>B+</option>
                <option value="B-" <?php if ($selectedBloodType === 'B-') echo 'selected'; ?>>B-</option>
                <option value="AB+" <?php if ($selectedBloodType === 'AB+') echo 'selected'; ?>>AB+</option>
                <option value="AB-" <?php if ($selectedBloodType === 'AB-') echo 'selected'; ?>>AB-</option>
                <option value="O+" <?php if ($selectedBloodType === 'O+') echo 'selected'; ?>>O+</option>
                <option value="O-" <?php if ($selectedBloodType === 'O-') echo 'selected'; ?>>O-</option>
            
                    </select>
                </div>

                <div class="form-group">
                    <label for="scheduled_time" class="block text-gray-700 font-medium">Select Scheduled Date & Time:</label>
                    <input type="datetime-local" id="scheduled_time" name="scheduled_time" class="form-control w-full rounded-md border-gray-300" required
                        min="<?php echo date('Y-m-d\TH:i'); ?>" 
                        max="<?php echo date('Y-m-d\TH:i', strtotime('+7 days')); ?>" 
                        value="<?php echo htmlspecialchars($scheduled_time); ?>">
                </div>
            </div>

            <button type="submit" class="w-full bg-red-600 text-white font-semibold py-3 px-4 rounded-xl hover:bg-red-700 transition duration-300">
                <i class="fas fa-search mr-2"></i> Search Here
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php if (!empty($recommendations)): ?>
            <?php foreach ($recommendations as $rec): ?>
                <div class="donor-card bg-white p-4 rounded-lg shadow-lg border-t-4 border-red-600 transform hover:scale-105 transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-lg font-bold flex items-center">
                            <i class="fas fa-tint text-red-700 mr-2"></i> 
                            <span class="text-red-700"><?php echo htmlspecialchars($rec['bg']); ?></span> 
                        </h5>
                        <span class="text-black font-bold"><?php echo htmlspecialchars($rec['name']); ?></span>
                    </div>
                    <p class="mb-2">
                        <?php if ($rec['availability'] == 1): ?>
                            <span class="bg-green-200 text-green-700 px-3 py-1 rounded-full">Available</span>
                        <?php else: ?>
                            <span class="bg-red-200 text-red-700 px-3 py-1 rounded-full">Not Available</span>
                        <?php endif; ?>
                    </p>
                    <p class="mb-2"><strong>Donation count:</strong> 
                        <?php echo isset($rec['donation_count']) ? htmlspecialchars($rec['donation_count']) : "No donation history available"; ?>
                    </p>
                    <p class="mb-2"><strong>Distance:</strong> <?php echo number_format($rec['distance'], 2); ?> km</p>
                    <div class="text-right">
                        <?php if ($rec['availability'] == 1 && !empty($scheduled_time)): ?>
                            <a href="send_email.php?donor_email=<?php echo urlencode($rec['email']); ?>&seeker_email=<?php echo urlencode($email); ?>&seeker_name=<?php echo urlencode($name); ?>&seeker_phone=<?php echo urlencode($phone); ?>&scheduled_time=<?php echo urlencode($scheduled_time); ?>" 
                                class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                                <i class="fas fa-envelope"></i> Send Email
                            </a>
                        <?php else: ?>
                            <button class="btn text-gray-400 border-gray-400 py-2 px-4 rounded" disabled>
                                <i class="fas fa-envelope"></i> Send Email
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-1 md:col-span-3">
                <div class="alert bg-yellow-200 text-yellow-700 p-4 rounded">No donors found within the specified distance.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
<br><br>
<!-- Footer -->
<?php include 'include/footer.php'; ?>

</body>
</html>
