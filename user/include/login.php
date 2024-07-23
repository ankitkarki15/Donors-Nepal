<?php
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('connection failed');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_id = $_POST['login_id'];
    $password = $_POST['password'];

    // Determine if the login ID is an email or mem_id
    if (filter_var($login_id, FILTER_VALIDATE_EMAIL)) {
        $sql = $conn->prepare("SELECT mem_id, password FROM users WHERE email = ?");
        $sql->bind_param("s", $login_id);
    } else {
        $sql = $conn->prepare("SELECT mem_id, password FROM users WHERE mem_id = ?");
        $sql->bind_param("s", $login_id);
    }

    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo json_encode(['success' => true, 'message' => 'Login successful', 'mem_id' => $row['mem_id']]);
            // Here you can start a session and store user information
            // session_start();
            // $_SESSION['mem_id'] = $row['mem_id'];
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid password']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }

    $sql->close();
}
$conn->close();
?>
