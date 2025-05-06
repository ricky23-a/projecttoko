<?php
try {
    $stmt = $pdo->query("SELECT COUNT(*) as jumlah FROM tb_buah");
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $jumlah_jenis = $data['jumlah'];
} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Gagal mengambil data: ' . $e->getMessage() . '</div>';
    $jumlah_jenis = 0;
}
?>

<div class="container-fluid">
    <h2 class="mb-4">Dashboard</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4 d-flex">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Jenis Buah</h5>
                    <p class="card-text display-6 fw-bold">500</p>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4 d-flex">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Jenis Barang</h5>
                    <p class="card-text display-6 fw-bold">500</p>
                </div>
            </div>
        </div>
        <!-- Tambahan kartu lain bisa diletakkan di sini -->
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Selamat Datang di Sistem Informasi Fruitin</h5>
            <p class="card-text">Gunakan sidebar untuk mengakses fitur seperti input barang dan transaksi.</p>
        </div>
    </div>
</div>
