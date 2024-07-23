<?php
include'../include/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Calculator</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Donation Calculator</h2>
        <form id="donationCalculatorForm">
            <div class="form-group">
                <label for="lastDonationDate">Last Donation Date:</label>
                <input type="date" class="form-control" id="lastDonationDate" required>
            </div>
            <div class="form-group">
                <label for="nextDonationDate">Next Available Donation Date:</label>
                <input type="text" class="form-control" id="nextDonationDate" readonly>
            </div>
            <div class="form-group">
                <label>Eligibility Criteria for Blood Donation:</label>
                <ul>
                    <li>You should be in good health.</li>
                    <li>You should be at least 17 years old.</li>
                    <li>Your body weight should be at least 50 kg or 110 pounds.</li>
                    <li>You should complete at least 90 days from your last donation date.</li>
                </ul>
            </div>
            <button type="submit" class="btn btn-primary">Calculate</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#donationCalculatorForm').submit(function(event) {
                event.preventDefault(); // Prevent the form from submitting
                
                // Perform donation calculation here
                var lastDonationDate = new Date($('#lastDonationDate').val());
                var nextDonationDate = new Date(lastDonationDate);
                nextDonationDate.setMonth(nextDonationDate.getMonth() + 3); // Assuming a 3-month donation period
                
                // Format the date to display in the input field
                var formattedNextDonationDate = nextDonationDate.toISOString().split('T')[0];
                $('#nextDonationDate').val(formattedNextDonationDate);
            });
        });
    </script>
</body>
<br>
<?php
include'../include/footer.php';
?>
</html>
