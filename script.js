$(document).ready(function () {
    $('#bookingForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: 'process_booking.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    Swal.fire('Berhasil!', response.message, 'success');
                    $('#bookingForm')[0].reset();
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
            }
        });
    });
});
