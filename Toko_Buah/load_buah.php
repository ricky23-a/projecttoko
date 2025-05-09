<?php
include '../admin/config.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM tb_buah WHERE nama_buah LIKE ?");
    $stmt->execute(['%' . $search . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM tb_buah");
}

$data = $stmt->fetchAll();

if (count($data) === 0) {
    echo '<p class="text-muted">Data buah tidak ditemukan.</p>';
} else {
    foreach ($data as $row):
        $gambar = !empty($row['gambar']) ? $row['gambar'] : 'default.png';
?>
    <div class="col">
        <div class="card bg-light text-dark border h-100">
            <div class="d-flex justify-content-center align-items-center" 
                 style="height: 200px; overflow: hidden;">
                <img src="images/<?= htmlspecialchars($gambar); ?>" 
                     class="img-fluid" 
                     style="max-height: 100%; max-width: 100%; object-fit: contain;" 
                     alt="<?= htmlspecialchars($row['nama_buah']); ?>">
            </div>
            <div class="card-body text-center">
                <h5 class="card-title"><?= htmlspecialchars(ucfirst($row['nama_buah'])); ?></h5>
                <p class="card-text">
                    Stok: <?= $row['stok']; ?><br>
                    Harga: Rp<?= number_format($row['harga_jual'], 0, ',', '.'); ?>
                </p>
                <a href="transaksi.php?id=<?= $row['id_buah'] ?>" class="btn btn-primary">Pesan Sekarang</a>
            </div>
        </div>
    </div>
<?php
    endforeach;
}
?>
