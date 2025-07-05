<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?= $page_title ?? 'Jiwa Billiard' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-color: #2c3e50;
            --primary-color: #3498db;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: var(--sidebar-color);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.2);
        }
        
        .sidebar-menu {
            padding: 0;
            list-style: none;
        }
        
        .sidebar-menu li a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background-color: rgba(255, 255, 255, 0.1);
            padding-left: 25px;
        }
        
        .sidebar-menu li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
        }
        
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header text-center">
            <h4><i class="fas fa-8-ball me-2"></i>Jiwa Billiard</h4>
            <small>Admin Panel</small>
        </div>
        <ul class="sidebar-menu">
            <li><a href="tables.php" class="<?= basename($_SERVER['PHP_SELF']) == 'tables.php' ? 'active' : '' ?>"><i class="fas fa-table"></i> Manajemen Meja</a></li>
            <li><a href="bookings.php" class="<?= basename($_SERVER['PHP_SELF']) == 'bookings.php' ? 'active' : '' ?>"><i class="fas fa-calendar-alt"></i> Manajemen Booking</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <nav class="navbar navbar-expand-lg mb-4 rounded">
            <div class="container-fluid">
                <button class="btn btn-sm d-lg-none" type="button" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="mb-0"><?= $page_title ?? 'Dashboard' ?></h4>
                <div class="d-flex align-items-center">
                    <span class="me-2"><i class="fas fa-user-circle"></i> <?= $_SESSION['admin_username'] ?? 'Admin' ?></span>
                </div>
            </div>
        </nav>
        
        <div class="container-fluid">