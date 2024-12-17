<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $passwordInput = isset($_POST['password']) ? $_POST['password'] : '';

    // Escape input untuk mencegah SQL injection
    $email = $conn->real_escape_string($email);

    // Query untuk mendapatkan user berdasarkan email
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verifikasi password (tanpa hash)
        if ($passwordInput === $row['password']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            header("Location: admin.php");
            exit();
        } else {
            echo "<span style='color: red;'>Password salah.</span>";
        }
    } else {
        echo "<span style='color: red;'>Email tidak ditemukan.</span>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="icon" type="favicon" href="logo2.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background: url('img/bgbg6.jpeg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 400px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .text-center {
            text-align: center;
        }

        .text-center a {
            color: #007BFF;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        .header-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 450px;
            /* Jarak antar logo */
            padding: 10px 0;
        }

        .logo-container img.logo {
            height: 80px;
            width: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Login</h2>
        <form method="post" action="login.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn">Login</button>
        </form>
    </div>
</body>
<nav class="navbar navbar-light bg-light fixed-bottom">
    <div class="container-fluid d-flex justify-content-center align-items-center gap-3">
        <a class="navbar-brand d-flex flex-column align-items-center" href="../index.php"
            style="background-color:#f8f9fa;">
            <div class="d-flex align-items-center gap-3"
                style="font-size: 24px; font-family: 'Edu AU VIC WA NT Pre', serif; font-weight: 600;">
                <img src="/Testiing/img/logo2.png" alt="IS COLLECTION Logo" height="70" width="65"> Wisata Air Panas Wong Pulungan
            </div>
            <div class="mt-3" style="font-size: 12px;">© Copyright | All Rights Reserved</div>
        </a>
    </div>
</nav>

</html>