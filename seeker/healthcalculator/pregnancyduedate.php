<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregnancy Due Date Calculator</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Pregnancy Due Date Calculator</h2>
        <form id="pregnancyDueDateCalculatorForm">
            <div class="form-group">
                <label for="lastPeriodDate">Last Period Date:</label>
                <input type="date" class="form-control" id="lastPeriodDate" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="calculateDueDate()">Calculate</button>
            <div id="dueDateResult" class="mt-3"></div>
            <div class="form-group mt-3">
                <label>Note:</label>
                <p>The due date calculation is based on the average 28-day cycle.</p>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function calculateDueDate() {
            var lastPeriodDate = new Date($('#lastPeriodDate').val());
            var dueDate = new Date(lastPeriodDate);
            dueDate.setDate(dueDate.getDate() + 280); // Assuming a 28-day cycle
            
            // Format the date to display
            var formattedDueDate = dueDate.toISOString().split('T')[0];

            // Display the result
            $('#dueDateResult').html('<p>Your expected delivery date is: ' + formattedDueDate + '</p>');
        }
    </script>
</body>
</html>
