<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Period Calculator</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Period Calculator</h2>
        <form id="periodCalculatorForm">
            <div class="form-group">
                <label for="lastPeriodDate">Last Period Date:</label>
                <input type="date" class="form-control" id="lastPeriodDate" required>
            </div>
            <!-- <div class="form-group">
                <label for="dueDate">Expected Due Date for Next Period:</label>
                <input type="text" class="form-control" id="dueDate" readonly>
            </div> -->
            <div class="form-group">
                <!-- <label for="dueDateResult">Result:</label> -->
                <div id="dueDateResult" class="mt-3"></div>
            <div class="form-group mt-3">
            <button type="button" class="btn btn-primary" onclick="calculateDueDate()">Calculate</button>
            <br><br>
            <div class="form-group">
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
            dueDate.setDate(dueDate.getDate() + 28); // Assuming a 28-day cycle
            
            // Format the date to display
            var formattedDueDate = dueDate.toISOString().split('T')[0];
            
            // Display the result
            $('#dueDate').val(formattedDueDate);
            $('#dueDateResult').html('Your expected due date for the next period is: ' + formattedDueDate);
        }
    </script>
</body>
</html>
