<?php include '../admin/config.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query data buah
if ($search != '') {
    $stmt = $pdo->prepare("SELECT * FROM tb_buah WHERE nama_buah LIKE ?");
    $stmt->execute(['%' . $search . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM tb_buah");
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
    <title>Fruitin</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top py-3">
       <div class="container">
        <a href="#" class="navbar-brand">
            <i class="bi bi-google-play"></i>
              Fruitin</a>
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
            </ul>
        </div>
        </div>
    </nav>
    <!-- header -->
    <section class="bg-light text-dark text-center text-sm-start pt-5 mt-5">
        <div class="container">
            <div class="d-flex align-items-center">

                <div>
                    <h1>Belanja<span class="text-primary"> Buah</span> Segar Lebih Mudah dan Cepat</h1>
                    <p class="lead">Pilih, beli, dan nikmati buah segar tanpa harus keluar rumah.</p>
                    <button class="btn btn-primary ">Pesan Sekarang</button>
                </div>
                <img class="img-fluid w-50 d-none d-sm-block" src="images/header.svg" alt="header">
            </div>
        </div>
    </section>
    <!-- services -->
    <section class="pt-5" id="services">
    <div class="container mt-5 text-center">
        <h2>Daftar Buah</h2>

        <!-- FORM PENCARIAN -->
        <form method="GET" class="mb-4 d-flex mx-auto" style="max-width: 400px;">
            <input type="text" name="search" id="search-input" class="form-control me-2" placeholder="Cari buah...">
        </form>

        <!-- Container untuk kartu buah -->
        <div id="buah-container" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
            <!-- Data akan dimuat otomatis lewat AJAX -->
        </div>
    </div>
</section>


     <!-- contact us -->
    <section class="p-5" id="contact">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md">
                    <h2 class="text-center mb-4">Contact Us</h2>
                    <ul class="list-group list-group-flush" lead>
                        <li class="list-group-item">
                            <i class="bi bi-geo-alt"></i>
                            <span class="fw-bold">Location:</span><br> Jalan Arif Rahman Hakim
                            </li>

                            <li class="list-group-item">
                                <i class="bi bi-telephone"></i>
                                <span class="fw-bold">Mobile Phone:</span><br> (+62) 822-9054-5680
                                </li>
                                <li class="list-group-item">
                                    <i class="bi bi-envelope"></i>
                                    <span class="fw-bold">Email:</span><br> sekolahvokasi@ung.ac.id
                                    </li>
                    </ul>
                </div>
                <div class="col-md">
                    <img class="img-fluid d-none d-lg-block" src="images/contact.svg" alt="contact">
                    
                </div>
            </div>

        </div>
    </section>

    <!-- footer -->
     <footer class="bg-dark text-light text-center p-5 position-relative">
        <div class="container">
            <p class="lead">Copyright &copy; 2025 Fruitin</p>
            <a href="#" class="position-absolute bottom-0 end-0 p-5">
                <i class="bi bi-arrow-up-circle h1"></i>          

            </a>
        </div>
     </footer>

<script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>