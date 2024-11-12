<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer with Bootstrap</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        footer {
            background-color: #0c0c0c;
            color: #ffffff;
            padding: 40px 0;
        }
        .footercontainer {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        footer h4 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #c3bfbf;
        }
        p {
            margin-bottom: 8px;
        }
        footer a {
            color: #fafafa;
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
        }
        footer a:hover {
            color: #cc0000;
            text-decoration: underline;
        }
        footer input[type="text"] {
            width: 100%;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #333;
            background-color: #1a1a1a;
            color: #fff;
        }
        footer button[type="submit"] {
            padding: 10px 20px;
            background-color: #cc0000;
            color: #fff;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
        footer button[type="submit"]:hover {
            background-color: #e74c3c;
        }
        .copyright {
            background-color: #151516;
            padding: 18px 0;
            margin-top: 20px;
            color: #ccc;
        }
        .social-icons {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .social-icons a {
            color: #d2cece;
            text-decoration: none;
            margin: 0 10px;
            font-size: 24px;
        }
        .social-icons a:hover {
            color: #e74c3c;
        }
        .list-unstyled li {
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <footer>
        <div class="footercontainer container">
            <div class="row">
                <div class="col-md-3">  
                    <h4>Contact</h4>
                    <p>9876543210</p>
                    <p><a href="mailto:donate.donarsnepal@gmail.com">donate.donarsnepal@gmail.com</a></p>
                    <p>Lokanthali, Bhaktapur</p>
                </div>
                <div class="col-md-3">
                    <h4>Useful Links</h4>
                    <ul class="list-unstyled">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4>More Links</h4>
                    <ul class="list-unstyled">
                        <li><a href="#">Become a Donor</a></li>
                        <li><a href="#">Search Donor</a></li>
                        <li><a href="#">View Requests</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4>Send Message</h4>
                    <form action="#">
                        <input type="text" class="form-control" placeholder="Your Message">
                        <button type="submit" class="btn">Send</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="copyright text-center">
            <p>&copy; 2024 DonorsNepal, All Rights Reserved.</p>
        </div>
        <div class="social-icons">
            <a href="#" class="fab fa-facebook"></a> 
                        <a href="#" class="fab fa-instagram"></a> 
            <a href="#" class="fab fa-tiktok"></a> 
                        <a href="#" class="fab fa-twitter"></a>
        </div>
    </footer>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
