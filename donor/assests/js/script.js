const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

$(document).ready(function() {
    // Fetch notification data when the dropdown is shown
    $('#notificationDropdown').on('click', function() {
        $.ajax({
            url: './pages/notification.php', // Path to the PHP file that fetches donor status
            type: 'GET',
            success: function(data) {
                $('#notificationContent').html(data); // Update the notification content
            },
            error: function() {
                $('#notificationContent').html('<span class="text-danger">Error loading notifications.</span>');
            }
        });
    });
});

