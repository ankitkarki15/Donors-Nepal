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
        @import url('https://fonts.googleapis.com/css2?family=Satisfy&display=swap');
        .satisfy-regular {
        font-family: "Satisfy", cursive;
        font-weight: 400;
        font-style: normal;
        color:blue;
        }
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .logo {
            font-family: 'Satisfy', cursive;
            font-size: 32px;
            margin-bottom: 30px;
            color: #cc0000;
            
        }
        .logo a {
            text-decoration:none;
        }
        .login-content {
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
   
    <?php 
    // include 'include/adminnav.php'; 
    ?>

    <div class="login-container">
        <a class="logo">
        <span style="color: #cc0000;"><b>DONORS</b></span>
    <span class="satisfy-regular">Nepal</span></strong>
        </a>
        <div class="login-content">
            <h3>Login as Admin</h3>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Admin Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter admin email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Admin Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter admin password" name="pswd" required>
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
