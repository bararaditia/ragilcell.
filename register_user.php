<?php
include 'admin/db_connect.php'; // Pastikan ini sesuai dengan konfigurasi Anda

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Meng-hash password

    // Tetapkan role secara otomatis sebagai 'User'
    $role = 'User';

    // Query untuk menambahkan user baru
    $stmt = $conn->prepare("INSERT INTO clients (username, email, phone_number, address, role, password, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");

    // Tambahkan pengecekan jika prepare() gagal
    if ($stmt === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("ssssss", $username, $email, $phone_number, $address, $role, $password);

    // Eksekusi statement
    if ($stmt->execute()) {
        echo "Registration successful";
        header('Location: home.html'); // Redirect ke halaman sukses setelah registrasi berhasil
        exit(); // Penting untuk menghentikan eksekusi setelah header redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method";
}
?>
