<?php
session_start();
include("../config.php");
if (!isset($_SESSION['id_admin'])) {
    $tools->refresh("0", "index.php");
} else {

$get = $pdo->query("SELECT * FROM tb_admin where id_admin='".$_SESSION['id_admin']."'");
$set = $get->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
  <link rel="icon" type="image" href="../img/3.svg" />
  <style>
    body {
        background-color: #f8f9fa;
    }
    .sidebar {
        min-width: 250px;
        max-width: 250px;
        background-color: #343a40;
        color: #fff;
        min-height: 100vh;
        position: sticky;
        top: 0;
        overflow-y: auto;
    }
    .sidebar a {
        color: #adb5bd;
        text-decoration: none;
        display: block;
        padding: 10px 20px;
    }
    .sidebar a:hover {
        background-color: #495057;
        color: #fff;
    }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container-fluid">
    <a class="px-3 navbar-brand fw-bold" href="#"><i class="bi bi-cup-hot-fill"></i> Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarAdmin">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link fs-5 fw-bold" href="?page=beranda">Admin <?php echo $set['nama'] ?></a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="d-flex">
  <!-- Sidebar -->
  <aside class="sidebar d-none d-md-block">
    <div class="p-4">
      <nav class="nav flex-column">
        <a href="?page=beranda"><i class="bi bi-house-fill"></i> Beranda</a>
        <a href="?page=jenis_menu"><i class="bi bi-tags-fill"></i> Jenis Menu</a>
        <a href="?page=input_menu"><i class="bi bi-file-earmark-plus-fill"></i> Input Menu</a>
        <a href="?page=data_menu"><i class="bi bi-bar-chart-steps"></i> Data Menu</a>
        <a href="?page=data_transaksi"><i class="bi bi-activity"></i> Data Transaksi</a>
        <a class="text-danger" href="?page=logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
      </nav>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-fill p-4 bg-white">
    <?php
      $page = $_GET['page'] ?? 'beranda';
      switch ($page) {
          case 'beranda':
              include("beranda.php");
              break;
          case 'input_menu':
              include("input_menu.php");
              break;
          case 'data_menu':
              include("data_menu.php");
              break;
          case 'ubah_menu':
              include("ubah_menu.php");
              break;
          case 'tambah_menu':
              include("tambah_menu.php");
              break;
          case 'logout':
              include("logout.php");
              break;
          case 'data_transaksi':
              include("data_transaksi.php");
              break;
          case 'jenis_menu':                     
              include("jenis_menu.php");        
              break;
      }
    ?>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>

<?php } ?>
