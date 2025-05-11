<?php
session_start();
include '../admin/config.php';

// Inisialisasi keranjang & total
$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
$total_harga = 0;

// Proses jika tombol "Tambah ke Keranjang" ditekan
if (isset($_POST['keranjang'])) {
    $id = $_POST['id'];
    $jumlah = isset($_POST['jumlah']) ? (int) $_POST['jumlah'] : 1;

    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    if (isset($_SESSION['keranjang'][$id])) {
        $_SESSION['keranjang'][$id] += $jumlah;
    } else {
        $_SESSION['keranjang'][$id] = $jumlah;
    }

    header("Location: keranjang.php");
    exit;
}

// Proses jika tombol "Pesan" ditekan
if (isset($_POST['pesan'])) {
    $id = $_POST['id'];
    $jumlah = isset($_POST['jumlah']) ? (int) $_POST['jumlah'] : 1;

    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    $_SESSION['keranjang'][$id] = $jumlah;

    header("Location: keranjang.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #1d1f21;
            color: white;
        }
        .img-product {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .table-dark th, .table-dark td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h2 class="mb-4">Keranjang Belanja</h2>

    <?php if (!empty($keranjang)): ?>
        <table class="table table-dark table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($keranjang as $id => $jumlah): 
                    $stmt = $pdo->prepare("SELECT * FROM tb_menu WHERE id_menu = ?");
                    $stmt->execute([$id]);
                    $data = $stmt->fetch();

                    if (!$data) continue;

                    $nama = $data['nama_menu'];
                    $harga = $data['harga_jual'];
                    $gambar = $data['gambar'];
                    $subtotal = $harga * $jumlah;
                    $total_harga += $subtotal;
                ?>
                    <tr>
                        <td>
                            <img src="images/<?= htmlspecialchars($gambar) ?>" alt="<?= htmlspecialchars($nama) ?>" class="img-product">
                        </td>
                        <td><?= htmlspecialchars(ucfirst($nama)) ?></td>
                        <td>Rp<?= number_format($harga, 0, ',', '.') ?></td>
                        <td>
                            <form method="post" action="keranjang_update.php" class="d-flex gap-2">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="submit" name="kurang" class="btn btn-sm btn-light text-dark">-</button>
                                <input type="text" name="jumlah" value="<?= $jumlah ?>" readonly class="form-control form-control-sm text-center" style="width: 50px;">
                                <button type="submit" name="tambah" class="btn btn-sm btn-light text-dark">+</button>
                            </form>
                        </td>
                        <td>Rp<?= number_format($subtotal, 0, ',', '.') ?></td>
                        <td>
                            <form method="post" action="keranjang_update.php">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="submit" name="hapus" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Total</strong></td>
                    <td colspan="2"><strong>Rp<?= number_format($total_harga, 0, ',', '.') ?></strong></td>
                </tr>
            </tfoot>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">Keranjang kosong.</div>
    <?php endif; ?>

    <div class="d-flex justify-content-end gap-2 mt-3">
        <?php if (!empty($keranjang)): ?>
        <form action="checkout.php" method="post" class="d-flex gap-2">
            <input type="text" name="nama_pelanggan" class="form-control" placeholder="Nama Pelanggan" required style="max-width: 250px;">
            <button type="submit" class="btn btn-success">Checkout</button>
        </form>
        <?php endif; ?>
        <form action="index.php" method="get">
            <button type="submit" class="btn btn-secondary">Kembali ke Home</button>
        </form>
    </div>
</div>

</body>
</html>
