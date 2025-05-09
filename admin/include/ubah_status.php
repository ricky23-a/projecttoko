<?php
echo "File dijalankan!<br>";
include("../config.php"); // naik satu folder dari include/ ke admin/

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("UPDATE tb_transaksi SET status = 'Selesai' WHERE id_transaksi = ?");
        $stmt->execute([$id]);

        // kembali ke halaman data_transaksi di folder yang sama
        header("Location: index.php?page=data_transaksi&msg=status_updated");
        exit;
    } catch (PDOException $e) {
        echo "Gagal mengubah status: " . $e->getMessage();
    }
} else {
    echo "ID transaksi tidak ditemukan.";
}
?>
