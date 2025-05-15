<?php
include_once('../config.php');

// Proses Tambah Menu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_menu = $_POST['nama_buah'];
    $id_jenis = $_POST['jenis_menu'];
    $stok = $_POST['stok'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $tanggal = date('Y-m-d H:i:s');

    $gambar_nama = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_ext = strtolower(pathinfo($gambar_nama, PATHINFO_EXTENSION));
    $mime_type = mime_content_type($gambar_tmp);

    $allowed_ext = ['jpg', 'jpeg', 'png'];
    $allowed_mime = ['image/jpeg', 'image/png'];

    if (!in_array($gambar_ext, $allowed_ext) || !in_array($mime_type, $allowed_mime)) {
        echo '<div class="alert alert-danger">File harus berupa gambar JPG atau PNG!</div>';
        exit;
    }

    $gambar_path = '../../Coffee/images/' . $gambar_nama;

    if ($harga_beli > $harga_jual) {
        echo '<div class="alert alert-danger">Harga beli tidak boleh lebih besar dari harga jual!</div>';
    } else {
        if (move_uploaded_file($gambar_tmp, $gambar_path)) {
            try {
                $cek = "INSERT INTO tb_menu (id_jenis, nama_menu, stok, harga_beli, harga_jual, tanggal, gambar) 
                        VALUES (:id_jenis, :nama, :stok, :harga_beli, :harga_jual, :tanggal, :gambar)";
                $hasil = $pdo->prepare($cek);
                $hasil->execute([
                    ':id_jenis' => $id_jenis,
                    ':nama' => $nama_menu,
                    ':stok' => $stok,
                    ':harga_beli' => $harga_beli,
                    ':harga_jual' => $harga_jual,
                    ':tanggal' => $tanggal,
                    ':gambar' => $gambar_nama
                ]);
                echo "<div class='alert alert-success'>Menu berhasil ditambahkan!</div><meta http-equiv='refresh' content='1; url=index.php?page=input_menu'/>";
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger">Terjadi kesalahan: ' . $e->getMessage() . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Gagal mengunggah gambar!</div>';
        }
    }
}
?>

<h2 class="mb-4">Input Menu Baru</h2>
<p>*Masukkan data yang benar</p>
<form method="POST" action="?page=input_menu" enctype="multipart/form-data">

  <!-- Dropdown Jenis Menu -->
  <div class="input-group mb-3">
    <label class="input-group-text" for="jenis_menu">Jenis Menu</label>
    <select class="form-select" name="jenis_menu" id="jenis_menu" required>
      <option value="">-- Pilih Jenis --</option>
      <?php
      $query = $pdo->query("SELECT * FROM tb_jenis_menu ORDER BY nama_jenis ASC");
      while ($row = $query->fetch()) {
          echo "<option value='{$row['id_jenis']}'>{$row['nama_jenis']}</option>";
      }
      ?>
    </select>
  </div>

  <div class="input-group mb-3">
    <div class="form-floating flex-grow-1">
      <input type="text" class="form-control" id="nama_buah" name="nama_buah" placeholder="Nama Menu" required>
      <label for="nama_buah">Nama Menu</label>
    </div>
  </div>

  <div class="input-group mb-3">
    <div class="form-floating flex-grow-1">
      <input type="number" class="form-control" id="stok" name="stok" placeholder="Stok" required>
      <label for="stok">Stok</label>
    </div>
  </div>

  <div class="input-group mb-3">
    <div class="form-floating flex-grow-1">
      <input type="number" class="form-control" id="harga_beli" name="harga_beli" placeholder="Harga Beli" required>
      <label for="harga_beli">Harga Beli</label>
    </div>
  </div>

  <div class="input-group mb-3">
    <div class="form-floating flex-grow-1">
      <input type="number" class="form-control" id="harga_jual" name="harga_jual" placeholder="Harga Jual" required>
      <label for="harga_jual">Harga Jual</label>
    </div>
  </div>

  <div class="input-group mb-3">
    <div class="form-floating flex-grow-1">
      <input type="file" class="form-control" id="gambar" name="gambar" accept=".jpg,.jpeg,.png" required>
      <label for="gambar">Gambar Menu</label>
    </div>
  </div>

  <div class="text-end">
    <button type="submit" class="btn btn-primary">Simpan</button>
  </div>
</form>
