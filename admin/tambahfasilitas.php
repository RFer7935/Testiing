<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: .../admin/login.php");
    exit();
}
// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Data Fasilitas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="favicon" href="logo2.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h3>Tambah Data Fasilitas</h3>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_facility'])) {
            // Mengambil data input dari form
            $facility_title = mysqli_real_escape_string($conn, $_POST['facility_title']);
            $facility_description = mysqli_real_escape_string($conn, $_POST['facility_description']);
            $facility_image = $_FILES['facility_image']['name'];

            // Menentukan folder target
            $target_dir = "uploads/";

            // Membuat folder jika belum ada
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true); // Buat folder dengan izin yang diperlukan
            }

            // Path lengkap file
            $target_file = $target_dir . basename($facility_image);

            // Upload file ke folder target
            if (move_uploaded_file($_FILES['facility_image']['tmp_name'], $target_file)) {
                // Insert data ke database
                $sql = "INSERT INTO facility_section (title, description, image) 
                        VALUES ('$facility_title', '$facility_description', '$facility_image')";

                if (mysqli_query($conn, $sql)) {
                    echo "<div class='alert alert-success'>Data berhasil ditambahkan!</div>";
                    echo "<script>
                            setTimeout(function() {
                                window.location.href = 'keloladatafasilitas.php';
                            }, 1000);
                          </script>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Gagal mengupload gambar.</div>";
            }
        }
        ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="facility_title" class="form-label">Judul:</label>
                <input type="text" class="form-control" id="facility_title" name="facility_title" placeholder="Judul"
                    required>
            </div>
            <div class="mb-3">
                <label for="facility_description" class="form-label">Deskripsi:</label>
                <textarea class="form-control" id="facility_description" name="facility_description"
                    placeholder="Deskripsi" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="facility_image" class="form-label">Gambar:</label>
                <input type="file" class="form-control" id="facility_image" name="facility_image" accept="image/*"
                    required>
            </div>
            <button type="submit" class="btn btn-success" name="submit_facility">Simpan</button>
            <a href="keloladatafasilitas.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>