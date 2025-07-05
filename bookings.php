<?php
include '../includes/config.php';
include '../includes/header.php';

$page_title = 'Manajemen Booking';

// Ambil data meja
$tables = $pdo->query("SELECT * FROM tables WHERE status = 'available'")->fetchAll();

// Mode Edit
$edit_mode = false;
$edit_data = null;

if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_data = $stmt->fetch();
}

// Tambah Booking
if (isset($_POST['add_booking'])) {
    $customer_name = $_POST['customer_name'];
    $table_id = $_POST['table_id'];
    $booking_date = $_POST['booking_date'];
    $time_slot = $_POST['time_slot'];
    $note = $_POST['note'];

    $check = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE table_id = ? AND booking_date = ? AND time_slot = ?");
    $check->execute([$table_id, $booking_date, $time_slot]);

    if ($check->fetchColumn() == 0) {
        $stmt = $pdo->prepare("INSERT INTO bookings (customer_name, table_id, booking_date, time_slot, note) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$customer_name, $table_id, $booking_date, $time_slot, $note]);
        echo "<script>location.href='bookings.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Slot tersebut sudah dibooking!</div>";
    }
}

// Update Booking
if (isset($_POST['update_booking'])) {
    $id = $_POST['id'];
    $customer_name = $_POST['customer_name'];
    $table_id = $_POST['table_id'];
    $booking_date = $_POST['booking_date'];
    $time_slot = $_POST['time_slot'];
    $note = $_POST['note'];

    $check = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE table_id = ? AND booking_date = ? AND time_slot = ? AND id != ?");
    $check->execute([$table_id, $booking_date, $time_slot, $id]);

    if ($check->fetchColumn() == 0) {
        $stmt = $pdo->prepare("UPDATE bookings SET customer_name = ?, table_id = ?, booking_date = ?, time_slot = ?, note = ? WHERE id = ?");
        $stmt->execute([$customer_name, $table_id, $booking_date, $time_slot, $note, $id]);
        echo "<script>location.href='bookings.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Slot tersebut sudah dibooking!</div>";
    }
}

// Hapus Booking
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $pdo->prepare("DELETE FROM bookings WHERE id = ?")->execute([$id]);
    echo "<script>location.href='bookings.php';</script>";
}
?>

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
        <form method="POST" class="row g-3 mb-4">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
            <?php endif; ?>

            <div class="col-md-4">
                <input type="text" name="customer_name" class="form-control" placeholder="Nama Pemesan"
                    value="<?= $edit_mode ? htmlspecialchars($edit_data['customer_name']) : '' ?>" required>
            </div>

            <div class="col-md-3">
                <select name="table_id" class="form-select" required>
                    <option value="">Pilih Meja</option>
                    <?php foreach ($tables as $table): ?>
                        <option value="<?= $table['id'] ?>" <?= $edit_mode && $edit_data['table_id'] == $table['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($table['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <input type="date" name="booking_date" class="form-control"
                    value="<?= $edit_mode ? $edit_data['booking_date'] : '' ?>" required>
            </div>

            <div class="col-md-3">
                <select name="time_slot" class="form-select" required>
                    <option value="">Slot Waktu</option>
                    <?php
                    $slots = ['10:00 - 12:00', '12:00 - 14:00', '14:00 - 16:00', '16:00 - 18:00', '18:00 - 20:00'];
                    foreach ($slots as $slot) {
                        $selected = $edit_mode && $edit_data['time_slot'] == $slot ? 'selected' : '';
                        echo "<option $selected>$slot</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-6">
                <textarea name="note" class="form-control" placeholder="Catatan (opsional)"><?= $edit_mode ? htmlspecialchars($edit_data['note']) : '' ?></textarea>
            </div>

            <div class="col-md-2">
                <button type="submit" name="<?= $edit_mode ? 'update_booking' : 'add_booking' ?>" class="btn <?= $edit_mode ? 'btn-warning' : 'btn-primary' ?>">
                    <?= $edit_mode ? 'Update Booking' : 'Tambah Booking' ?>
                </button>
            </div>
        </form>

        <?php
        // Ambil semua data booking
        $data = $pdo->query("SELECT b.*, t.name AS table_name 
                            FROM bookings b 
                            JOIN tables t ON b.table_id = t.id 
                            ORDER BY booking_date DESC")->fetchAll();
        ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pemesan</th>
                    <th>Meja</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $i => $row): ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= htmlspecialchars($row['customer_name']) ?></td>
                        <td><?= htmlspecialchars($row['table_name']) ?></td>
                        <td><?= $row['booking_date'] ?></td>
                        <td><?= $row['time_slot'] ?></td>
                        <td><?= nl2br(htmlspecialchars($row['note'])) ?></td>
                        <td>
                            <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
