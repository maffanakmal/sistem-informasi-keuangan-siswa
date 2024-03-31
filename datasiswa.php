<?php
include 'header.php';
include 'koneksi.php';
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Angkatan</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <?php 
                    $number = 1;
                    $query = "SELECT siswa.*, angkatan.*, jurusan.*, kelas.* 
                                FROM siswa, angkatan, jurusan, kelas 
                                WHERE siswa.id_angkatan = angkatan.id_angkatan
                                AND siswa.id_jurusan = jurusan.id_jurusan
                                AND siswa.id_kelas = kelas.id_kelas ORDER BY id_siswa";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)):
                ?>
                <tbody>
                    <tr>
                        <td><?= $number++ ?></td>
                        <td><?= $row['nisn'] ?></td>
                        <td><?= $row['nama_siswa'] ?></td>
                        <td><?= $row['nama_angkatan'] ?></td>
                        <td><?= $row['nama_kelas'] ?></td>
                        <td><?= $row['nama_jurusan'] ?></td>
                        <td><?= $row['alamat'] ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <?php
    include 'footer.php';
    ?>