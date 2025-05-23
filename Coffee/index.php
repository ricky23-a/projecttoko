<?php include '../admin/config.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';


if ($search != '') {
    $stmt = $pdo->prepare("SELECT * FROM tb_menu WHERE nama_menu LIKE ?");
    $stmt->execute(['%' . $search . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM tb_menu");
}
$data = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Aroma Senja</title>
    <link rel="icon" type="image" href="images/3.svg" />
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-black navbar-dark fixed-top py-3">
       <div class="container">
        <a href="#" class="navbar-brand">
            <i class="bi bi-cup-hot"></i>
              Aroma <span class="text"> Senja</span></a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navmenu"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="#services" class="nav-link">Services</a></li>
               
                <li class="nav-item">
                    <a href="#contact" class="nav-link">Contact Us</a></li>

                <!-- <li class="nav-item">
  <a href="keranjang.php" class="nav-link position-relative">
    <i class="bi bi-cart"></i>
  </a> -->
</li>

            </ul>
        </div>
        </div>
    </nav>
    <!-- header -->
    <section class="header-section text-white text-center text-sm-start pt-5 mt-5">
        <div class="container">
            <div class="d-flex align-items-center">

                <div class="title col-md-6">
                    <h1>Membeli<span class="text"> Coffee</span> Disenja Hari Dapat Membuatmu menikmati kenikmatan <span class="text"> Coffee</span>.</h1>
                    <p class="lead">Pilih, beli, Coffee di Aroma Senja.</p>
                    <a href="#services" class="btn">Pesan Sekarang</a>
        </div>
    </section>
    <!-- services -->
    <section class="pt-5" id="services">
    <div class="container  text-center text-white">
        <h2>Daftar <span class="text"> Menu</span></h2>

        <!-- FORM PENCARIAN -->
        <form method="GET" class="mb-4 d-flex mx-auto" style="max-width: 400px;">
            <input type="text" name="search" id="search-input" class="form-control me-2" placeholder="Cari Coffee...">
        </form>

        <!-- Container untuk kartu buah -->
        
        <div id="buah-container" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
          
        </div>
    </div>
</section>


    <!-- contact us -->
<section class="py-5" id="contact" style="background: linear-gradient(to right, #010101, #010101); color: white;">
  <div class="container">
    <h2 class="text-center mb-5 fw-bold">Contact Us</h2>
    <div class="row g-4 align-items-start">
      
      <div class="col-md-6">
        <div class="card bg-dark border-0 shadow-lg text-light p-4 rounded-4">
          <div class="mb-3">
            <i class="bi bi-geo-alt fs-4 text-info me-2"></i>
            <span class="fw-semibold">Location:</span>
            <p class="ms-4 mb-0">Jalan Arif Rahman Hakim</p>
          </div>
          <div class="mb-3">
            <i class="bi bi-telephone fs-4 text-info me-2"></i>
            <span class="fw-semibold">Mobile Phone:</span>
            <p class="ms-4 mb-0">(+62) 822-9054-5680</p>
          </div>
          <div>
            <i class="bi bi-envelope fs-4 text-info me-2"></i>
            <span class="fw-semibold">Email:</span>
            <p class="ms-4 mb-0">sekolahvokasi@ung.ac.id</p>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63834.16255934319!2d122.99882077837013!3d0.549007787108402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32792b4799e5e75d%3A0x6dcc4d0923155967!2sGorontalo%2C%20Kabupaten%20Gorontalo%2C%20Gorontalo!5e0!3m2!1sid!2sid!4v1746942979357!5m2!1sid!2sid"
          width="100%" height="350" style="border:0; border-radius: 16px;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>

    </div>
  </div>
</section>



    <!-- footer -->
<footer class="text-white text-center py-5" style="background-color: #b8895c;">
  <div class="container">
    <!-- Social media icons -->
    <div class="mb-3">
      <a href="#" class="text-white mx-2"><i class="bi bi-instagram fs-5"></i></a>
      <a href="#" class="text-white mx-2"><i class="bi bi-twitter fs-5"></i></a>
      <a href="#" class="text-white mx-2"><i class="bi bi-facebook fs-5"></i></a>
    </div>

    <!-- Navigation links -->
    <ul class="nav justify-content-center mb-3">
      <li class="nav-item"><a href="#" class="nav-link px-3 text-white">Home</a></li>
      <li class="nav-item"><a href="#services" class="nav-link px-3 text-white">Menu</a></li>
      <li class="nav-item"><a href="#contact" class="nav-link px-3 text-white">Kontak</a></li>
    </ul>

    <!-- Footer credits -->
    <p class="mb-0">Created by <strong>Aroma Senja</strong> | &copy; 2025.</p>
  </div>
</footer>

<script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="keranjang.js"></script>
</body>
</html>