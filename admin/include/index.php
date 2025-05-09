<?php
session_start();
include("../config.php");
if (!isset($_SESSION['id_admin'])) {
    $tools->refresh("0", "index.php");
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Fruitin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
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
  <div class="d-flex">
    <!-- Sidebar -->
    <aside class="sidebar d-none d-md-block">
      <div class="p-4">
        <h2 class="fs-4 fw-bold mb-4">Fruitin</h2>
        <nav class="nav flex-column">
          <a href="?page=beranda">Beranda</a>
          <a href="?page=input_buah">Input Buah</a>
          <a href="?page=data_buah">Data Buah</a>
          <a href="#">Settings</a>
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
            case 'input_buah':
                include("input_buah.php");
                break;
            case 'data_buah':
                include("data_buah.php");
                break;
            case 'ubah_buah':
                include("ubah_buah.php");
                break;
        }
      ?>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>
<?php } ?>
