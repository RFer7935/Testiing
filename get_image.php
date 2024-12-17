<?php
$host = 'localhost';
$dbname = 'company_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    exit('Database connection failed.');
}

if (isset($_GET['section'], $_GET['id'])) {
    $id = (int) $_GET['id'];
    $section = $_GET['section'];

    switch ($section) {
        case 'hero':
            $table = 'hero_section';
            break;
        case 'facility':
            $table = 'facility_section';
            break;
        case 'gallery':
            $table = 'gallery_section';
            break;
        default:
            exit('Invalid section.');
    }

    $stmt = $pdo->prepare("SELECT image FROM `$table` WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $id]);
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Convert BLOB to string
        $imageFilename = $row['image'];
        if (!empty($imageFilename)) {
            // Since the filename is stored as BLOB, convert it to string
            $imageFilename = stream_get_contents($imageFilename);
        }

        $imagePath = 'uploads/' . $imageFilename;

        if (file_exists($imagePath)) {
            // Determine the MIME type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $imagePath);
            finfo_close($finfo);

            header('Content-Type: ' . $mime);
            readfile($imagePath);
            exit;
        } else {
            exit('Image file not found.');
        }
    } else {
        exit('Image not found in database.');
    }
} else {
    exit('Invalid parameters.');
}
?>