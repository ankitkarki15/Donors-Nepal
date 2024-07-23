<?php include('../include/userprofile.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            border: 2px solid white;
        }
        .container {
            margin-top: 50px;
            margin-bottom: 70px;
        }
        .profile-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .profile-card .labels {
            font-weight: bold;
        }
        .profile-button {
            border: none;
            color: white;
        }
        .profile-button:hover {
            background-color: #990000;
        }
        .bg {
            background-color: #cc0000;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            font-size: 36px;
            font-weight: bold;
            border-radius: 50%;
            text-transform: uppercase;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php include('../include/usernav.php'); ?>

<div class="container rounded bg-white">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <span class="bg"><?php echo $bg; ?></span>
                <span class="font-weight-bold mt-3"><?php echo $fullname; ?></span>
                <span class="text-black"><?php echo $email; ?></span>
                <span class="text-black">ID: <strong><?php echo $user_id; ?></strong></span>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right"><u>Profile Settings</u></h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label class="labels">Full Name</label>
                        <input type="text" class="form-control" value="<?php echo $fullname; ?>">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="labels">Mobile Number</label>
                        <input type="text" class="form-control" value="<?php echo $phone; ?>">
                    </div>
                    <div class="col-md-12">
                        <label class="labels">DOB</label>
                        <input type="date" class="form-control" name="dob" value="<?php echo $dob; ?>">
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Blood Group</label>
                        <select class="form-control" name="blood_group">
                            <option value="">Select Blood Group</option>
                            <option value="A+" <?php if ($bg == 'A+') echo 'selected'; ?>>A+</option>
                            <option value="A-" <?php if ($bg == 'A-') echo 'selected'; ?>>A-</option>
                            <option value="B+" <?php if ($bg == 'B+') echo 'selected'; ?>>B+</option>
                            <option value="B-" <?php if ($bg == 'B-') echo 'selected'; ?>>B-</option>
                            <option value="AB+" <?php if ($bg == 'AB+') echo 'selected'; ?>>AB+</option>
                            <option value="AB-" <?php if ($bg == 'AB-') echo 'selected'; ?>>AB-</option>
                            <option value="O+" <?php if ($bg == 'O+') echo 'selected'; ?>>O+</option>
                            <option value="O-" <?php if ($bg == 'O-') echo 'selected'; ?>>O-</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Address:</h4>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="labels">District</label>
                        <input type="text" class="form-control" value="<?php echo $district; ?>" readonly>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Locality</label>
                        <input type="text" class="form-control" value="<?php echo $locallevel; ?>" readonly>
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <button class="btn btn-primary profile-button" type="button">Update Profile</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center experience">
                    <span><strong>Blood Donation</strong></span>
                </div><br>
                <div class="col-md-12">
                    <label class="labels">Available for Blood Donation?</label><br>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="availability" id="donateYes" value="1" <?php echo isset($availability) && $availability == 1 ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="donateYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="availability" id="donateNo" value="0" <?php echo isset($availability) && $availability == 0 ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="donateNo">No</label>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
