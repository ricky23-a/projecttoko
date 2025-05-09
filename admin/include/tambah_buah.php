<?php
include_once('../config.php');

// Ambil ID buah dari URL
$id = $_GET['id'] ?? null;

// Ambil data buah berdasarkan ID
if ($id) {
    $getbuah = $pdo->query("SELECT * FROM tb_buah WHERE id_buah = '$id'");
    $setbuah = $getbuah->fetch();
}

// Proses form jika disubmit
if (isset($_POST['btnSimpan'])) {
    $tambah_stok = $_POST['tambah_stok'];
    $tanggal = date('Y-m-d H:i:s');

    // Hitung stok baru
    $stok_baru = $setbuah['stok'] + $tambah_stok;

    // Update ke database
    $query = "UPDATE tb_buah SET stok = :stok, tanggal = :tanggal WHERE id_buah = :id";
    $stmt = $pdo->prepare($query);
    $success = $stmt->execute([
        ':stok' => $stok_baru,
        ':tanggal' => $tanggal,
        ':id' => $id
    ]);

    if ($success) {
        echo "<div class='alert alert-success'>Stok berhasil ditambahkan!</div>
              <meta http-equiv='refresh' content='1; url=index.php?page=data_buah'/>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menambahkan stok!</div>";
    }
}
?>

<h2 class="mb-4">Tambah Stok Buah</h2>
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Nama Buah</label>
        <input type="text" class="form-control" value="<?php echo $setbuah['nama_buah']; ?>" disabled>
    </div>
    <div class="mb-3">
        <label class="form-label">Stok Sekarang</label>
        <input type="number" class="form-control" value="<?php echo $setbuah['stok']; ?>" disabled>
    </div>
    <div class="mb-3">
        <label class="form-label">Harga Beli</label>
        <input type="text" class="form-control" value="Rp. <?php echo number_format($setbuah['harga_beli']); ?>" disabled>
    </div>
    <div class="mb-3">
        <label class="form-label">Harga Jual</label>
        <input type="text" class="form-control" value="Rp. <?php echo number_format($setbuah['harga_jual']); ?>" disabled>
    </div>
    <div class="mb-3">
        <label class="form-label">Tambah Stok</label>
        <input type="number" name="tambah_stok" class="form-control" placeholder="Masukkan jumlah stok baru" required>
    </div>
    <button type="submit" name="btnSimpan" class="btn btn-primary">Simpan</button>
    <a href="index.php?page=data_buah" class="btn btn-secondary">Kembali</a>
</form>
