<?php
session_start();
include '../admin/config.php';

// Periksa apakah keranjang kosong
if (empty($_SESSION['keranjang'])) {
    echo '<script>alert("Keranjang masih kosong!"); window.location.href="keranjang.php";</script>';
    exit;
}

// Ambil dan validasi nama pelanggan
$nama_pelanggan = isset($_POST['nama_pelanggan']) ? trim($_POST['nama_pelanggan']) : 'Pelanggan Umum';
if (empty($nama_pelanggan)) {
    echo '<script>alert("Nama pelanggan wajib diisi."); window.location.href="keranjang.php";</script>';
    exit;
}

try {
    $pdo->beginTransaction();

    $total = 0;
    $keranjang = $_SESSION['keranjang'];

    // Cek stok dan hitung total
    foreach ($keranjang as $id_menu => $jumlah) {
        $stmt = $pdo->prepare("SELECT nama_menu, harga_jual, stok FROM tb_menu WHERE id_menu = ?");
        $stmt->execute([$id_menu]);
        $menu = $stmt->fetch();

        if (!$menu) {
            throw new Exception("Menu dengan ID $id_menu tidak ditemukan.");
        }

        if ($menu['stok'] < $jumlah) {
            throw new Exception("Stok tidak mencukupi untuk menu: {$menu['nama_menu']}.");
        }

        $total += $menu['harga_jual'] * $jumlah;
    }

    // Simpan ke tb_transaksi
    $stmtTransaksi = $pdo->prepare("
        INSERT INTO tb_transaksi (nama_pelanggan, tanggal, total, status)
        VALUES (?, ?, ?, ?)
    ");
    $stmtTransaksi->execute([
        $nama_pelanggan,
        date('Y-m-d'),
        $total,
        'Belum Selesai'
    ]);

    $id_transaksi = $pdo->lastInsertId();

    // Siapkan statement untuk detail dan update stok
    $stmtDetail = $pdo->prepare("
        INSERT INTO tb_detail_transaksi 
        (id_transaksi, nama_menu, harga_jual, jumlah, subtotal)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmtUpdateStok = $pdo->prepare("
        UPDATE tb_menu SET stok = stok - ? WHERE id_menu = ?
    ");

    // Simpan detail dan kurangi stok
    foreach ($keranjang as $id_menu => $jumlah) {
        $stmt = $pdo->prepare("SELECT nama_menu, harga_jual FROM tb_menu WHERE id_menu = ?");
        $stmt->execute([$id_menu]);
        $menu = $stmt->fetch();

        if ($menu) {
            $subtotal = $menu['harga_jual'] * $jumlah;

            $stmtDetail->execute([
                $id_transaksi,
                $menu['nama_menu'],
                $menu['harga_jual'],
                $jumlah,
                $subtotal
            ]);

            $stmtUpdateStok->execute([$jumlah, $id_menu]);
        }
    }

    $pdo->commit();
    unset($_SESSION['keranjang']);

    echo '<script>alert("Transaksi berhasil disimpan."); window.location.href="keranjang.php";</script>';

} catch (Exception $e) {
    $pdo->rollBack();
    echo '<div class="alert alert-danger">Gagal menyimpan transaksi: ' . htmlspecialchars($e->getMessage()) . '</div>';
}
?>
