<?php
include("../config.php");


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Hapus detail transaksi terlebih dahulu
        $stmtDetail = $pdo->prepare("DELETE FROM tb_detail_transaksi WHERE id_transaksi = ?");
        $stmtDetail->execute([$id]);

        // Hapus transaksi utama
        $stmtTransaksi = $pdo->prepare("DELETE FROM tb_transaksi WHERE id_transaksi = ?");
        $stmtTransaksi->execute([$id]);

        header("Location: index.php?page=data_transaksi&msg=deleted");
        exit;
    } catch (PDOException $e) {
        echo "Gagal menghapus transaksi: " . $e->getMessage();
    }
} else {
    echo "ID transaksi tidak ditemukan.";
}

?>
