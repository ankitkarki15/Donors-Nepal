<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome | DonorsNepal</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700&display=swap">
<style>
     @import url('https://fonts.googleapis.com/css2?family=Satisfy&display=swap');
</style>
</head>
<body>
  <?php 
//   include 'include/frontnavbar.php'; ?>
  <!-- Navigation Bar -->
  <header class="navbar navbar-expand-lg navbar-white bg-white fixed-top">
  <div class="container mx-auto px-6 py-2 flex justify-between items-center">
    <!-- Logo -->
    <a class="text-xl hover:no-underline" href="front.php">
      <span style="color: #cc0000;"><b>DONORS</b></span>
      <span class="satisfy-regular text-gray-700">Nepal</span>
    </a>

    <!-- Menu Items -->
    <nav class="hidden md:flex space-x-6">
      <a href="#" class="text-gray-700 hover:text-red-700 font-semibold hover:no-underline">Home</a>
      <a href="#whydonate" class="text-gray-700 hover:text-red-700 font-semibold hover:no-underline">Why donate?</a>
      <!-- <a href="../donor/donorlogin.php" class="text-gray-700 hover:text-red-700 font-semibold hover:no-underline">Donate</a>
      <a href="../seeker/login.php" class="text-gray-700 hover:text-red-700 font-semibold hover:no-underline">Find Blood</a> -->
      <a href="#contact" class="text-gray-700 hover:text-red-700 font-semibold hover:no-underline">Contact Us</a>
    </nav>

    <!-- Login Button -->
    <a href="../donor/donorregister.php" class="hidden md:inline-block bg-red-700 text-white px-4 py-2 rounded-full font-semibold hover:bg-red-800 transition duration-300 hover:no-underline">
      Register as Donor
    </a>

    <!-- Hamburger Menu (for mobile) -->
    <button id="menu-toggle" class="text-red-700 md:hidden focus:outline-none">
      <i class="lni lni-menu text-2xl"></i>
    </button>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="hidden md:hidden bg-white px-6 py-4">
    <nav class="flex flex-col space-y-4">
      <a href="#" class="text-gray-700 hover:text-red-700 font-semibold hover:no-underline">Home</a>
      <a href="#" class="text-gray-700 hover:text-red-700 font-semibold hover:no-underline">About Us</a>
      <!-- <a href="../donor/donorlogin.php" class="text-gray-700 hover:text-red-700 font-semibold hover:no-underline">Donate</a>
      <a href="../seeker/login.php" class="text-gray-700 hover:text-red-700 font-semibold hover:no-underline">Find Blood</a> -->
      <a href="#contact" class="text-gray-700 hover:text-red-700 font-semibold hover:no-underline">Contact Us</a>
      <a href="../donor/donorregister.php" class="bg-red-700 text-white px-4 py-2 rounded-full font-semibold hover:bg-red-800 transition duration-300">
        Login
      </a>
    </nav>
  </div>
</header>


<script>
  // Toggle mobile menu visibility
  document.getElementById('menu-toggle').onclick = function () {
    document.getElementById('mobile-menu').classList.toggle('hidden');
  };
</script>


<!-- Hero Section -->
<div class="pt">
  <div class="relative bg-gradient-to-r from-red-600 to-red-800 overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
      <div class="absolute w-80 h-80 bg-red-500 rounded-full opacity-10 -top-20 -left-20"></div>
      <div class="absolute w-80 h-80 bg-red-400 rounded-full opacity-10 -bottom-20 -right-20"></div>
    </div>
    
    <div class="container mx-auto px-6 py-16 md:py-24 relative">
      <div class="grid md:grid-cols-2 gap-8 items-center">
        <div class="text-white space-y-6">
          <h1 class="text-3xl md:text-4xl font-bold leading-tight uppercase">
            Every Drop of Blood <br>
            <span class="text-red-200 uppercase">Can Save a Life</span>
          </h1>
          <p class="text-lg md:text-xl text-red-100 leading-relaxed">
            Join our community of heroes. Register as a donor or find blood donors near you. 
            Together, we can make a difference in Nepal.
          </p>
          <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
            <a href="../donor/donorlogin.php"><button class="bg-white text-red-600 px-8 py-3 rounded-full font-semibold hover:bg-red-100 transition duration-300 transform hover:scale-105 shadow-lg">
              Donate Blood
            </button></a>
            <a href="../seeker/login.php"><button class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-red-700 transition duration-300 transform hover:scale-105">
              Need Blood
            </button></a>
          </div>
          <div class="flex items-center space-x-8 mt-8 md:mt-12">
            <div class="text-center">
              <div class="text-2xl md:text-3xl font-bold">100+</div>
              <div class="text-red-200">Active Donors</div>
            </div>
            <div class="text-center">
              <div class="text-2xl md:text-3xl font-bold">24/7</div>
              <div class="text-red-200">Support</div>
            </div>
            <div class="text-center">
              <div class="text-2xl md:text-3xl font-bold">50+</div>
              <div class="text-red-200">Lives Saved</div>
            </div>
          </div>
        </div>
        <img src="assests/img/bg3.jpg" alt="Blood Donation" class="w-82 h-82 rounded-lg  transform -rotate-2 hover:rotate-0 transition duration-500 hidden md:block">
      </div>
    </div>
  </div>
</div>

<!-- Features Section -->
<div id="whydonate" class="features py-16 md:py-20 bg-gray-100">
  <div class="container mx-auto px-4">
    <h2 class="text-2xl md:text-3xl font-bold mb-6 md:mb-10 text-center">Why Donate?</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <div class="card bg-white shadow-lg p-6 md:p-8 text-center">
        <i class="fas fa-heartbeat text-red-500 text-4xl mb-4"></i>
        <h3 class="text-xl md:text-2xl font-bold mb-2">Save Lives</h3>
        <p class="text-gray-600">Donating blood can save the lives of patients in need.</p>
      </div>
      <div class="card bg-white shadow-lg p-6 md:p-8 text-center">
        <i class="fas fa-map-marker-alt text-red-500 text-4xl mb-4"></i>
        <h3 class="text-xl md:text-2xl font-bold mb-2">Find Donation Centers</h3>
        <p class="text-gray-600">Easily locate the nearest blood donation centers and campaigns.</p>
      </div>
      <div class="card bg-white shadow-lg p-6 md:p-8 text-center">
        <i class="fas fa-calendar-alt text-red-500 text-4xl mb-4"></i>
        <h3 class="text-xl md:text-2xl font-bold mb-2">Donation Guidelines</h3>
        <p class="text-gray-600">Donors must wait at least 3 months between donations.</p>
      </div>
    </div>
  </div>
</div>

<!-- Testimonial Section -->
<div class="testimonial bg-white py-16 md:py-20">
  <div class="container mx-auto px-4">
    <h2 class="text-2xl md:text-3xl font-bold mb-6 md:mb-10 text-center">What Our Donors Say</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div class="card bg-gray-100 shadow-lg p-6 md:p-8 text-center">
        <p class="text-gray-600 mb-4">"Donating blood is one of the most rewarding experiences. It's a simple way to make a big difference in someone's life."</p>
        <div class="flex items-center justify-center">
        <img src="assests\img\image.png" alt="Donor 1" class="w-10 h-10 md:w-12 md:h-12 rounded-full mr-4">
          <div class="text-left">
            <h4 class="text-lg font-bold">John Doe</h4>
            <p class="text-gray-600">Proud Donor</p>
          </div>
        </div>
      </div>
      <div class="card bg-gray-100 shadow-lg p-6 md:p-8 text-center">
        <p class="text-gray-600 mb-4">"Donating blood is one of the most rewarding experiences. It's a simple way to make a big difference in someone's life."</p>
        <div class="flex items-center justify-center">
        <img src="assests\img\image1.png" alt="Donor 1" class="w-10 h-10 md:w-12 md:h-12 rounded-full mr-4">
          <div class="text-left">
            <h4 class="text-lg font-bold">John Doe</h4>
            <p class="text-gray-600">Proud Donor</p>
          </div>
        </div>
      </div>
      <div class="card bg-gray-100 shadow-lg p-6 md:p-8 text-center">
        <p class="text-gray-600 mb-4">"Donating blood is one of the most rewarding experiences. It's a simple way to make a big difference in someone's life."</p>
        <div class="flex items-center justify-center">
          <img src="assests\img\image1.png" alt="Donor 1" class="w-10 h-10 md:w-12 md:h-12 rounded-full mr-4">
          <div class="text-left">
            <h4 class="text-lg font-bold">John Doe</h4>
            <p class="text-gray-600">Proud Donor</p>
          </div>
        </div>
      </div>
      <!-- Repeat testimonials for other donors here -->
    </div>
  </div>
</div>

<!-- Contact Section -->
<div id="contact" class="contact bg-gray-100 py-16 md:py-20">
  <div class="container mx-auto px-4">
    <h2 class="text-2xl md:text-3xl font-bold mb-6 md:mb-10 text-center">Get in Touch</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
      <div>
        <h3 class="text-xl md:text-2xl font-bold mb-4">Contact Us</h3>
        <p class="mb-4"><i class="fas fa-phone mr-2"></i> +977-9841989019</p>
        <p class="mb-4"><i class="fas fa-envelope mr-2"></i> info@donorsnepal.org</p>
        <p class="mb-4"><i class="fas fa-map-marker-alt mr-2"></i> Kathmandu, Nepal</p>
      </div>
      <div>
        <h3 class="text-xl md:text-2xl font-bold mb-4">Follow Us</h3>
        <div class="flex items-center">
          <a href="#" class="text-blue-500 mr-4"><i class="fab fa-facebook fa-2x"></i></a>
          <a href="#" class="text-pink-500 mr-4"><i class="fab fa-instagram fa-2x"></i></a>
          <a href="#" class="text-blue-400 mr-4"><i class="fab fa-twitter fa-2x"></i></a>
          <a href="#" class="text-red-500"><i class="fab fa-youtube fa-2x"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'include/footer.php'; ?>

</body>
</html>
