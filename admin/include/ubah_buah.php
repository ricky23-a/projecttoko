<?php
include "../config.php";

$id = $_GET['id'];
$getbuah = $pdo->query("SELECT * FROM tb_buah WHERE id_buah = '$id'");
$setbuah = $getbuah->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_buah = $_POST['nama_buah'];
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
                $update = "UPDATE tb_buah 
                            SET nama_buah = :nama, 
                                harga_beli = :harga_beli, 
                                harga_jual = :harga_jual, 
                                tanggal = :tanggal, 
                                gambar = :gambar 
                            WHERE id_buah = :id";
                $hasil = $pdo->prepare($update);
                $hasil->execute([
                    ':nama' => $nama_buah,
                    ':harga_beli' => $harga_beli,
                    ':harga_jual' => $harga_jual,
                    ':tanggal' => $tanggal,
                    ':gambar' => $gambar_nama,
                    ':id' => $id
                ]);
                echo "<div class='alert alert-success'>Buah berhasil diupdate!</div><meta http-equiv='refresh' content='1; url=index.php?page=data_buah' />";

            } catch (PDOException $e) {
                echo '<div class="alert alert-danger">Terjadi kesalahan: ' . $e->getMessage() . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Gagal mengunggah gambar!</div>';
        }
    }
}
?>

<h2 class="mb-4">Ubah Data Buah</h2>
<form method="POST" action="?page=ubah_buah&id=<?php echo $id; ?>" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="nama_buah" class="form-label">Nama Buah</label>
    <input type="text" class="form-control" value="<?php echo $setbuah['nama_buah']; ?>" id="nama_buah" name="nama_buah" required>
  </div>
  <div class="mb-3">
    <label for="stok" class="form-label">Stok (tidak bisa diubah)</label>
    <input type="number" disabled value="<?php echo $setbuah['stok']; ?>" class="form-control">
  </div>
  <div class="mb-3">
    <label for="harga_beli" class="form-label">Harga Beli</label>
    <input type="number" class="form-control" id="harga_beli" name="harga_beli" value="<?php echo $setbuah['harga_beli']; ?>" required>
  </div>
  <div class="mb-3">
    <label for="harga_jual" class="form-label">Harga Jual</label>
    <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="<?php echo $setbuah['harga_jual']; ?>" required>
  </div>
  <div class="mb-3">
    <label for="gambar" class="form-label">Gambar Buah</label>
    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
    <p class="mt-2"><img src="../../Toko_Buah/images/<?php echo $setbuah['gambar']; ?>" width="500"></p>
  </div>
  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>
