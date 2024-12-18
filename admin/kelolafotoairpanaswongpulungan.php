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
<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

                        <!-- Manage Gallery Section -->
                        <div id="gallery-section" class="card mb-4">
                            <div class="card-header bg-success text-white">
                                Kelola Galeri Air Panas Wong Pulungan
                            </div>
                            <div class="card-body">
                                <a href="tambahfoto.php" class="btn btn-primary mb-3">Tambah Gambar</a>

                                <!-- Display Gallery Items -->
                                <table class="table table-hover mt-4">
                                    <thead>
                                        <tr>
                                            <th scope="col">Gambar</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM gallery_section";
                                        $result = mysqli_query($conn, $sql);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                // Path gambar di folder admin/uploads/
                                                $gambarPath = 'uploads/' . $row['image'];

                                                // Cek apakah file gambar tersedia
                                                if (!empty($row['image']) && file_exists($gambarPath)) {
                                                    $gambar = $gambarPath; // Path gambar valid
                                                } else {
                                                    $gambar = 'uploads/default.jpg'; // Gambar default jika tidak ada
                                                }

                                                echo "<tr>";
                                                echo "<td><img src='$gambar' alt='" . htmlspecialchars($row['image']) . "' class='img-thumbnail' width='100'></td>";
                                                echo "<td>
                                                        <a href='kelolafotoairpanaswongpulungan.php?delete_gallery_id={$row['id']}' class='btn btn-outline-danger btn-sm' onclick='return confirmDelete()'>
                                                            <i class='bi bi-trash'></i>
                                                        </a>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='2'>Tidak ada gambar.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End of Manage Gallery Section -->

                        <!-- Manage Video Section -->
                        <div id="video-section" class="card mb-4">
                            <div class="card-header bg-info text-white">
                                Kelola Video Air Panas Wong Pulungan
                            </div>
                            <div class="card-body">
                                <a href="tambahvideogaleri.php" class="btn btn-primary mb-3">Tambah Video</a>
                                <!-- Display Video Items -->
                                <div class="row">
                                    <?php
                                    $sql = "SELECT * FROM videogallery_section";
                                    $result = mysqli_query($conn, $sql);

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            // Path video di folder admin/uploads/
                                            $videoURL = $row['video'];

                                            echo "<div class='col-md-4 mb-3'>";
                                            echo "<div class='card'>";
                                            echo "<div class='card-body'>";
                                            echo "<iframe width='100%' height='200' src='$videoURL' frameborder='0' allowfullscreen></iframe>";
                                            echo "<a href='kelolafotoairpanaswongpulungan.php?delete_video_id={$row['id']}' class='btn btn-outline-danger btn-sm mt-2' onclick='return confirmDelete()'>
                                                    <i class='bi bi-trash'></i> Hapus
                                                  </a>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                    } else {
                                        echo "<div class='col-12'><p>Tidak ada video.</p></div>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- End of Manage Video Section -->

                        <!-- Delete Video Item -->
                        <?php
                        if (isset($_GET['delete_video_id'])) {
                            $id = $_GET['delete_video_id'];

                            // Sanitasi ID untuk mencegah SQL Injection
                            $id = intval($id);

                            // Cek apakah ID valid
                            if ($id > 0) {
                                // Hapus data dari database
                                $sql = "DELETE FROM videogallery_section WHERE id = $id";
                                if (mysqli_query($conn, $sql)) {
                                    echo "<script>alert('Data berhasil dihapus!'); window.location.href = 'kelolafotoairpanaswongpulungan.php';</script>";
                                    exit();
                                } else {
                                    echo "<script>alert('Gagal menghapus data'); window.history.back();</script>";
                                    exit();
                                }
                            } else {
                                echo "<script>alert('ID tidak valid!'); window.history.back();</script>";
                                exit();
                            }
                        }
                        ?>

                        <!-- Bootstrap JS (optional) -->
                        <script
                            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>