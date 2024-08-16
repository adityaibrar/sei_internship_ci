<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Proyek</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Daftar Proyek</h1>

        <div class="mb-3">
            <a href="<?php echo site_url('proyek/create'); ?>" class="btn btn-primary">Tambah Proyek Baru</a>
            <a href="<?php echo site_url('lokasi'); ?>" class="btn btn-secondary">Lihat Lokasi</a>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Proyek</th>
                    <th>Client</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Pimpinan Proyek</th>
                    <th>Keterangan</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($proyek)) : ?>
                    <?php foreach ($proyek as $key => $p) : ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo htmlspecialchars($p['namaProyek']); ?></td>
                            <td><?php echo htmlspecialchars($p['client']); ?></td>
                            <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($p['tglMulai']))); ?></td>
                            <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($p['tglSelesai']))); ?></td>
                            <td><?php echo htmlspecialchars($p['pimpinanProyek']); ?></td>
                            <td><?php echo htmlspecialchars($p['keterangan']); ?></td>
                            <td>
                                <?php if (!empty($p['lokasiSet'])) : ?>
                                    <?php foreach ($p['lokasiSet'] as $lokasi) : ?>
                                        <div>
                                            <?php echo htmlspecialchars($lokasi['namaLokasi']); ?>,
                                            <?php echo htmlspecialchars($lokasi['kota']); ?>,
                                            <?php echo htmlspecialchars($lokasi['provinsi']); ?>,
                                            <?php echo htmlspecialchars($lokasi['negara']); ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    Tidak ada lokasi
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo site_url('proyek/edit/' . $p['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?php echo site_url('proyek/delete/' . $p['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data proyek</td>
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