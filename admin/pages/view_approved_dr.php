<?php
$conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');

$query = "SELECT * FROM users WHERE status = 'approved'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approved Requests</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="content px-3 py-4">
        <h3><small>Approved Donors Requests</small></h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>User_ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>BG</th>
                        <th>Address</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['user_id'] . "</td>";
                            echo "<td>" . $row['fullname'] . "</td>";
                            echo "<td>" . $row['phone'] . "</td>";
                            echo "<td>" . $row['bg'] . "</td>";
                            echo "<td>" . $row['district'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No approved requests found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>
