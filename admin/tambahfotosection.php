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
include '../db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload Foto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="favicon" href="logo2.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h3>Upload Foto</h3>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_photo'])) {
            // Ambil informasi file
            $photo = $_FILES['photo']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($photo);

            // Validasi tipe file (hanya gambar)
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png'];

            if (!in_array($imageFileType, $allowed_types)) {
                echo "<div class='alert alert-danger'>Hanya file JPG, JPEG, dan PNG yang diperbolehkan.</div>";
            } elseif ($_FILES['photo']['size'] > 5000000) {
                // Validasi ukuran file (maksimal 5MB)
                echo "<div class='alert alert-danger'>Ukuran file maksimal 1MB.</div>";
            } else {
                // Proses unggah file
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                    // Masukkan nama file ke database
                    $sql = "INSERT INTO foto_section (image) VALUES ('$photo')";

                    if (mysqli_query($conn, $sql)) {
                        echo "<div class='alert alert-success'>Foto berhasil diupload!</div>";
                        echo "<script>
                                setTimeout(function() {
                                    window.location.href = '../admin/edittentangkami.php';
                                }, 1000);
                              </script>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Gagal mengupload gambar.</div>";
                }
            }
        }
        ?>
        <form action="tambahfotosection.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="photo" class="form-label">Pilih Foto:</label>
                <input type="file" class="form-control" id="photo" name="photo" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit_photo">Upload</button>
            <a href="../admin/edittentangkami.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>