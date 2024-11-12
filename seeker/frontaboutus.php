<?php include 'include/frontnavbar.php'; ?>

<style>
    .size {
        padding: 80px 0px;
    }

    img {
        width: 300px;
        height: 300px;
    }

    h2 {
        color: #e74c3c;
    }

    p {
        font-size: 18px;
        color: black; /* Set default paragraph text color to black */
        text-align: justify; /* Justify paragraph content */
    }

    .red-text p {
        color: black; /* Set paragraph text color to red */
    }

    .right {
        float: right;
    }

    h1 {
        color: white;
    }

    .white-bg {
        background-color: white;
    }

    .grey-bg {
        background-color: #f2f2f2; /* Changed from white to grey background color */
    }


    .red-bg {
        background-color: #e74c3c;
    }

    .text-center {
        text-align: center;
    }

    .red-bar {
        border-top: 2px solid #e74c3c;
        width: 50px;
        margin: 20px auto;
    }
</style>

<div class="container-fluid red-bg size">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="text-center text-white">About Us</h1>
            <!-- <hr class="red-bar"> -->
        </div>
    </div>
</div>

<div class="container-fluid grey-bg size"> 
    <div class="container">
        <div class="row">
            <div class="col-md-6"><img src="assests/img/binoculars.png" alt="Our Vision" class="rounded float-left img-fluid"></div>
            <div class="col-md-6">
                <h2 class="text-center">Our Vision</h2>
                <div class="red-text">
					<p>Welcome to our platform! We're dedicated programmers focused on education and community service. Here's what you can do:</p>
					<ul>
						<li>Find a blood donor near you</li>
						<li>Request blood donations</li>
						<li>Share donation requests</li>
						<li>Become a donor and get a donor card</li>
						<li>Access blood and period calculators</li>
					</ul>
					<p>Join us in making a positive impact through technology and community support.</p>
				</div>

            </div>
        </div>
    </div>
</div>

<div class="container-fluid white-bg size"> <!-- Changed from white-bg to grey-bg -->
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-center">Our Mission</h2>
                <div class="red-text">
                    <p>
                        Our mission is to save lives through the power of blood donation. We are dedicated to ensuring a steady and reliable supply of blood for those in need. Through our platform, we aim to connect donors with recipients, making the donation process seamless and efficient.
                    </p>
                    <p>
                        By providing a user-friendly interface and comprehensive services, we strive to encourage more people to donate blood regularly. We believe that every donation counts and has the potential to make a life-saving difference. Our mission is to create a community of donors committed to supporting each other and improving health outcomes.
                    </p>
                </div>
            </div>
            <div class="col-md-6"><img src="assests/img/target.png" alt="Our Goal" class="rounded float-right img-fluid"></div>
        </div>
    </div>
</div>

<div class="container-fluid grey-bg size"> 
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-center">Our Goal</h2>
                <div class="red-text">
                    <p>
                        Our goal is to ensure that no one ever has to suffer due to a lack of blood supply. We are committed to increasing awareness about the importance of blood donation and overcoming barriers to donation.
                    </p>
                    <p>
                        Through strategic partnerships and innovative solutions, we aim to expand our reach and impact, reaching more donors and recipients across communities. Our goal is to build a sustainable blood donation system that meets the needs of patients while fostering a culture of giving and solidarity.
                    </p>
                </div>
            </div>
            <div class="col-md-6"><img src="assests/img/goal.png" alt="Our Goal" class="rounded float-right img-fluid"></div>
        </div>
    </div>
</div>

<?php include 'include/footer.php'; ?>
