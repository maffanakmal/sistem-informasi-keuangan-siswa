<?php
include 'header.php';
include 'koneksi.php';
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="" method="GET">
            <table class="table">
                <tr>
                    <td>NISN</td>
                    <td>:</td>
                    <td><input type="text" name="nisn" placeholder="Masukkan NISN Siswa" class="form-control"></td>
                    <td><button type="submit" class="btn btn-primary" name="cari">Search</button></td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
    if (isset($_GET['nisn']) && $_GET['nisn'] != ''){
        $nisn = $_GET['nisn'];
        $query = "SELECT siswa.*, angkatan.*, jurusan.*, kelas.* FROM siswa, angkatan, jurusan, kelas
                    WHERE siswa.id_angkatan = angkatan.id_angkatan AND siswa.id_jurusan = jurusan.id_jurusan
                    AND siswa.id_kelas = kelas.id_kelas AND siswa.nisn = '$nisn'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $id_siswa = $row['id_siswa'];
        $nisn = $row['nisn'];
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Biodata Siswa</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tr>
                        <td>NISN</td>
                        <td><?= $row['nisn'] ?></td>
                    </tr>
                    <tr>
                        <td>Nama Siswa</td>
                        <td><?= $row['nama_siswa'] ?></td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td><?= $row['nama_kelas'] ?></td>
                    </tr>
                    <tr>
                        <td>Tahun ajaran</td>
                        <td><?= $row['nama_angkatan'] ?></td>
                    </tr>
            </table>
        </div>
    </div>
</div>

<di class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data pembayaran</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Jatuh Tempo</th>
                        <th>No Bayar</th>
                        <th>Tanggal Bayar</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
                $number = 1;
                $query = "SELECT * FROM pembayaran WHERE id_siswa = '$id_siswa' ORDER BY jatuh_tempo ASC";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) :
                ?>
                    <tbody>
                        <tr>
                            <td><?= $number++ ?></td>
                            <td><?= $row['bulan'] ?></td>
                            <td><?= $row['jatuh_tempo'] ?></td>
                            <td><?= $row['no_bayar'] ?></td>
                            <td><?= $row['tgl_bayar'] ?></td>
                            <td><?= $row['jumlah_bayar'] ?></td>
                            <td><?= $row['keterangan'] ?></td>
                            <td>
                                <?php
                                    if ($row['no_bayar'] == ''){
                                        echo "<a href='contoh.php?nisn=$nisn&act=bayar&id=$row[id_spp]'></a>";
                                        echo "<a class='btn btn-primary btn-sm' href='contoh.php?nisn=$nisn&act=bayar&id=$row[id_spp]'>Bayar</a>";
                                    } else {
                                        echo "</a>";
                                        echo "<a class='btn btn-danger btn-sm' href='contoh.php?nisn=$nisn&act=batal&id=$row[id_spp]'>Batal</a>";
                                        echo "<a class='btn btn-success btn-sm' href='cetak_slip_transaksi.php?nisn=$nisn&act=bayar&id=$row[id_spp]' target='_blank'>Cetak</a>";
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
            </table>
        </div>
    </div>
<?php } ?>
<?php
include 'footer.php';
?>