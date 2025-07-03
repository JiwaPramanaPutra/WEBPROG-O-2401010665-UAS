<?php
header('Content-Type: application/json');
include 'includes/config.php';

$customer_name = $_POST['customer_name'] ?? '';
$table_id = $_POST['table_id'] ?? '';
$booking_date = $_POST['booking_date'] ?? '';
$time_slot = $_POST['time_slot'] ?? '';
$note = $_POST['note'] ?? '';

// Validasi dasar
if (empty($customer_name) || empty($table_id) || empty($booking_date) || empty($time_slot)) {
    echo json_encode(['success' => false, 'message' => 'Semua kolom wajib diisi.']);
    exit;
}

// Cek double booking
$stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE table_id = ? AND booking_date = ? AND time_slot = ?");
$stmt->execute([$table_id, $booking_date, $time_slot]);

if ($stmt->fetchColumn() > 0) {
    echo json_encode(['success' => false, 'message' => 'Slot waktu sudah dibooking.']);
    exit;
}

// Simpan booking
$stmt = $pdo->prepare("INSERT INTO bookings (customer_name, table_id, booking_date, time_slot, note) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$customer_name, $table_id, $booking_date, $time_slot, $note]);

echo json_encode(['success' => true, 'message' => 'Booking berhasil disimpan.']);
