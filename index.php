<?php
include 'includes/config.php'; // koneksi ke database

// Ambil daftar meja
$tables = $pdo->query("SELECT * FROM tables WHERE status = 'available'")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billiard Club - Booking Meja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('assets/images/billiard-bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }
        .booking-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
            transition: transform 0.3s;
        }
        .booking-card:hover {
            transform: translateY(-5px);
        }
        .btn-primary {
            background-color: var(--secondary-color);
            border: none;
            padding: 10px 25px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .table-badge {
            background-color: var(--primary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        footer {
            background-color: var(--primary-color);
            color: white;
            padding: 30px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: var(--primary-color);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <i class="fas fa-8-ball me-2"></i>Billiard Club
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin/login.php">Admin</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4">Booking Meja Billiard</h1>
        <p class="lead mb-5">Reservasi meja billiard Anda dengan mudah dan cepat</p>
    </div>
</section>

<!-- Booking Form -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="booking-card card p-4 mb-5">
                <h3 class="text-center mb-4"><i class="fas fa-calendar-alt me-2"></i>Form Booking</h3>
                <form id="bookingForm">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label">Nama Anda</label>
                            <input type="text" name="customer_name" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pilih Meja</label>
                            <select name="table_id" class="form-select" required>
                                <option value="">-- Pilih Meja --</option>
                                <?php foreach ($tables as $table): ?>
                                    <option value="<?= $table['id'] ?>">
                                        <?= htmlspecialchars($table['name']) ?> (<?= $table['status'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label">Tanggal Booking</label>
                            <input type="date" name="booking_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Slot Waktu</label>
                            <select name="time_slot" class="form-select" required>
                                <option value="">-- Pilih Waktu --</option>
                                <option>10:00 - 12:00</option>
                                <option>12:00 - 14:00</option>
                                <option>14:00 - 16:00</option>
                                <option>16:00 - 18:00</option>
                                <option>18:00 - 20:00</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Tambahan</label>
                        <textarea name="note" class="form-control" rows="2" placeholder="Contoh: Butuh 2 stik billiard"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Booking
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5><i class="fas fa-8-ball me-2"></i>Billiard Club</h5>
                <p>Jl. Contoh No. 123, Kota Anda</p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h5>Jam Operasional</h5>
                <p>Setiap Hari<br>10:00 - 22:00 WIB</p>
            </div>
            <div class="col-md-4">
                <h5>Kontak Kami</h5>
                <p><i class="fas fa-phone me-2"></i>(021) 1234-5678</p>
            </div>
        </div>
        <hr class="my-4 bg-light">
        <p class="mb-0">&copy; 2023 Billiard Club. All rights reserved.</p>
    </div>
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('input[name="booking_date"]').attr('min', new Date().toISOString().split('T')[0]);

    $('#bookingForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'process_booking.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Booking Berhasil!',
                        text: response.message,
                        confirmButtonColor: '#3498db'
                    });
                    $('#bookingForm')[0].reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message,
                        confirmButtonColor: '#e74c3c'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan, silakan coba lagi.',
                    confirmButtonColor: '#e74c3c'
                });
            }
        });
    });
});
</script>
</body>
</html>
