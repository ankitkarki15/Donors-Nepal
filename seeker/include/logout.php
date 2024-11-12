<?php
session_start();

// If the user confirms logout, destroy the session
if (isset($_POST['logout'])) {
    session_destroy();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout | DonorsNepal</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        /* Initial hidden state and animation for the popup */
        .popup-box {
            text-align: center;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(50px); /* Slide from below */
            animation: fadeInUp 0.5s forwards; /* Animation triggers on page load */
        }

        /* Animation keyframes for fade-in and slide-up */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Style the heading and paragraph */
        .popup-box h1 {
            color: #cc0000;
            margin-bottom: 20px;
            font-size: 28px;
            animation: fadeIn 1s ease-in-out;
        }

        .popup-box p {
            margin-bottom: 20px;
            font-size: 18px;
            color: #555;
            animation: fadeIn 1s ease-in-out 0.3s;
        }

        /* Buttons */
        .popup-box button {
            color: white;
            background-color: #cc0000;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        /* Button hover effects */
        .popup-box button:hover {
            background-color: #a30000;
            transform: translateY(-3px); /* Button slight lift effect */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow on hover */
        }

        /* Style for the cancel button */
        .popup-box .cancel-btn {
            background-color: gray;
        }

        .popup-box .cancel-btn:hover {
            background-color: darkgray;
        }
    </style>
</head>
<body>

<div class="popup-box">
    <h1>Are you sure you want to log out?</h1>
    <p>This action will log you out of your account.</p>
    <button id="confirmLogout">Yes, Log me out</button>
    <button class="cancel-btn" id="cancelLogout">Cancel</button>
</div>

<script>
// Handle logout confirmation
document.getElementById('confirmLogout').addEventListener('click', function() {
    // Create a POST request to destroy the session
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('logout=true');

    // Redirect to front.php after the session is destroyed
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            window.location.href = '../front.php';
        }
    };
});

// Handle cancel action
document.getElementById('cancelLogout').addEventListener('click', function() {
    // Simply redirect to the homepage without logging out
    window.location.href = '../front.php';
});
</script>

</body>
</html>
