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
        }
        .container {
            margin-top: 70px;
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
            background-color: #cc0000;
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
    
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card profile-card">
                <div class="card-body">
                    <div class="title">
                        <h4 class="card-title">Hi, <span style="color:red;"><?php echo $fullname; ?></span></h4>
                        <span class="blood-group"><?php echo $bg; ?></span>
                    </div>
                    <form>
                        <div class="form-group">
                            <label for="memberID">Membership ID: <b><?php echo $user_id; ?></b></label>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" value="<?php echo $email; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" class="form-control" id="phone" value="<?php echo $phone; ?>">
                        </div>
                        <div class="form-group">
                            <label for="address">District:</label>
                            <input type="text" class="form-control" id="address" value="<?php echo $district; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="locallevel">Locality:</label>
                            <input type="text" class="form-control" id="locallevel" value="<?php echo $locallevel; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Do you want to donate blood?</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="donateBlood" id="donateYes" value="yes" checked>
                                <label class="form-check-label" for="donateYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="donateBlood" id="donateNo" value="no">
                                <label class="form-check-label" for="donateNo">No</label>
                            </div>
                        </div>
                    </form>
                    <button type="submit" class="btn btn-update">Update Profile</button>
                </div>
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
