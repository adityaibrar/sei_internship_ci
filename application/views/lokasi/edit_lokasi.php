<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lokasi</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Edit Lokasi</h1>

        <form id="lokasiForm">
            <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($lokasi['id']); ?>">

            <div class="form-group">
                <label for="namaLokasi">Nama Lokasi:</label>
                <input type="text" id="namaLokasi" name="namaLokasi" class="form-control" value="<?php echo htmlspecialchars($lokasi['namaLokasi']); ?>" required>
            </div>

            <div class="form-group">
                <label for="negara">Negara:</label>
                <input type="text" id="negara" name="negara" class="form-control" value="<?php echo htmlspecialchars($lokasi['negara']); ?>" required>
            </div>

            <div class="form-group">
                <label for="provinsi">Provinsi:</label>
                <input type="text" id="provinsi" name="provinsi" class="form-control" value="<?php echo htmlspecialchars($lokasi['provinsi']); ?>" required>
            </div>

            <div class="form-group">
                <label for="kota">Kota:</label>
                <input type="text" id="kota" name="kota" class="form-control" value="<?php echo htmlspecialchars($lokasi['kota']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>

        <div id="responseMessage" class="mt-3"></div>
    </div>

    <!-- Link ke Bootstrap JS dan dependensinya -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('lokasiForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form dari submit secara default

            var formData = {
                namaLokasi: document.getElementById('namaLokasi').value,
                negara: document.getElementById('negara').value,
                provinsi: document.getElementById('provinsi').value,
                kota: document.getElementById('kota').value
            };

            var id = document.getElementById('id').value;

            fetch('<?php echo site_url('lokasi/update/'); ?>' + id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    var message = document.getElementById('responseMessage');
                    if (data.status === 'error') {
                        message.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
                    } else {
                        message.innerHTML = '<div class="alert alert-success">Lokasi berhasil diperbarui!</div>';
                        if (confirm('Lokasi berhasil diperbarui. Apakah Anda ingin kembali ke halaman sebelumnya?')) {
                            window.location.href = '<?php echo site_url('lokasi'); ?>'; // Ganti dengan URL halaman proyek
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('responseMessage').innerHTML = '<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>';
                });
        });
    </script>
</body>

</html>