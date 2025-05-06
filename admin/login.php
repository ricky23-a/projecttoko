<?php
session_start();
// include 'config.php'; // Koneksi ke database

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "db_fruitin";
$conn = new mysqli($servername, $username, $password, $dbname);
// Pastikan data dikirim dari index.html
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $query = "SELECT id_admin, username, password FROM tb_admin WHERE username = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id_admin, $username, $hashed_password);
            $stmt->fetch();

            // Jika password tidak di-hash, gunakan perbandingan biasa
            if ($password === $hashed_password) { 
                $_SESSION["loggedin"] = true;
                $_SESSION["id_admin"] = $id_admin;
                $_SESSION["username"] = $username;

                // Redirect ke halaman index.html
                header("Location: include/index.php");
                exit;
            } else {
                echo "Password salah.";
            }
        } else {
            echo "Username tidak ditemukan.";
        }
        $stmt->close();
    }
} else {
    echo "Data tidak lengkap!";
}

?>
