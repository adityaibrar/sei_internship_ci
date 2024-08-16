<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Edit Proyek</h1>
        <div id="responseMessage" class="mt-3"></div>

        <form id="proyekForm">
            <input type="hidden" id="proyekId" value="<?php echo htmlspecialchars($proyek['id']); ?>">

            <div class="form-group">
                <label for="namaProyek">Nama Proyek:</label>
                <input type="text" class="form-control" id="namaProyek" name="namaProyek" value="<?php echo htmlspecialchars($proyek['namaProyek']); ?>" required>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="client">Client:</label>
                        <input type="text" class="form-control" id="client" name="client" value="<?php echo htmlspecialchars($proyek['client']); ?>" required>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label for="pimpinanProyek">Pimpinan Proyek:</label>
                        <input type="text" class="form-control" id="pimpinanProyek" name="pimpinanProyek" value="<?php echo htmlspecialchars($proyek['pimpinanProyek']); ?>" required>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="tglMulai">Tanggal Mulai:</label>
                        <input type="date" class="form-control" id="tglMulai" name="tglMulai" value="<?php echo htmlspecialchars($proyek['tglMulai']); ?>" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="tglSelesai">Tanggal Selesai:</label>
                        <input type="date" class="form-control" id="tglSelesai" name="tglSelesai" value="<?php echo htmlspecialchars($proyek['tglSelesai']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan:</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="4" required><?php echo htmlspecialchars($proyek['keterangan']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="lokasiSet">Lokasi:</label>
                <select id="lokasiSet" name="lokasiSet[]" class="form-control">
                    <?php if (!empty($lokasi)) : ?>
                        <?php foreach ($lokasi as $lok) : ?>
                            <option value="<?php echo htmlspecialchars($lok['id']); ?>"
                                <?php echo in_array($lok['id'], array_column($proyek['lokasiSet'], 'id')) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($lok['namaLokasi']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Proyek</button>
        </form>

    </div>

    <!-- Link ke Bootstrap JS dan dependensinya -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('proyekForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form dari submit secara default

            var proyekId = document.getElementById('proyekId').value;
            var formData = {
                namaProyek: document.getElementById('namaProyek').value,
                client: document.getElementById('client').value,
                tglMulai: document.getElementById('tglMulai').value,
                tglSelesai: document.getElementById('tglSelesai').value,
                pimpinanProyek: document.getElementById('pimpinanProyek').value,
                keterangan: document.getElementById('keterangan').value,
                lokasiSet: Array.from(document.getElementById('lokasiSet').selectedOptions).map(option => ({
                    id: option.value
                }))
            };

            fetch('<?php echo site_url('proyek/update/'); ?>' + proyekId, {
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
                        message.innerHTML = '<div class="alert alert-success">Proyek berhasil diperbarui!</div>';
                        // Menampilkan dialog konfirmasi
                        if (confirm('Proyek berhasil diperbarui. Apakah Anda ingin kembali ke halaman sebelumnya?')) {
                            window.location.href = '<?php echo site_url('proyek'); ?>';
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