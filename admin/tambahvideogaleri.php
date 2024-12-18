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
    <title>Upload Video</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="favicon" href="logo2.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h3>Upload Video</h3>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['submit_video_url'])) {
                // Ambil URL video
                $videoURL = $_POST['video_url'];

                // Validasi URL video (hanya YouTube)
                if (filter_var($videoURL, FILTER_VALIDATE_URL) === false || strpos($videoURL, 'youtube.com') === false) {
                    echo "<div class='alert alert-danger'>URL tidak valid. Hanya URL YouTube yang diperbolehkan.</div>";
                } else {
                    // Masukkan URL video ke database
                    $sql = "INSERT INTO videogallery_section (video) VALUES ('$videoURL')";

                    if (mysqli_query($conn, $sql)) {
                        echo "<div class='alert alert-success'>Video berhasil diupload!</div>";
                        echo "<script>
                                setTimeout(function() {
                                    window.location.href = '../admin/kelolafotoairpanaswongpulungan.php';
                                }, 1000);
                              </script>";
                    } else {
                        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
                    }
                }
            } elseif (isset($_POST['submit_video_file'])) {
                // Ambil informasi file
                $video = $_FILES['video']['name'];
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($video);

                // Validasi tipe file (hanya video)
                $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowed_types = ['mp4', 'avi', 'mov'];

                if (!in_array($videoFileType, $allowed_types)) {
                    echo "<div class='alert alert-danger'>Hanya file MP4, AVI, dan MOV yang diperbolehkan.</div>";
                } elseif ($_FILES['video']['size'] > 50000000) {
                    // Validasi ukuran file (maksimal 50MB)
                    echo "<div class='alert alert-danger'>Ukuran file maksimal 50MB.</div>";
                } else {
                    // Proses unggah file
                    if (move_uploaded_file($_FILES['video']['tmp_name'], $target_file)) {
                        // Masukkan nama file ke database
                        $sql = "INSERT INTO videogallery_section (video) VALUES ('$target_file')";

                        if (mysqli_query($conn, $sql)) {
                            echo "<div class='alert alert-success'>Video berhasil diupload!</div>";
                            echo "<script>
                                    setTimeout(function() {
                                        window.location.href = '../admin/kelolafotoairpanaswongpulungan.php';
                                    }, 1000);
                                  </script>";
                        } else {
                            echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Gagal mengupload video.</div>";
                    }
                }
            }
        }
        ?>
        <form action="tambahvideogaleri.php" method="POST">
            <div class="mb-3">
                <label for="video_url" class="form-label">URL Video YouTube:</label>
                <input type="url" class="form-control" id="video_url" name="video_url" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit_video_url">Tambah URL</button>
        </form>
        <hr>
        <form action="tambahvideogaleri.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="video" class="form-label">Pilih Video:</label>
                <input type="file" class="form-control" id="video" name="video" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit_video_file">Tambah Video</button>
        </form>
        <a href="../admin/kelolafotoairpanaswongpulungan.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>