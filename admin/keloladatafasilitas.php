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

include 'db.php';

if (isset($_GET['delete_facility_id'])) {
    $id = $_GET['delete_facility_id'];

    // Ambil nama file gambar dari database sebelum menghapus data
    $sql = "SELECT image FROM facility_section WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        // Ambil data gambar
        $row = mysqli_fetch_assoc($result);
        $imagePath = 'uploads/' . $row['image']; // Path gambar

        // Hapus gambar dari folder uploads
        if (file_exists($imagePath)) {
            unlink($imagePath); // Menghapus gambar dari folder
        }

        // Setelah gambar dihapus, hapus data fasilitas dari database
        $sql = "DELETE FROM facility_section WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Data dan gambar berhasil dihapus!'); window.location.href = 'keloladatafasilitas.php';</script>";
            exit();
        } else {
            echo "<script>alert('Gagal menghapus data'); window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('Fasilitas tidak ditemukan'); window.history.back();</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="icon" type="favicon" href="logo2.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <i class=""></i> Tentang Kami
            </a>
            <a href="edithargamasuk.php">
                <i class=""></i> Harga Masuk
            </a>
            <a href="keloladatafasilitas.php">
                <i class=""></i> Kelola Data Fasilitas
            </a>
            <a href="kelolafotoairpanaswongpulungan.php">
                <i class=""></i> Kelola Galeri
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

                        <!-- Manage Facility Section -->
                        <div id="facility-section" class="card mb-4">
                            <div class="card-header bg-success text-white">
                                Kelola Data Fasilitas
                            </div>
                            <div class="card-body">
                                <a href="tambahfasilitas.php" class="btn btn-primary mb-3">Tambah Fasilitas</a>

                                <!-- Display Facilities -->
                                <table class="table table-hover mt-4">
                                    <thead>
                                        <tr>
                                            <th scope="col">Judul</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col">Gambar</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM facility_section";
                                        $result = mysqli_query($conn, $sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                                                echo "<td><img src='uploads/" . htmlspecialchars($row['image']) . "' width='100'></td>";
                                                echo "<td>
                        <a href='perbaruifasilitas.php?edit_facility_id=" . $row['id'] . "' class='btn btn-outline-secondary btn-sm'><i class='bi bi-pencil'></i></a>
                        <a href='keloladatafasilitas.php?delete_facility_id=" . $row['id'] . "' class='btn btn-outline-danger btn-sm' onclick='return confirmDelete()'><i class='bi bi-trash'></i></a>
                      </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>Tidak ada Fasilitas</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End of Manage Facility Section -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmLogout() {
            if (confirm("Apakah Anda yakin ingin keluar?")) {
                window.location.href = 'login.php';
            }
        }

        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus data ini?');
        }
    </script>
</body>

</html>