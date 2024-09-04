<?php
include 'admin/db_connect.php'; // Pastikan ini sesuai dengan konfigurasi Anda

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan email
    $stmt = $conn->prepare("SELECT password FROM clients WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        
        // Verifikasi password
        if (password_verify($password, $hashed_password)) {
            echo "Login successful";
            // Arahkan ke halaman yang sesuai
            header('Location: home.html');
        } else {
            echo "<script>alert('Password salah, coba lagi!');window.location.href='sigin.html';</script>";
        }
        } else {
            echo "<script>alert('Email atau username tidak ditemukan!');window.location.href='login.html';</script>";
        }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method";
}
?>
