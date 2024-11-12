<?php

$hash = '$2y$10$OWS6RK9MPwXvPb/Q2IxX/eNYN4CkjGv6Ito./ibvN7tfH13AZvCqe';
$password = 'suspected_password';

if (password_verify($password, $hash)) {
    echo 'Password is correct!';
} else {
    echo 'Invalid password.';
}
?>