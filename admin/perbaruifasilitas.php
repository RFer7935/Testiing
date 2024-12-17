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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Facility Section</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h3>Update Facility Section</h3>
        <?php
        if (isset($_GET['edit_facility_id'])) {
            $id = $_GET['edit_facility_id'];
            $sql = "SELECT * FROM facility_section WHERE id = $id";
            $result = mysqli_query($conn, $sql);
            $facility_data = mysqli_fetch_assoc($result);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_facility'])) {
            $facility_title = $_POST['facility_title'];
            $facility_description = $_POST['facility_description'];
            $id = $_POST['id'];
            $sql = "UPDATE facility_section 
                    SET title = '$facility_title', description = '$facility_description' 
                    WHERE id = $id";

            if (mysqli_query($conn, $sql)) {
                // Check if a new image is uploaded
                if (!empty($_FILES['facility_image']['name'])) {
                    $facility_image = $_FILES['facility_image']['name'];
                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($facility_image);

                    // Upload file and update the image path in the database
                    if (move_uploaded_file($_FILES['facility_image']['tmp_name'], $target_file)) {
                        $sql = "UPDATE facility_section SET image = '$facility_image' WHERE id = $id";
                        mysqli_query($conn, $sql);
                    }
                }
                echo "<div class='alert alert-success'>Data berhasil diupdate!</div>";
                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'keloladatafasilitas.php';
                        }, 1000);
                      </script>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        }
        ?>
        <?php if (isset($facility_data)) { ?>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $facility_data['id']; ?>">
                <div class="mb-3">
                    <label for="facility_title" class="form-label">Judul:</label>
                    <input type="text" class="form-control" id="facility_title" name="facility_title"
                        value="<?php echo $facility_data['title']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="facility_description" class="form-label">Deskripsi:</label>
                    <textarea class="form-control" id="facility_description" name="facility_description" rows="3"
                        required><?php echo $facility_data['description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="facility_image" class="form-label">Gambar:</label>
                    <input type="file" class="form-control" id="facility_image" name="facility_image">
                </div>
                <button type="submit" class="btn btn-success" name="update_facility">Update</button>
                <a href="keloladatafasilitas.php" class="btn btn-secondary">Kembali</a>
            </form>
        <?php } ?>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>