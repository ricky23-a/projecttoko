<?php
include_once('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_menu = $_POST['nama_buah'];
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
                $cek = "INSERT INTO tb_menu (nama_menu, stok, harga_beli, harga_jual, tanggal, gambar) 
                            VALUES (:nama, :stok, :harga_beli, :harga_jual, :tanggal, :gambar)";
                $hasil = $pdo->prepare($cek);
                $hasil->execute([
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
      <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" placeholder="Gambar Menu" required>
      <label for="gambar">Gambar Menu</label>
    </div>
  </div>

  <div class="text-end">
    <button type="submit" class="btn btn-primary">Simpan</button>
  </div>
</form>

