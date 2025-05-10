<?php
session_start();
include '../admin/config.php';

// Cek apakah keranjang kosong
if (empty($_SESSION['keranjang'])) {
    echo '<script>alert("Keranjang masih kosong!"); window.location.href="keranjang.php";</script>';
    exit;
}

// Simulasi input nama pelanggan, bisa diganti sesuai sistem login atau form input
$nama_pelanggan = 'Pelanggan Umum'; // atau gunakan $_SESSION['user'] jika ada login

try {
    $pdo->beginTransaction();

    $total = 0;
    $keranjang = $_SESSION['keranjang'];

    // Hitung total
    foreach ($keranjang as $id_menu => $jumlah) {
        $stmt = $pdo->prepare("SELECT harga_jual FROM tb_menu WHERE id_menu = ?");
        $stmt->execute([$id_menu]);
        $menu = $stmt->fetch();

        if ($menu) {
            $total += $menu['harga_jual'] * $jumlah;
        }
    }

    // Simpan ke tb_transaksi
    $stmtTransaksi = $pdo->prepare("INSERT INTO tb_transaksi (nama_pelanggan, tanggal, total, status) VALUES (?, ?, ?, ?)");
    $stmtTransaksi->execute([$nama_pelanggan, date('Y-m-d'), $total, 'Belum Selesai']);

    // Ambil id_transaksi terakhir
    $id_transaksi = $pdo->lastInsertId();

    // Simpan ke tb_detail_transaksi
    $stmtDetail = $pdo->prepare("INSERT INTO tb_detail_transaksi (id_transaksi, id_menu, jumlah, subtotal) VALUES (?, ?, ?, ?)");

    foreach ($keranjang as $id_menu => $jumlah) {
        $stmt = $pdo->prepare("SELECT harga_jual FROM tb_menu WHERE id_menu = ?");
        $stmt->execute([$id_menu]);
        $menu = $stmt->fetch();

        if ($menu) {
            $subtotal = $menu['harga_jual'] * $jumlah;
            $stmtDetail->execute([$id_transaksi, $id_menu, $jumlah, $subtotal]);
        }
    }

    $pdo->commit();

    // Hapus keranjang
    unset($_SESSION['keranjang']);

    echo '<script>alert("Transaksi berhasil disimpan."); window.location.href="keranjang.php";</script>';
} catch (PDOException $e) {
    $pdo->rollBack();
    echo '<div class="alert alert-danger">Gagal menyimpan transaksi: ' . $e->getMessage() . '</div>';
}
?>
