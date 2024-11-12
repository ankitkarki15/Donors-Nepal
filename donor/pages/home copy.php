

<style>
.dashboard-section {
    background-color: #f8f9fa;
    padding: 30px; /* Increased padding for more height */
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px;
    text-align: center;
    min-height: 500px; /* Increased height */
}

.dashboard-section h2 {
    color: #000; /* Changed to black */
    font-size: 32px; /* Slightly increased font size */
    font-weight: 600;
    margin-bottom: 20px; /* Increased margin for spacing */
}

.profile-picture {
    width: 150px; /* Increased size */
    height: 150px; /* Increased size */
    border-radius: 50%;
    margin-bottom: 25px;
}

.donor-details {
    margin-top: 25px;
}

.donor-details p {
    font-size: 20px; /* Increased font size */
    margin-bottom: 12px;
    color: #000; /* Changed text to black */
}

.donor-details strong {
    color: #000; /* Changed to black */
    font-weight: 600;
}

.donor-details p:nth-child(2), .donor-details p:nth-child(3) {
    color: #000; /* Changed all details to black */
}

.statistics, .events, .last-donation, .notices {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 25px; /* Increased padding */
    margin: 20px 0; /* Increased margin for spacing */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    min-height: 150px; /* Set minimum height for larger size */
}

.statistics h3, .events h3, .last-donation h3, .notices h3 {
    color: #000; /* Changed to black */
    font-size: 24px; /* Increased font size */
    margin-bottom: 15px; /* Increased spacing */
}

.statistics p, .events p, .last-donation p, .notices p {
    font-size: 18px; /* Increased font size */
    color: #000; /* Changed text to black */
    margin: 10px 0; /* Increased margin */
}

@media (max-width: 768px) {
    .dashboard-section {
        padding: 20px;
        margin: 15px;
    }

    .dashboard-section h2 {
        font-size: 26px;
    }

    .donor-details p {
        font-size: 18px;
    }

    .statistics h3, .events h3, .last-donation h3, .notices h3 {
        font-size: 22px;
    }
}
.status-message {
    font-size: 1.2em; /* Slightly larger font size */
    padding: 10px 15px; /* Add some padding */
    border-radius: 5px; /* Rounded corners */
    margin-bottom: 20px; /* Space below the message */
}

.status-message.pending {
    background-color: #f0ad4e; /* Orange background for pending */
    color: white; /* White text */
    border: 1px solid #ec971f; /* Darker orange border */
}

.status-message.approved {
    background-color: #5cb85c; /* Green background for approved */
    color: white; /* White text */
    border: 1px solid #4cae4c; /* Darker green border */
}

.status-message.rejected {
    background-color: #d9534f; /* Red background for rejected */
    color: white; /* White text */
    border: 1px solid #c9302c; /* Darker red border */
}

</style>
<!-- Display Donor Status -->
   <!-- Display Donor Status -->
   <h4 class="status-message <?php echo $statusClass; ?>">
   <?php echo $statusMessage; ?>
</h4>
<div id="home" class="dashboard-section">

  
    <h2>Welcome, <?php echo htmlspecialchars($donor['name']); ?>!</h2>
    <div class="donor-details">
        <p><strong>Blood Group:</strong> <?php echo htmlspecialchars($donor['bg']); ?></p>
        <p><strong>Contact:</strong> <?php echo htmlspecialchars($donor['phone']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($donor['district'] . ', ' . $donor['locallevel']); ?></p>
    </div>
    
    <div class="events">
        <h3>Upcoming Events</h3>
        <p>Blood Donation Drive at Bir Hospital - September 20, 2024</p>
        <p>Community Blood donation,Pashupatinath - October 15, 2024</p>
    </div>
   
    <div class="notices">
        <h3>Important Notices</h3>
        <p>Reminder: Please update your profile address if it changes.</p>
        <!-- <p>New donation guidelines are in effect starting October 1, 2024.</p> -->
    </div>
</div>
