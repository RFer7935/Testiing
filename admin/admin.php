<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../admin/login.php");
    exit();
}
// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="icon" type="favicon" href="logo2.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            width: 250px;
            background-color: #343a40;
            color: white;
            padding-top: 1rem;
        }

        /* Sidebar link styling */
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            transition: all 0.3s ease;
        }

        /* Hover effect */
        .sidebar a:hover {
            background-color: #495057;
            border-radius: 5px;
        }

        /* Logout button styling */
        .sidebar a.logout {
            color: white;
            background-color: #dc3545;
            border-radius: 5px;
        }

        .sidebar a.logout:hover {
            background-color: #c82333;
        }

        /* Updated content styling for full-width */
        .content {
            flex: 1;
            margin-left: 250px;
            padding: 0;
            min-height: 100vh;
        }

        .navbar-brand img {
            height: 35px;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="text-center mb-4">
                <h4>Wisata Air Panas Wong Pulungan</h4>
            </div>
            <a href="edittentangkami.php">
                <i class="bi bi-pencil"></i> Edit Isi Tulisan Tentang Kami
            </a>
            <a href="edithargamasuk.php">
                <i class="bi bi-currency-dollar"></i> Edit Harga Masuk
            </a>
            <a href="keloladatafasilitas.php">
                <i class="bi bi-building"></i> Kelola Data Fasilitas
            </a>
            <a href="kelolafotoairpanaswongpulungan.php">
                <i class="bi bi-images"></i> Kelola Foto Air Panas Wong Pulungan
            </a>
            <a href="#" onclick="confirmLogout()">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </a>
        </div>
        <!-- Main Content -->
        <div class="content">
            <!-- Top Navbar -->

            <!-- Page Content -->
            <div class="container-fluid px-4">
                <div class="row">
                    <div class="col-12">
                        <h3 class="mt-4">Selamat Datang !</h3>
                        <p>Edit beberapa informasi yang tertera pada web Wisata Air Panas Wong Pulungan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmLogout() {
            if (confirm("Apakah Anda yakin ingin keluar?")) {
                window.location.href = 'login.php';
            }
        }
    </script>
</body>

</html>