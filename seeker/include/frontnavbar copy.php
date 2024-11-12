<!-- @import url('https://fonts.googleapis.com/css2?family=Satisfy&display=swap'); -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | DN</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Shadows+Into+Light&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap">
</head>
<body class="font-Poppins">
  <!-- Navigation Bar -->
  <nav class="bg-white shadow-md py-4 fixed w-full z-10">
    <div class="container mx-auto px-4 flex justify-between items-center">
      <a href="../seeker/front.php" class="text-2xl font-bold text-red-500">
        <span class="font-Satisfy text-blue-500">Donors</span> Nepal
      </a>
      <div class="flex items-center">
        <a href="../seeker/front.php" class="text-gray-700 hover:text-red-500 transition-colors mr-6">Home</a>
        <a href="../seeker/frontaboutus.php" class="text-gray-700 hover:text-red-500 transition-colors mr-6">About Us</a>
        <a href="../seeker/frontaboutus.php" class="text-gray-700 hover:text-red-500 transition-colors mr-6">Contact</a>
        <a href="../donor/donorlogin.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors">
          Login <i class="fas fa-arrow-circle-right ml-2"></i>
        </a>
      </div>
      <button class="block md:hidden text-gray-700 hover:text-red-500 transition-colors" id="navbar-toggle">
        <i class="fas fa-bars"></i>
      </button>
    </div>
    <div class="hidden md:hidden mt-4" id="navbar-menu">
      <div class="container mx-auto px-4 flex flex-col space-y-4">
        <a href="../seeker/front.php" class="text-gray-700 hover:text-red-500 transition-colors">Home</a>
        <a href="../seeker/frontaboutus.php" class="text-gray-700 hover:text-red-500 transition-colors">About Us</a>
        <a href="../seeker/frontaboutus.php" class="text-gray-700 hover:text-red-500 transition-colors">Contact</a>
        <a href="../donor/donorlogin.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors">
          Login <i class="fas fa-arrow-circle-right ml-2"></i>
        </a>
      </div>
    </div>
  </nav>

  <script>
    const navbarToggle = document.getElementById('navbar-toggle');
    const navbarMenu = document.getElementById('navbar-menu');

    navbarToggle.addEventListener('click', () => {
      navbarMenu.classList.toggle('hidden');
    });
  </script>
</body>
</html>