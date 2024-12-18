<?php
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Air Panas Wong Pulungan</title>
    <link rel="icon" type="favicon" href="logo2.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        /* Hero Section */
        .bg {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        .background1 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }

        .background1::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 5);
            /* Adjust the opacity as needed */
            z-index: 2;
        }

        /* Untuk judul di dalam modal */
        .modal-tittle {
            text-align: center;
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        /* Mengatur deskripsi agar tetap di tengah */
        .modal-description,
        .card-body p {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        /* Untuk gambar di dalam modal */
        .modal-image,
        .card-img-top {
            display: block;
            margin-left: auto;
            margin-right: auto;
            max-width: 100%;
            /* Pastikan gambar tidak melampaui batas kontainer */
            height: auto;
            /* Menjaga proporsi gambar */
        }

        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25D366;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 1000;
        }

        .floating-button:hover {
            background-color: #128c7e;
        }
    </style>
</head>

<body>
    <div class="scroll-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-lightblue fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#background_utama">
                    <img src="img/logo2.png" alt="Logo" height="35">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#background_utama">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="#Tentang_Kami">Tentang Kami</a></li>
                        <li class="nav-item"><a class="nav-link" href="#Fasilitas">Fasilitas</a></li>
                        <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
                        <li class="nav-item"><a class="nav-link" href="#aplikasi">Download</a></li>
                        <li class="nav-item"><a class="nav-link" href="#lokasi">Lokasi</a></li>
                    </ul>
                </div>
            </div>
        </nav>


        <!-- Hero Section -->
        <div class="bg content-section" id="background_utama">
            <img src="img/bgbg6.jpeg" alt="Air Panas Wong Pulungan" class="background1">
            <div class="centered-container fade-transition">
                <h1 class="company-name display-4">Wisata Air Panas Wong Pulungan</h1>
                <h2 class="deskripsion1 lead">Nikmati sensasi air panas yang dilengkapi</h2>
                <h2 class="deskripsion1 lead">dengan pemandangan Gunung Penanggungan </h2>
                <h2 class="deskripsion1 lead">yang terletak di Gempol, Pasuruan, Jawa Timur </h2>
                <a href="#Tentang_Kami" class="btn btn-primary btn-lg mt-3">Lihat Selengkapnya</a>
            </div>
        </div>



        <!-- About Section -->
        <?php
        $sql = "SELECT * FROM about_section WHERE id = 1";
        $result = mysqli_query($conn, $sql);
        $about = mysqli_fetch_assoc($result);
        ?>
        <section id="Tentang_Kami" class="content-section py-5">
            <div class="container fade-transition delay-1">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1>Wisata Air Panas Wong Pulungan</h1>
                        <div class="underline"></div>
                        <p class="mt-4"><?php echo $about['text']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <div id="aboutCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $sql = "SELECT * FROM foto_section";
                                $result = mysqli_query($conn, $sql);
                                $active = true;

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $imagePath = 'admin/uploads/' . $row['image'];
                                        $src = (!empty($row['image']) && file_exists($imagePath)) ? $imagePath : 'admin/uploads/default-image.jpg';
                                        $activeClass = $active ? 'active' : '';
                                        echo "<div class='carousel-item $activeClass'>
                                                <img src='$src' class='d-block w-100 rounded carousel-image' alt='About Image'>
                                              </div>";
                                        $active = false;
                                    }
                                } else {
                                    echo "<div class='carousel-item active'>
                                            <img src='img/default-image.jpg' class='d-block w-100 rounded carousel-image' alt='Default Image'>
                                          </div>";
                                }
                                ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <?php
        $sql = "SELECT * FROM pricing_section WHERE id = 1";
        $result = mysqli_query($conn, $sql);
        $pricing = mysqli_fetch_assoc($result);
        ?>
        <section id="harga" class="content-section py-5 bg-light">
            <div class="container fade-transition delay-1">
                <div class="price-highlight">
                    <h1 class="text-center mb-4 price-title">HARGA TIKET CUMA</h1>
                    <div class="price-amount">Rp <?php echo $pricing['text']; ?>!</div>
                </div>
                <div class="underline mx-auto"></div>
            </div>
        </section>

        <!-- Facilities Section -->
        <section id="Fasilitas" class="content-section py-5">
            <div class="container fade-transition delay-2">
                <h1 class="event text-center">DESTINASI LAINNYA DALAM</h1>
                <h1 class="event text-center">WISATA AIR PANAS WONG PULUNGAN</h1>
                <div class="underline mx-auto"></div>
                <div class="row mt-4">
                    <?php
                    $sql = "SELECT * FROM facility_section";
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($facility = mysqli_fetch_assoc($result)) {
                            $imagePath = 'admin/uploads/' . $facility['image'];
                            $src = (!empty($facility['image']) && file_exists($imagePath)) ? $imagePath : 'admin/uploads/default-image.jpg';

                            // Ambil hanya 5 kata pertama dari description
                            $descriptionWords = explode(" ", $facility['description']);
                            $shortDescription = implode(" ", array_slice($descriptionWords, 0, 5));
                            ?>
                            <div class="col-md-3 mb-4">
                                <div class="card h-100 text-center">
                                    <img src="<?php echo $src; ?>" class="card-img-top"
                                        alt="<?php echo htmlspecialchars($facility['title']); ?>">
                                    <div class="card-body">
                                        <h3><?php echo htmlspecialchars($facility['title']); ?></h3>
                                        <p class="mt-3"><?php echo htmlspecialchars($shortDescription); ?>...</p>
                                        <!-- Button to trigger modal -->
                                        <button type="button" class="btn btn-primary open-modal-btn" data-bs-toggle="modal"
                                            data-bs-target="#facilityModal" data-id="<?php echo $facility['id']; ?>"
                                            data-title="<?php echo htmlspecialchars($facility['title']); ?>"
                                            data-image="<?php echo $src; ?>"
                                            data-description="<?php echo htmlspecialchars($facility['description']); ?>">
                                            Lihat Selengkapnya
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Facility Modal -->
        <div class="modal fade" id="facilityModal" tabindex="-1" aria-labelledby="facilityModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="facilityModalLabel">Facility Title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="admin/uploads/default-image.jpg" class="img-fluid mb-3 modal-image"
                            alt="Facility Image">
                        <p class="modal-description">Facility description goes here...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Section -->
        <section id="galeri" class="content-section py-5 bg-light">
            <div class="container fade-transition delay-1">
                <h1 class="text-center mb-4">LIHAT KOLEKSI GALERI KAMI</h1>
                <div class="underline mx-auto"></div>
                <div class="row">
                    <?php
                    // Query untuk mengambil semua data gambar dari tabel gallery_section
                    $sql = "SELECT * FROM gallery_section";
                    $result = mysqli_query($conn, $sql);

                    // Cek apakah ada data
                    while ($gallery = mysqli_fetch_assoc($result)) {
                        // Menentukan lokasi file gambar
                        $imagePath = 'admin/uploads/' . $gallery['image']; // Path gambar berdasarkan nama file yang ada di kolom 'image'
                    
                        // Pastikan file gambar ada di server (validasi file)
                        if (file_exists($imagePath)) {
                            ?>
                            <div class="col-md-4 mb-4">
                                <!-- Menampilkan gambar -->
                                <img src="<?php echo $imagePath; ?>" class="img-fluid rounded" alt="Gallery Image">
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php
                        // Query untuk mengambil URL video dari tabel videogallery_section
                        $sql = "SELECT * FROM videogallery_section";
                        $result = mysqli_query($conn, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($video = mysqli_fetch_assoc($result)) {
                                $videoURL = $video['video'];
                                // Check if the URL is a YouTube link or a local file
                                if (strpos($videoURL, 'youtube.com') !== false) {
                                    echo "<div class='embed-responsive embed-responsive-16by9 mb-4'>
                                        <iframe class='embed-responsive-item' src='$videoURL' allowfullscreen></iframe>
                                      </div>";
                                } else {
                                    // Ensure the video path is correct
                                    $videoPath = 'admin/' . $videoURL;
                                    echo "<div class='embed-responsive embed-responsive-16by9 mb-4'>
                                        <video class='embed-responsive-item' controls>
                                            <source src='$videoPath' type='video/mp4'>
                                            Your browser does not support the video tag.
                                        </video>
                                      </div>";
                                }
                            }
                        } else {
                            echo "<p>Tidak ada video.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>


        <!-- App Download Section -->
        <section id="aplikasi" class="content-section py-5 bg-light">
            <div class="container fade-transition delay-2">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="text-section">
                            <h2 class="title">Nikmati Kenyamanan dalam Wisata Air Panas Wong Pulungan dengan lebih
                                mudah!
                            </h2>
                            <p class="subtitle">Download sekarang dan jelajahi pesona Wisata Air Panas Wong Pulungan
                                dimanapun dan kapanpun</p>
                            <a class="btn btn-primary download-button"
                                href="download/auto-clicker-automatic-tap-2-1-4.apk">Download Sekarang</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img src="img/Iphone.png" alt="Aplikasi pada handphone"
                            class="img-fluid phone-image custom-size">
                    </div>
                </div>
            </div>
        </section>

        <!-- Location Section -->
        <section id="lokasi" class="content-section lokasi-section">
            <div class="container fade-transition delay-2">
                <h2>Lokasi Kami</h2>
                <div class="map-wrapper slide-transition">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.4533799736785!2d112.68418991477892!3d-7.624214894509843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7d906e38b0e2f%3A0x6e5df0bd5a47efa7!2sPemandian%20Air%20Panas%20Kepulungan!5e0!3m2!1sid!2sid!4v1700486115831!5m2!1sid!2sid"
                        width="100%" height="400" allowfullscreen="" loading="lazy" class="rounded map-frame"></iframe>
                </div>
            </div>
        </section>

        <!-- Reviews Section -->
        <section id="reviews" class="content-section py-5 bg-light">
            <div class="container fade-transition delay-2">
                <h2 class="text-center mb-4">APA KATA PENGUNJUNG TENTANG KAMI</h2>
                <div class="underline mx-auto"></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="review">
                            <h4>Achamad Muchayyin</h4>
                            <p class="text-muted">
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star"></i>

                            </p>
                            <p>"Suasana enak Air gak seberapa Panas banyak orang jualan di depan kolam"</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="review">
                            <h4>Brilian Indah</h4>
                            <p class="text-muted">
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                            </p>
                            <p>"Parkir mobil 10rb, tiket masuk pemandian 15rb/orang. Fasilitas kamar mandi/bilas
                                ckup
                                luas bersih nyaman. Gazebo ckup banyak, kolam pemandian ada 4 , yg paling panas di
                                kolam
                                tengah."</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="review">
                            <h4>Suci Fitri</h4>
                            <p class="text-muted">
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                            </p>
                            <p>"Murah meriah,, pas hari Minggu kesana,, air nya habis di bersihkan.. jadid makin
                                bersih.. jajanannya juga ramah di kantong.."</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="review">
                            <h4>Supra Setia</h4>
                            <p class="text-muted">
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                            </p>
                            <p>"Lagi gabut+galau... Hang out ke sini saja dengan Ur friends. Dunia masih Indah, U're
                                not
                                alone..."</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="review">
                            <h4>Vrila</h4>
                            <p class="text-muted">
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star"></i>
                            </p>
                            <p>"Pemandian air panas Pulungan terletak di tepi jln raya sehingga mudah unt dicari.
                                Pemandian ini buka sampai jam 11 mlm,tp kata ibu ibu yg berkunjung dia pernah sampai
                                jam
                                2mlm, HTM 15.000 parkir mobil 10.000. tersedia rumah joglo unt sekedar bersantai
                                atau
                                juga beberapa stand makanan dg konsep lesehan. unt makanan dan minuman harga masih
                                relatif terjangkau"
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="review">
                            <h4>Achmad Fajar</h4>
                            <p class="text-muted">
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star blue-star"></i>
                                <i class="fas fa-star"></i>
                            </p>
                            <p>"Tempat mandi air panas yang cukup oke. Buka jam 4 sore. Tempatnya tidak terlalu
                                luas,
                                kolamnya sekitar 7×7 meter dengan pancuran di tengahnya. Air tidak terlalu panas
                                cocok
                                untuk berendam santai dengan harga ticket masuk 15.000. Setelah berendam air panas
                                bisa
                                bilas dengan air dingin di kamar mandi yang telah disediakan. Setelah berendam air
                                panas
                                bisa mencicipi kuliner yang tersedia di depan gerbang masuk. Tersedia berbagai
                                jualan
                                makanan dari lalapan, cemilan seperti cilok, sosis, risol mayo, dan berbagai minuman
                                seperti wedang jahe, pop ice, es jeruk, dll. Semua warung disini rasa makanannya
                                cukup
                                oke dengan biaya yang wajar. Kalau malam biasanya ada live music sehingga suasana
                                makan
                                jadi lebih nyaman.

                                Parkir : Tersedia parkir yang luas dengan biaya parkir motor : 5.000 dan mobil
                                10.000"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer py-4">
            <div class="container fade-transition delay-3">
                <div class="row">
                    <div class="text-center mt-4">
                        <h3>Ikuti Kami</h3>
                        <div class="social-icons mt-3">
                            <a href="https://www.instagram.com/pemandianairpanas_kepulungan?igsh=YzljYTk1ODg3Zg=="><i
                                    class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <p class="copyright">&copy; 2024 WISATA AIR PANAS WONG PULUNGAN. Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </footer>

        <!--Floating Button -->
        <button class="floating-button" onclick="window.location.href='https://wa.me/6281234567890'">
            <i class="fab fa-whatsapp"></i>
        </button>
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const openModalButtons = document.querySelectorAll('.open-modal-btn');
                const modalTitle = document.querySelector('#facilityModalLabel');
                const modalImage = document.querySelector('.modal-image');
                const modalDescription = document.querySelector('.modal-description');

                openModalButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const facilityId = button.getAttribute('data-id'); // Ambil ID fasilitas yang diklik
                        const title = button.getAttribute('data-title');
                        const image = button.getAttribute('data-image');
                        const description = button.getAttribute('data-description');

                        // Update modal content sementara dengan data yang sudah ada
                        modalTitle.textContent = title;
                        modalImage.src = image;
                        modalDescription.textContent = description;

                        // Gunakan AJAX untuk mengambil data lebih lengkap jika diperlukan
                        fetch(`getFacilityDetails.php?id=${facilityId}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data) {
                                    modalTitle.textContent = data.title;
                                    modalImage.src = data.image;
                                    modalDescription.textContent = data.description;
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan saat memuat data.');
                            });
                    });
                });
            });


        </script>


</html>