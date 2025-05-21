<?php
include '../config.php';

// Hitung data
$jumlah_jenis = $pdo->query("SELECT COUNT(*) FROM tb_jenis_menu")->fetchColumn();
$jumlah_menu = $pdo->query("SELECT COUNT(*) FROM tb_menu")->fetchColumn();
$jumlah_transaksi = $pdo->query("SELECT COUNT(*) FROM tb_transaksi")->fetchColumn();

// Data untuk grafik (jumlah menu per jenis kopi)
$chart_data = $pdo->query("SELECT j.nama_jenis, COUNT(m.id_menu) as total_menu
                          FROM tb_menu m
                          JOIN tb_jenis_menu j ON m.id_jenis = j.id_jenis
                          GROUP BY j.nama_jenis")->fetchAll();

$labels = [];
$data = [];
foreach ($chart_data as $row) {
    $labels[] = $row['nama_jenis'];
    $data[] = $row['total_menu'];
}

// Transaksi terbaru
$transaksi_terbaru = $pdo->query("SELECT * FROM tb_transaksi ORDER BY tanggal DESC LIMIT 5")->fetchAll();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<div class="container-fluid py-4">
    <h2 class="mb-4">Dashboard</h2>

    <!-- Kartu Statistik -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <div class="rounded-circle p-3 text-white" style="background-color: #6f4e37;">
                            <i class="bi bi-cup-hot fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-1">Jumlah Jenis Menu</h6>
                        <h3 class="mb-0 fw-bold"><?= $jumlah_jenis ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <div class="bg-primary text-white rounded-circle p-3">
                            <i class="bi bi-cup-straw fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-1">Jumlah Menu</h6>
                        <h3 class="mb-0 fw-bold"><?= $jumlah_menu ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <div class="bg-warning text-white rounded-circle p-3">
                            <i class="bi bi-receipt-cutoff fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-1">Total Transaksi</h6>
                        <h3 class="mb-0 fw-bold"><?= $jumlah_transaksi ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Line Chart Smooth -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Statistik Menu per Jenis Kopi</h5>
            <canvas id="chartMenu"></canvas>
        </div>
    </div>

    <!-- Tabel Transaksi Terbaru -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Transaksi Terbaru</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($transaksi_terbaru as $t): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d-m-Y', strtotime($t['tanggal'])) ?></td>
                            <td><?= $t['id_transaksi'] ?></td>
                            <td>Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script Chart -->
<script>
    const ctx = document.getElementById('chartMenu');
    new Chart(ctx, {
        type: 'line', // ubah jadi line chart
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Jumlah Menu',
                data: <?= json_encode($data) ?>,
                fill: false,
                borderColor: 'rgba(111, 78, 55, 0.7)',
                backgroundColor: 'rgba(111, 78, 55, 0.7)',
                tension: 0.4, // garis smooth
                pointRadius: 5,
                pointBackgroundColor: 'rgba(111, 78, 55, 1)',
                pointBorderColor: '#fff',
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(111, 78, 55, 1)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: '#eee'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
