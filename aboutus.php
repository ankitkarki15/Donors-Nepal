<?php 
	include ('include/frontnavbar.php');
?>

<style>
	.size {
		padding: 40px 0;
	}
	.red-background {
		background-color: #e74c3c;
		color: white;
		text-align: center;
		padding: 20px 0;
	}
	h1 {
		margin: 0;
	}
	.text-section {
		padding: 30px 20px;
		margin-bottom: 20px;
		background-color: #f9f9f9;
		border-radius: 8px;
	}
	h2 {
		color: #e74c3c;
		text-align: center;
		margin-bottom: 15px;
	}
	p {
		font-size: 16px;
		color: #555;
		line-height: 1.5;
	}
	img {
		max-width: 100%;
		border-radius: 8px;
		margin-bottom: 20px;
	}
</style>

<div class="container-fluid red-background">
	<h1>About Us</h1>
</div>

<div class="container size">
	<div class="text-section">
		<img src="img/binoculars.png" alt="Our Vision" class="img-fluid">
		<h2>Our Vision</h2>
		<p>
			Our vision is to lead the way in educational technology, offering high-quality resources that are accessible to all. We aim to empower students worldwide with the knowledge and tools they need to succeed.
		</p>
	</div>

	<div class="text-section">
		<img src="img/target.png" alt="Our Goal" class="img-fluid">
		<h2>Our Goal</h2>
		<p>
			We aim to provide free, top-tier educational content and development services. Our goal is to help students thrive in the digital world by providing them with the skills they need to succeed.
		</p>
	</div>

	<div class="text-section">
		<img src="img/goal.png" alt="Our Mission" class="img-fluid">
		<h2>Our Mission</h2>
		<p>
			Our mission is to bridge the gap between education and technology, delivering high-quality content and services that meet the needs of students and professionals alike.
		</p>
	</div>
</div>

<?php 
	include ('include/footer.php');
?>
