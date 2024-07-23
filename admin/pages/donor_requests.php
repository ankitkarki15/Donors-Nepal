<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="content px-3 py-4">
        <h3><small>Pending Donors Requests</small></h3>
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // Establish database connection
                    $conn = mysqli_connect('localhost', 'root', 'ankit', 'dn') or die('Connection failed');

                    // Handle form submissions
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['approved'])) {
                            $userId = $_POST['user_id'];
                            $sql = "UPDATE donorreq SET status = 'Approved' WHERE user_id = '$userId'";
                            $conn->query($sql);
                        } elseif (isset($_POST['delete'])) {
                            $userId = $_POST['user_id'];
                            $sql = "DELETE FROM donorreq WHERE user_id = '$userId'";
                            $conn->query($sql);
                        } elseif (isset($_POST['rejected'])) {
                            $userId = $_POST['user_id'];
                            $sql = "UPDATE donorreq SET status = 'Rejected' WHERE user_id = '$userId'";
                            $conn->query($sql);
                        }
                    }

                    // Fetch pending requests
                    $sql = "SELECT donorreq.user_id, users.fullname, users.phone, donorreq.bg, donorreq.district, donorreq.status 
                            FROM donorreq 
                            INNER JOIN users ON donorreq.user_id = users.user_id 
                            WHERE donorreq.status = 'Pending'";
                    $result = $conn->query($sql);

                    $result = $conn->query($sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['user_id'] . "</td>";
                            echo "<td>" . $row['fullname'] . "</td>";
                            echo "<td>" . $row['phone'] . "</td>";
                            echo "<td>" . $row['bg'] . "</td>";
                            echo "<td>" . $row['district'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>";
                            // Approve button
                            echo '<form method="post" style="display:inline;">
                                    <input type="hidden" name="user_id" value="' . $row['user_id'] . '">
                                    <button type="submit" name="approved" class="btn btn-link p-0" onclick="return confirm(\'Do you want to approve this request?\');">
                                        <i class="fas fa-check text-success mr-3"></i>
                                    </button>
                                  </form>';
                            // Delete button
                            echo '<form method="post" style="display:inline;">
                                    <input type="hidden" name="user_id" value="' . $row['user_id'] . '">
                                    <button type="submit" name="delete" class="btn btn-link p-0" onclick="return confirm(\'Do you want to delete this request?\');">
                                        <i class="fas fa-trash mr-3"></i>
                                    </button>
                                  </form>';
                            // Reject button
                            echo '<form method="post" style="display:inline;">
                                    <input type="hidden" name="user_id" value="' . $row['user_id'] . '">
                                    <button type="submit" name="rejected" class="btn btn-link p-0" onclick="return confirm(\'Do you want to reject this request?\');">
                                        <i class="fas fa-times text-danger mr-3"></i>
                                    </button>
                                  </form>';
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No Pending requests found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
