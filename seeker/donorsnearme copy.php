<?php 
session_start();
include 'include/navbar.php'; 

// Ensure that the session variables for the logged-in seeker are set
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
$sid = isset($_SESSION['sid']) ? $_SESSION['sid'] : ''; // Use 'sid' instead of 'seeker_id'

// Initialize variables
$selectedBloodType = isset($_GET['blood_type']) ? $_GET['blood_type'] : '';
$schedule_time = isset($_GET['schedule_time']) ? $_GET['schedule_time'] : ''; // Get the scheduled time from the GET request

// Get today's date and the date 7 days from now
$today = date('Y-m-d');
$maxDate = date('Y-m-d', strtotime('+7 days'));

// Validate date if the form has been submitted
$error_message = '';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($schedule_time)) {
        if ($schedule_time < $today || $schedule_time > $maxDate) {
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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="include/assests/css/donorsnearme.css">
</head>
<body>

<?php include 'include/algorithmfunction.php'; ?>

<div class="container mt-5 donorrecommendation">
    <div class="header text-center">
        <h3><span style="text-decoration:none;"><b>Donors Near You</b></span></h3>
    </div>

    <!-- Display the message if present -->
    <?php if (isset($_GET['message'])): ?>
        <div class="message <?php echo strpos($_GET['message'], 'could not be sent') !== false ? 'error' : 'success'; ?>">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Display error message if validation fails -->
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <form class="mb-4" method="get" action="">
        <div class="form-group">
            <label for="blood_type">Select Blood Type:</label>
            <select id="blood_type" name="blood_type" class="form-control">
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
        <!-- Scheduled Date Input -->
        <div class="form-group">
            <label for="schedule_time">Select Scheduled Date:</label>
            <input type="date" id="schedule_time" name="schedule_time" class="form-control" required 
                   min="<?php echo $today; ?>" max="<?php echo $maxDate; ?>" value="<?php echo htmlspecialchars($schedule_time); ?>">
        </div>
        <button type="submit" class="btn btn-custom">Search Here</button>
    </form>

    <div class="row">
    <?php if (!empty($recommendations)): ?>
        <?php foreach ($recommendations as $rec): ?>
            <div class="col-md-4 mb-4">
                <div class="donor-card card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <span class="blood-type"><?php echo htmlspecialchars($rec['bg']); ?></span>
                            <?php echo htmlspecialchars($rec['name']); ?>
                        </h5>
                        <p class="card-text">
                            <?php if ($rec['availability'] == 1): ?>
                                <span class="badge badge-success">Available</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Not Available</span>
                            <?php endif; ?>
                        </p>
                        <p class="card-text">
                            <?php echo htmlspecialchars($rec['district']); ?>, 
                            <?php echo htmlspecialchars($rec['locallevel']); ?>
                        </p>
                        <p class="card-text"><b>Distance:</b> <?php echo number_format($rec['distance'], 2); ?> km</p>
                        <div class="text-right">
                            <?php if (!empty($schedule_time)): // Only show the button if a date is selected ?>
                                <a href="send_email.php?donor_email=<?php echo urlencode($rec['email']); ?>&seeker_email=<?php echo urlencode($email); ?>&seeker_name=<?php echo urlencode($name); ?>&seeker_phone=<?php echo urlencode($phone); ?>&schedule_time=<?php echo urlencode($schedule_time); ?>" class="btn btn-outline-primary btn-sm mb-2">
                                    <i class="fas fa-envelope"></i> Send Email
                                </a>
                            <?php else: ?>
                                <button class="btn btn-outline-secondary btn-sm mb-2" disabled>
                                    <i class="fas fa-envelope"></i> Send Email
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-md-12">
            <div class="alert alert-warning no-results">No donors found within the specified distance.</div>
        </div>
    <?php endif; ?>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Footer -->
<?php include 'include/footer.php'; ?>

</body>
</html>
