<?php
include '../admin/config.php';
session_start();

// Ambil data pencarian (jika ada)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Jika ada pencarian, filter data berdasarkan nama menu
if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM tb_menu WHERE nama_menu LIKE ?");
    $stmt->execute(['%' . $search . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM tb_menu");
}

// Ambil semua data hasil query
$data = $stmt->fetchAll();

// Tampilkan pesan jika tidak ada data
if (count($data) === 0) {
    echo '<p class="text-muted">Data Menu tidak ditemukan.</p>';
} else {
    foreach ($data as $row):
        // Periksa apakah gambar tersedia, jika tidak gunakan gambar default
        $gambar = !empty($row['gambar']) ? $row['gambar'] : 'default.png';
?>
    <div class="col">
        <div class="card text-white border h-100">
            <div class="d-flex justify-content-center align-items-center" 
                 style="height: 200px; overflow: hidden;">
                <img src="images/<?= htmlspecialchars($gambar); ?>" 
                     class="img-fluid" 
                     style="max-height: 100%; max-width: 100%; object-fit: contain;" 
                     alt="<?= htmlspecialchars($row['nama_menu']); ?>">
            </div>
            <div class="card-body text-center">
                <h5 class="card-title"><?= htmlspecialchars(ucfirst($row['nama_menu'])); ?></h5>
                <p class="card-text">
                    Harga: Rp<?= number_format($row['harga_jual'], 0, ',', '.'); ?>
                </p>

                <!-- Kontrol jumlah -->
                <div class="input-group justify-content-center mb-2" style="width: 120px; margin: 0 auto;">
                    <button type="button" class="btn btn-sm btn-kurang" data-id="<?= $row['id_menu'] ?>">-</button>
                    <input type="text" class="form-control form-control-sm text-center jumlah-input" 
                           data-id="<?= $row['id_menu'] ?>" value="0" readonly style="width: 40px;">
                    <button type="button" class="btn btn-sm btn-tambah" 
                            data-id="<?= $row['id_menu'] ?>" data-stok="<?= $row['stok'] ?>">+</button>
                </div>

                <!-- Tombol PESAN LANGSUNG
                <form method="post" action="keranjang.php" class="d-inline">
                    <input type="hidden" name="id" value="<?= $row['id_menu'] ?>">
                    <input type="hidden" name="jumlah" value="0">
                    <button type="submit" name="pesan" class="btn">Pesan</button>
                </form> -->

                <!-- Tombol TAMBAH KE KERANJANG -->
                <form method="post" action="keranjang.php" class="d-inline">
                    <input type="hidden" name="id" value="<?= $row['id_menu'] ?>">
                    <input type="hidden" name="jumlah" class="jumlah-keranjang" value="0">
                    <input type="hidden" name="stok" value="<?= $row['stok'] ?>">
                    <button type="submit" name="keranjang" class="btn bi-cart btn-keranjang"></button>
                </form>
            </div>
        </div>
    </div>
<?php
    endforeach;
}
?>
