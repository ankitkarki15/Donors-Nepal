 <?php
session_start();

$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn');

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Server-side validation
    $errors = array();

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        // Prepare and execute the query
        $query = "SELECT * FROM admins WHERE email = ?";
        $statement = $conn->prepare($query);
        $statement->bind_param("s", $email);
        $statement->execute();
        // Get the result
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['admin_id'] = $row['admin_id'];
                // User login successful
                header("Location: admindash.php");
                exit;
            } else {
                $errors[] = "Invalid password";
            }
        } else {
            $errors[] = "Invalid email or password";
        }

        $statement->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Shadows+Into+Light&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Satisfy&display=swap');
        .satisfy-regular {
            font-family: "Satisfy", cursive;
            font-weight: 400;
            font-style: normal;
            color: blue;
            font-size: 32px; /* Increased font size */
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            /* background: #fff; */
            border-radius: 8px;
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
        }
        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px; 
        }
        .alert-danger {
            padding: 5px 10px;
            height: 40px;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .btn-primary {
            background-color: #0a0a23; /* Custom button background color */
            border: none;
        }
        .btn-primary:hover {
            background-color: #212529; /* Custom button hover color */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h4 class="text-center">
            <span style="color: #cc0000;"><b>DONORS</b></span>
            <span class="satisfy-regular">Nepal</span>
        </h4>
        <h6 class="text-center">Admin Login</h6>
        <hr>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" >
                <div class="invalid-feedback">
                    Please enter your email.
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" >
                <div class="invalid-feedback">
                    Please enter your password.
                </div>
            </div>
            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>
</html>
