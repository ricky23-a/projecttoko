<?php
include_once('../config.php');

// Tambah Jenis Menu
if (isset($_POST['tambah'])) {
    $nama_jenis = trim($_POST['nama_jenis']);
    if (!empty($nama_jenis)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO tb_jenis_menu (nama_jenis) VALUES (:nama)");
            $stmt->execute([':nama' => $nama_jenis]);
            echo "<div class='alert alert-success'>Jenis menu berhasil ditambahkan!</div>";
            echo "<meta http-equiv='refresh' content='1;url=?page=jenis_menu'>"; // <<< redirect otomatis
            exit;
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Terjadi kesalahan: {$e->getMessage()}</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Nama jenis menu tidak boleh kosong.</div>";
    }
}

// Hapus Jenis Menu
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    try {
        $stmt = $pdo->prepare("DELETE FROM tb_jenis_menu WHERE id_jenis = :id");
        $stmt->execute([':id' => $id]);
        echo "<div class='alert alert-success'>Jenis menu berhasil dihapus!</div>";
        echo "<meta http-equiv='refresh' content='1;url=?page=jenis_menu'>"; // <<< redirect otomatis
        exit;
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Gagal menghapus: {$e->getMessage()}</div>";
    }
}
?>

<h2 class="mb-4">Manajemen Jenis Menu</h2>

<!-- Form Tambah -->
<form method="POST" class="mb-4">
  <div class="input-group">
    <input type="text" class="form-control" name="nama_jenis" placeholder="Nama Jenis Menu" required>
    <button class="btn btn-primary" type="submit" name="tambah"><i class="bi bi-plus-circle"></i> Tambah</button>
  </div>
</form>

<!-- Tabel Jenis Menu -->
<table class="table table-bordered table-hover">
  <thead class="table-dark">
    <tr>
      <th>#</th>
      <th>Nama Jenis Menu</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $stmt = $pdo->query("SELECT * FROM tb_jenis_menu ORDER BY id_jenis ASC");
    while ($row = $stmt->fetch()) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_jenis']}</td>
                <td>
                  <a href='?page=jenis_menu&hapus={$row['id_jenis']}' onclick='return confirm(\"Hapus jenis menu ini?\")' class='btn btn-danger btn-sm'>
                    <i class='bi bi-trash'></i> Hapus
                  </a>
                </td>
              </tr>";
        $no++;
    }
    ?>
  </tbody>
</table>
