<?php
// Establish database connection
$conn = new mysqli('localhost', 'root', 'ankit', 'dndb');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fetch approved donors
$sql = "SELECT sid, name, email,bg,phone FROM seekers ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Approved Donors</title>
    <style>
        .content {
            margin: 20px;
        }
        .table-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div id="viewdonors" class="content px-3 py-4">
        <h3><small>View Blood Seekers</small></h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Seeker ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Blood group</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['sid']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['bg']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                            echo "<td>";
                            echo '<button class="btn btn-sm btn-primary">Delete</button> ';
                           
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No approved donors found.</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
