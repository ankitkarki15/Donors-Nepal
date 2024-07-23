<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer with Bootstrap</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        footer {
            background-color: #0c0c0c;
            padding: 40px 0;
            color: #333;
        }
        footer .footercontainer {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        footer h4 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #c3bfbf;
        }
        p {
            color: white;
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
        }
        footer input[type="text"] {
            width: 100%;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #0c0c0c;
        }
        footer button[type="submit"] {
            padding: 10px 20px;
            background-color: #cc0000;
            color: #fff;
            border-radius: 4px;
            border: 1px solid #0c0c0c;
            cursor: pointer;
        }
        footer button[type="submit"]:hover {
            background-color: #e74c3c;
        }
        footer .copyright {
            background-color: #151516;
            padding: 18px 0;
            margin-top: 20px;
        }
        footer .social-icons {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        footer .social-icons a {
            color: rgb(210, 206, 206);
            text-decoration: none;
            margin: 0 10px;
            font-size: 20px;
        }
        footer .social-icons a:hover {
            color: #0056b3;
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
                    <p><a href="mailto:contact@donorsnepal.com">contact@donorsnepal.com</a></p>
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
                    <h4>Useful Links</h4>
                    <ul class="list-unstyled">
                        <li><a href="#">Become donor</a></li>
                        <li><a href="#">Search donor</a></li>
                        <li><a href="#">View requests</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4>Subscribe</h4>
                    <form action="#">
                        <input type="text" class="form-control" placeholder="Email Address">
                        <button type="submit" class="btn btn-primary btn-block mt-2">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="copyright text-center">
            <p>&copy; 2024 DonorsNepal, All Rights Reserved.</p>
        </div>
        <div class="social-icons">
            <a href="#" class="fab fa-facebook"></a> <!-- Facebook Icon -->
            <a href="#" class="fab fa-instagram"></a> <!-- Instagram Icon -->
            <a href="#" class="fab fa-tiktok"></a> <!-- TikTok Icon -->
            <a href="#" class="fab fa-twitter"></a> <!-- Twitter Icon -->
        </div>
    </footer>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
