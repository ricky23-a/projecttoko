<?php
session_start();
include '../admin/config.php';

// Cek apakah keranjang kosong
if (empty($_SESSION['keranjang'])) {
    echo '<script>alert("Keranjang masih kosong!"); window.location.href="keranjang.php";</script>';
    exit;
}

// Ambil nama pelanggan dari form
$nama_pelanggan = isset($_POST['nama_pelanggan']) ? trim($_POST['nama_pelanggan']) : 'Pelanggan Umum';

if (empty($nama_pelanggan)) {
    echo '<script>alert("Nama pelanggan wajib diisi."); window.location.href="keranjang.php";</script>';
    exit;
}

try {
    $pdo->beginTransaction();

    $total = 0;
    $keranjang = $_SESSION['keranjang'];

    // Hitung total dan cek stok
    foreach ($keranjang as $id_menu => $jumlah) {
        $stmt = $pdo->prepare("SELECT harga_jual, stok FROM tb_menu WHERE id_menu = ?");
        $stmt->execute([$id_menu]);
        $menu = $stmt->fetch();

        if ($menu) {
            if ($menu['stok'] < $jumlah) {
                throw new Exception("Stok tidak mencukupi untuk menu ID $id_menu.");
            }
            $total += $menu['harga_jual'] * $jumlah;
        } else {
            throw new Exception("Menu dengan ID $id_menu tidak ditemukan.");
        }
    }

    // Simpan ke tb_transaksi
    $stmtTransaksi = $pdo->prepare("INSERT INTO tb_transaksi (nama_pelanggan, tanggal, total, status) VALUES (?, ?, ?, ?)");
    $stmtTransaksi->execute([$nama_pelanggan, date('Y-m-d'), $total, 'Belum Selesai']);

    // Ambil id_transaksi terakhir
    $id_transaksi = $pdo->lastInsertId();

    // Simpan ke tb_detail_transaksi dan update stok
    $stmtDetail = $pdo->prepare("INSERT INTO tb_detail_transaksi (id_transaksi, id_menu, jumlah, subtotal) VALUES (?, ?, ?, ?)");
    $stmtUpdateStok = $pdo->prepare("UPDATE tb_menu SET stok = stok - ? WHERE id_menu = ?");

    foreach ($keranjang as $id_menu => $jumlah) {
        $stmt = $pdo->prepare("SELECT harga_jual FROM tb_menu WHERE id_menu = ?");
        $stmt->execute([$id_menu]);
        $menu = $stmt->fetch();

        if ($menu) {
            $subtotal = $menu['harga_jual'] * $jumlah;
            $stmtDetail->execute([$id_transaksi, $id_menu, $jumlah, $subtotal]);

            // Kurangi stok
            $stmtUpdateStok->execute([$jumlah, $id_menu]);
        }
    }

    $pdo->commit();

    // Hapus keranjang
    unset($_SESSION['keranjang']);

    echo '<script>alert("Transaksi berhasil disimpan."); window.location.href="keranjang.php";</script>';
} catch (Exception $e) {
    $pdo->rollBack();
    echo '<div class="alert alert-danger">Gagal menyimpan transaksi: ' . $e->getMessage() . '</div>';
}
?>
