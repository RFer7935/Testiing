<?php
// Koneksi ke database
include('db.php'); // Sesuaikan dengan file koneksi Anda

// Ambil ID fasilitas dari parameter GET
$facilityId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Ambil data fasilitas berdasarkan ID
if ($facilityId > 0) {
    $sql = "SELECT * FROM facility_section WHERE id = $facilityId";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $facility = mysqli_fetch_assoc($result);
        $response = [
            'title' => htmlspecialchars($facility['title']),
            'image' => 'admin/uploads/' . $facility['image'], // Pastikan path gambar benar
            'description' => htmlspecialchars($facility['description']),
        ];
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'Fasilitas tidak ditemukan.']);
    }
} else {
    echo json_encode(['error' => 'ID tidak valid.']);
}
?>
