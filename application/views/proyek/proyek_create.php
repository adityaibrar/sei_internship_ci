<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Proyek</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Tambah Proyek Baru</h1>
        <div id="responseMessage" class="mt-3"></div>

        <form id="proyekForm">
            <div class="form-group">
                <label for="namaProyek">Nama Proyek:</label>
                <input type="text" class="form-control" id="namaProyek" name="namaProyek" required>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="client">Client:</label>
                        <input type="text" class="form-control" id="client" name="client" required>
                    </div>

                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="pimpinanProyek">Pimpinan Proyek:</label>
                        <input type="text" class="form-control" id="pimpinanProyek" name="pimpinanProyek" required>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col">
                    <div class="from-group">

                        <label for="tglMulai">Tanggal Mulai:</label>
                        <input type="date" class="form-control" id="tglMulai" name="tglMulai" required>
                    </div>
                </div>

                <div class="col">
                    <div class="from-group">
                        <label for="tglSelesai">Tanggal Selesai:</label>
                        <input type="date" class="form-control" id="tglSelesai" name="tglSelesai" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan:</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="lokasiSet">Lokasi:</label>
                <select id="lokasiSet" name="lokasiSet[]" class="form-control">
                    <?php if (!empty($lokasi)) : ?>
                        <?php foreach ($lokasi as $lok) : ?>
                            <option value="<?php echo htmlspecialchars($lok['id']); ?>"><?php echo htmlspecialchars($lok['namaLokasi']); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Tambah Proyek</button>
        </form>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('proyekForm').addEventListener('submit', function(event) {
            event.preventDefault();

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

            fetch('<?php echo site_url('proyek/store'); ?>', {
                    method: 'POST',
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
                        if (confirm('Proyek berhasil ditambahkan. Apakah Anda ingin kembali ke halaman sebelumnya?')) {
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