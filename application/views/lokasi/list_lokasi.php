<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lokasi</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Daftar Lokasi</h1>

        <div class="mb-3">
            <a href="<?php echo site_url('lokasi/form'); ?>" class="btn btn-primary mb-3">Tambah Lokasi Baru</a>
            <a href="<?php echo site_url('proyek'); ?>" class="btn btn-primary mb-3">Lihat Proyek</a>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lokasi</th>
                    <th>Negara</th>
                    <th>Provinsi</th>
                    <th>Kota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($lokasi)) : ?>
                    <?php foreach ($lokasi as $key => $l) : ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo htmlspecialchars($l['namaLokasi']); ?></td>
                            <td><?php echo htmlspecialchars($l['negara']); ?></td>
                            <td><?php echo htmlspecialchars($l['provinsi']); ?></td>
                            <td><?php echo htmlspecialchars($l['kota']); ?></td>
                            <td>
                                <a href="<?php echo site_url('lokasi/edit/' . $l['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?php echo site_url('lokasi/delete/' . $l['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data lokasi</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Link ke Bootstrap JS dan dependensinya -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>