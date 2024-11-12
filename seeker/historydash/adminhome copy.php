<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home | DN</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
        }

       
        .login-content {
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
            margin-top:100px;
            margin-bottom:100px;
        }
    </style>
</head>
<body>
   
    <?php 
    include 'include/adminnav.php'; 
    ?>

    <div class="container">
        <!-- <div class="content">
            <h3>hi, <span>Admin</span></h3>
            <h1>welcome <span></span></h1>
            
        </div> -->

        <div class="login-content">
            <h3>Login as Admin</h3>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Admin Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Admin Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required>
                </div>
                <button type="submit" class="btn btn-dark btn-block">Login</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php 
    include 'include/adminfooter.php'; 
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
