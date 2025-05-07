<?php
include '../admin/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data buah berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM tb_buah WHERE id_buah = ?");
$stmt->execute([$id]);
$buah = $stmt->fetch();

if (!$buah) {
    echo "Buah tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jumlah = (int)$_POST['jumlah'];
    $alamat_pengirim = isset($_POST['alamat_pengirim']) ? trim($_POST['alamat_pengirim']) : '';
    $total = $jumlah * $buah['harga_jual'];
    $tanggal = date('Y-m-d');

    // Simpan transaksi (pastikan kolom alamat_pengirim sudah ada di tabel)
    $stmt = $pdo->prepare("INSERT INTO tb_transaksi (id_buah, jumlah, total, tanggal, alamat_pengirim) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$buah['id_buah'], $jumlah, $total, $tanggal, $alamat_pengirim]);

    echo "<script>alert('Transaksi berhasil!'); window.location.href='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Buah - Fruitin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 pt-5">
    <h2 class="mb-4">Transaksi Buah</h2>
    <div class="card">
        <div class="card-body">
            <!-- Gambar di atas nama buah -->
            <img src="images/<?= htmlspecialchars($buah['gambar']) ?>" 
                 class="img-fluid mb-3" 
                 style="max-height: 300px; object-fit: cover;" 
                 alt="<?= htmlspecialchars($buah['nama_buah']) ?>">

            <h5 class="card-title"><?= htmlspecialchars($buah['nama_buah']) ?></h5>
            <p class="card-text">Harga: Rp<?= number_format($buah['harga_jual'], 0, ',', '.'); ?> /buah</p>
            <form method="POST">
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Beli</label>
                    <input type="number" class="form-control" name="jumlah" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="alamat_pengirim" class="form-label">Alamat Pengirim</label>
                    <textarea class="form-control" name="alamat_pengirim" id="alamat_pengirim" rows="3" placeholder="Masukkan alamat pengirim" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Konfirmasi Pembelian</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
