<?php
try {
    $filterQuery = "SELECT * FROM tb_transaksi WHERE 1";
    $params = [];

    if (!empty($_GET['bulan'])) {
        $filterQuery .= " AND MONTH(tanggal) = :bulan";
        $params[':bulan'] = $_GET['bulan'];
    }

    if (!empty($_GET['tanggal'])) {
        $filterQuery .= " AND DATE(tanggal) = :tanggal";
        $params[':tanggal'] = $_GET['tanggal'];
    }

    $stmt = $pdo->prepare($filterQuery);
    $stmt->execute($params);
    $transaksis = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Gagal mengambil data: ' . 
         htmlspecialchars($e->getMessage()) . '</div>';
    $transaksis = [];
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Transaksi</h1>

    <form method="get" action="" class="row mb-3">
    <input type="hidden" name="page" value="data_transaksi">
    <div class="col-md-3">
        <label for="bulan" class="form-label">Filter Bulan</label>
        <select name="bulan" id="bulan" class="form-select">
            <option value="">Semua</option>
            <?php for ($i = 1; $i <= 12; $i++) : ?>
                <option value="<?= $i ?>" <?= (isset($_GET['bulan']) && $_GET['bulan'] == $i) ? 'selected' : '' ?>>
                    <?= date('F', mktime(0, 0, 0, $i, 10)) ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="col-md-3">
        <label for="tanggal" class="form-label">Filter Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $_GET['tanggal'] ?? '' ?>">
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
    </div>
</form>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Produk Dibeli</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($transaksis as $transaksi) :
                        // Ambil detail transaksi langsung dari tb_detail_transaksi (tanpa JOIN tb_menu)
                        $stmtDetail = $pdo->prepare("SELECT nama_menu, jumlah FROM tb_detail_transaksi WHERE id_transaksi = ?");
                        $stmtDetail->execute([$transaksi['id_transaksi']]);
                        $details = $stmtDetail->fetchAll(PDO::FETCH_ASSOC);

                        // Gabungkan nama menu dan jumlah
                        $produkList = "";
                        foreach ($details as $item) {
                            $produkList .= htmlspecialchars($item['nama_menu']) . " (x" . $item['jumlah'] . ")<br>";
                        }

                        $statusButton = ($transaksi['status'] === 'Selesai')
                            ? '<span class="badge bg-success">Selesai</span>'
                            : '<a href="ubah_status.php?id=' . $transaksi['id_transaksi'] . '" class="btn btn-sm btn-warning">Belum Selesai</a>';
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= htmlspecialchars($transaksi['nama_pelanggan']) ?></td>
                            <td><?= $produkList ?></td>
                            <td>Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></td>
                            <td><?= date('d-m-Y', strtotime($transaksi['tanggal'])) ?></td>
                            <td class="text-center">
                                <?= $statusButton ?>
                                <a href="hapus_transaksi.php?id=<?= $transaksi['id_transaksi'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
