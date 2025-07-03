<?php include 'includes/config.php'; include 'includes/header.php'; ?>
// Di bagian atas bookings.php dan tables.php
$page_title = 'Manajemen Booking'; // atau 'Manajemen Meja'

// Ganti bagian h4 dengan:
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><?= $page_title ?></h5>
        <?php if (basename($_SERVER['PHP_SELF']) == 'bookings.php'): ?>
            <a href="tables.php" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-table me-1"></i> Kelola Meja
            </a>
        <?php else: ?>
            <a href="bookings.php" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-calendar-alt me-1"></i> Kelola Booking
            </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <!-- Konten form dan tabel -->
    </div>
</div>

<form method="POST" class="mb-3">
    <input type="text" name="name" placeholder="Nama Meja" required class="form-control w-50 d-inline-block">
    <button name="add" class="btn btn-success">Tambah</button>
</form>

<?php
// Tambah meja
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $stmt = $pdo->prepare("INSERT INTO tables (name) VALUES (:name)");
    $stmt->execute(['name' => $name]);
    echo "<script>location.reload();</script>";
}

// Hapus meja
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM tables WHERE id = ?");
    $stmt->execute([$id]);
    echo "<script>location.href='tables.php';</script>";
}

// Tampilkan daftar meja
$data = $pdo->query("SELECT * FROM tables ORDER BY id DESC")->fetchAll();
?>

<table class="table table-bordered">
    <thead><tr><th>#</th><th>Nama Meja</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
        <?php foreach ($data as $i => $row): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>
