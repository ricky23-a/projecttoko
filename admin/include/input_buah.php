<?php
include_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_buah = $_POST['nama_buah'];
    $stok = $_POST['stok'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $tanggal = date('Y-m-d H:i:s');

    $gambar_nama = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $gambar_path = '../../Toko_Buah/images/' . $gambar_nama;

    if ($harga_beli > $harga_jual) {
        echo '<div class="alert alert-danger">Harga beli tidak boleh lebih besar dari harga jual!</div>';
    } else {
        if (move_uploaded_file($gambar_tmp, $gambar_path)) {
            try {
                $cek = "INSERT INTO tb_buah (nama_buah, stok, harga_beli, harga_jual, tanggal, gambar) 
                            VALUES (:nama, :stok, :harga_beli, :harga_jual, :tanggal, :gambar)";
                $hasil = $pdo->prepare($cek);
                $hasil->execute([
                    ':nama' => $nama_buah,
                    ':stok' => $stok,
                    ':harga_beli' => $harga_beli,
                    ':harga_jual' => $harga_jual,
                    ':tanggal' => $tanggal,
                    ':gambar' => $gambar_nama
                ]);
                echo "<div class='alert alert-success'>Buah berhasil ditambahkan!</div><meta http-equiv='refresh' content='1; url=index.php?page=input_buah'/>";
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger">Terjadi kesalahan: ' . $e->getMessage() . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Gagal mengunggah gambar!</div>';
        }
    }
}
?>

<h2 class="mb-4">Input Buah Baru</h2>
<form method="POST" action="?page=input_buah" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="nama_buah" class="form-label">Nama Buah</label>
    <input type="text" class="form-control" id="nama_buah" name="nama_buah" required>
  </div>
  <div class="mb-3">
    <label for="stok" class="form-label">Stok</label>
    <input type="number" class="form-control" id="stok" name="stok" required>
  </div>
  <div class="mb-3">
    <label for="harga_beli" class="form-label">Harga Beli</label>
    <input type="number" class="form-control" id="harga_beli" name="harga_beli" required>
  </div>
  <div class="mb-3">
    <label for="harga_jual" class="form-label">Harga Jual</label>
    <input type="number" class="form-control" id="harga_jual" name="harga_jual" required>
  </div>
  <div class="mb-3">
    <label for="gambar" class="form-label">Gambar Buah</label>
    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
</form>
