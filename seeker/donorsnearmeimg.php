<?php 
session_start();
include 'include/navbar.php'; 

// Ensure that the session variables for the logged-in seeker are set
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
$sid = isset($_SESSION['sid']) ? $_SESSION['sid'] : ''; // Use 'sid' instead of 'seeker_id'
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
        <button type="submit" class="btn btn-custom">Filter</button>
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
                                <a href="#" class="btn btn-outline-primary btn-sm mb-2"
                                   data-toggle="modal" data-target="#uploadProofModal"
                                   onclick="setDonorEmail('<?php echo urlencode($rec['email']); ?>')">
                                    <i class="fas fa-envelope"></i> Send Email
                                </a>
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

<!-- Modal -->
<div class="modal fade" id="uploadProofModal" tabindex="-1" role="dialog" aria-labelledby="uploadProofModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadProofModalLabel">Upload Blood Requirement Proof</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="proofUploadForm" method="post" enctype="multipart/form-data" action="send_email.php">
                <div class="modal-body">
                    <input type="hidden" name="donor_email" value="" id="donor_email">
                    <input type="hidden" name="seeker_email" value="<?php echo htmlspecialchars($email); ?>">
                    <input type="hidden" name="seeker_name" value="<?php echo htmlspecialchars($name); ?>">
                    <input type="hidden" name="seeker_phone" value="<?php echo htmlspecialchars($phone); ?>">
                    
                    <div class="form-group">
                        <label for="proofDocument">Upload Proof Document:</label>
                        <input type="file" class="form-control-file" name="proofDocument" id="proofDocument" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
function setDonorEmail(email) {
    document.getElementById('donor_email').value = email;
}
</script>
</body>
</html>
