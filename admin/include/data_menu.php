<?php
try {
    $filterQuery = "SELECT * FROM tb_menu WHERE 1";
    $params = [];

    if (!empty($_GET['bulan'])) {
        $filterQuery .= " AND MONTH(tanggal) = :bulan";
        $params[':bulan'] = $_GET['bulan'];
    }
    if (!empty($_GET['tanggal'])) {
        $filterQuery .= " AND DAY(tanggal) = :tanggal_hari AND MONTH(tanggal) = :tanggal_bulan AND YEAR(tanggal) = :tanggal_tahun";
        $tanggalParts = explode('-', $_GET['tanggal']);
        $params[':tanggal_hari'] = $tanggalParts[2];
        $params[':tanggal_bulan'] = $tanggalParts[1];
        $params[':tanggal_tahun'] = $tanggalParts[0];
    }

    $stmt = $pdo->prepare($filterQuery);
    $stmt->execute($params);
    $listdata = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Gagal mengambil data: ' . $e->getMessage() . '</div>';
    $listdata = [];
}

$currentUrl = strtok($_SERVER["REQUEST_URI"], '?');
?>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Data Menu</h1>
    <p class="mb-4">Gunakan filter di bawah untuk melihat data menu berdasarkan bulan atau tanggal tertentu.</p>

    <form method="get" action="<?= $currentUrl ?>" class="row mb-3">
        <input type="hidden" name="page" value="data_menu">
        <div class="col-md-3">
            <label for="bulan" class="form-label">Filter Bulan</label>
            <select name="bulan" id="bulan" class="form-select">
                <option value="">Semua</option>
                <?php for ($i = 1; $i <= 12; $i++) { ?>
                    <option value="<?= $i ?>" <?= (isset($_GET['bulan']) && $_GET['bulan'] == $i) ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 10)) ?></option>
                <?php } ?>
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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Stok</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($listdata as $setdata) { ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= htmlspecialchars($setdata['nama_menu']); ?></td>
                            <td><?= $setdata['stok']; ?></td>
                            <td><?= 'Rp ' . number_format($setdata['harga_beli'], 0, ',', '.'); ?></td>
                            <td><?= 'Rp ' . number_format($setdata['harga_jual'], 0, ',', '.'); ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($setdata['tanggal'])); ?></td>
                            <td>
                                <a href="hapus_menu.php?id=<?= $setdata['id_menu'] ?>" class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                                <a href="?page=tambah_menu&id=<?= $setdata['id_menu'] ?>" class="btn btn-info btn-sm" title="Tambah">
                                    <i class="bi bi-plus-lg"></i>
                                </a>
                                <a href="?page=ubah_menu&id=<?= $setdata['id_menu'] ?>" class="btn btn-success btn-sm" title="Ubah">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>

                <div class="text-center mt-3">
                    <a href="cetak_laporan_menu.php" class="btn btn-secondary btn-sm shadow-sm">
                        <i class="fas fa-print fa-sm text-white-50"></i> Cetak Laporan
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
