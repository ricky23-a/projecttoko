<?php
include "../config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM tb_menu WHERE id_menu = :id");
        $stmt->execute([':id' => $id]);

        echo "Data berhasil dihapus. <meta http-equiv='refresh' content='1; url=index.php?page=data_menu'/>";
    } catch (PDOException $e) {
        echo "Gagal menghapus data: " . $e->getMessage();
    }
} else {
    echo "ID buah tidak diberikan.";
}
?>
