<?php
// Ensure the database connection is included if it's not already
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dndb') or die('Connection failed');

// Set how many donors you want to display per page
$donorsPerPage = 5;

// Get the current page from the URL, default to page 1 if not set
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $donorsPerPage;

// Fetch the total number of donors for pagination calculation
$totalDonorsQuery = "SELECT COUNT(*) AS total FROM donors WHERE drid != ?";
$stmt = $conn->prepare($totalDonorsQuery);
$stmt->bind_param('s', $_SESSION['drid']);
$stmt->execute();
$result = $stmt->get_result();
$totalDonors = $result->fetch_assoc()['total'];
$totalPages = ceil($totalDonors / $donorsPerPage);

// Fetch the current page of donors
$donorsQuery = "SELECT name, email, last_donation, bg, locallevel, district FROM donors WHERE drid != ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($donorsQuery);
$stmt->bind_param('sii', $_SESSION['drid'], $donorsPerPage, $offset);
$stmt->execute();
$donorsResult = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor List with Pagination</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
        }

        .container {
            margin: 40px auto;
            max-width: 1000px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #f7f7f7;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            font-size: 0.85rem;
            font-weight: 500;
        }

        td {
            vertical-align: middle;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .blood-group-circle {
            display: inline-block;
            text-align: center;
            border-radius: 50%;
            background-color: #dc3545;
            color: #fff;
            width: 50px;
            height: 50px;
            line-height: 50px;
            font-size: 18px;
            font-weight: bold;
        }

        .donor-info strong {
            display: block;
            font-size: 1.1rem;
            color: #333;
        }

        .donor-info small {
            font-size: 0.9rem;
            color: #777;
        }

        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #007bff;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        .action-btn:hover {
            color: #0056b3;
        }

        .center-text {
            text-align: center;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            color: #007bff;
            padding: 10px 15px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 5px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #f1f1f1;
        }

        .pagination .current-page {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        @media (max-width: 768px) {
            th, td {
                padding: 10px;
            }

            .blood-group-circle {
                width: 40px;
                height: 40px;
                line-height: 40px;
                font-size: 16px;
            }

            .action-btn {
                font-size: 1rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h3>Other Donors</h3>
        <?php if ($donorsResult->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th class="center-text">Blood Group</th>
                    <th>Donor Info</th>
                    <th>Last Donation</th>
                    <th>Location</th>
                    <th class="center-text">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($donor = $donorsResult->fetch_assoc()): ?>
                <tr>
                    <td class="center-text">
                        <div class="blood-group-circle">
                            <?php echo htmlspecialchars($donor['bg']); ?>
                        </div>
                    </td>
                    <td class="donor-info">
                        <strong><?php echo htmlspecialchars($donor['name']); ?></strong>
                        <small><?php echo htmlspecialchars($donor['email']); ?></small>
                    </td>
                    <td><?php echo htmlspecialchars($donor['last_donation']); ?></td>
                    <td><?php echo htmlspecialchars($donor['locallevel']); ?>, <?php echo htmlspecialchars($donor['district']); ?></td>
                    <td class="center-text">
                        <button class="action-btn" onclick="sendMail('<?php echo htmlspecialchars($donor['email']); ?>')">
                            <i class="fas fa-envelope"></i>
                        </button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'current-page' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <p>No other donors found.</p>
        <?php endif; ?>
    </div>

    <script>
        function sendMail(email) {
            alert(`An email will be sent to ${email}`);
        }
    </script>
</body>
</html>
