<?php
session_start();
unset($_SESSION['email']);
header("location: ../login.php"); // Redirects back to login.php in the user folder
exit;
?>

<!-- user is a folder
>include
    >>navbar.php
    >>logout.php
    >>login.php
>login.php
here this 3 >>file is located on include folder and include folder
 and login.php file located on user folder.now give me logout.php code .
 and also 
 <a class="dropdown-item" href="./login.php"><i class="fas fa-sign-out-alt"></i> Logout</a> -->
