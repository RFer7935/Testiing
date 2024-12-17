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
                        <!-- About Section -->
                        <div id="about-section" class="card mb-4">
                            <div class="card-header bg-success text-white">
                                Edit Isi Tulisan Tentang Kami
                            </div>
                            <div class="card-body">
                                <?php include 'db.php'; ?>
                                <?php
                                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_about'])) {
                                    $about_text = $_POST['about_text'];
                                    $sql = "UPDATE about_section SET text = '$about_text' WHERE id = 1";

                                    if (mysqli_query($conn, $sql)) {
                                        echo "<div class='alert alert-success'>Data berhasil diupdate!</div>";
                                        echo "<script>
                                                setTimeout(function() {
                                                    window.location.href = 'edittentangkami.php';
                                                }, 1000);
                                              </script>";
                                    } else {
                                        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
                                    }
                                }

                                $sql = "SELECT * FROM about_section WHERE id = 1";
                                $result = mysqli_query($conn, $sql);
                                $about_data = mysqli_fetch_assoc($result);
                                ?>
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="about_text" class="form-label">Isi Text:</label>
                                        <textarea class="form-control" id="about_text" name="about_text" rows="3"
                                            required disabled><?php echo $about_data['text']; ?></textarea>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="edit_button">Edit</button>
                                    <button type="submit" class="btn btn-success" name="update_about" id="save_button"
                                        disabled>Simpan</button>
                                </form>
                            </div>
                        </div>
                        <!-- End of About Section -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('edit_button').addEventListener('click', function () {
            document.getElementById('about_text').disabled = false;
            document.getElementById('save_button').disabled = false;
            this.disabled = true;
        });
    </script>
    <script>
        function confirmLogout() {
            if (confirm("Apakah Anda yakin ingin keluar?")) {
                window.location.href = 'login.php';
            }
        }
    </script>
</body>

</html>