<?php
session_start();
include '../admin/config.php';

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Ambil stok dari database
    $stmt = $pdo->prepare("SELECT stok FROM tb_menu WHERE id_menu = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();

    if (!$data) {
        // Jika buah tidak ditemukan, kembali
        header("Location: keranjang.php");
        exit;
    }

    $stok = (int) $data['stok'];

    // Tambah jumlah
    if (isset($_POST['tambah'])) {
        if ($_SESSION['keranjang'][$id] < $stok) {
            $_SESSION['keranjang'][$id]++;
        }
    }

    // Kurangi jumlah
    if (isset($_POST['kurang'])) {
        if ($_SESSION['keranjang'][$id] > 1) {
            $_SESSION['keranjang'][$id]--;
        }
    }

    // Hapus item dari keranjang
    if (isset($_POST['hapus'])) {
        unset($_SESSION['keranjang'][$id]);
    }
}

header("Location: keranjang.php");
exit;
?>
