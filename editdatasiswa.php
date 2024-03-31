<?php
include 'header.php';
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    // ambil data dari masing masing form
    $nisn = htmlentities(strip_tags($_POST['nisn']));
    $nama_siswa = htmlentities(strip_tags(ucwords($_POST['nama_siswa'])));
    $id_kelas = htmlentities(strip_tags($_POST['id_kelas']));
    $id_jurusan = htmlentities(strip_tags($_POST['id_jurusan']));
    $id_angkatan = htmlentities(strip_tags($_POST['id_angkatan']));
    $alamat = htmlentities(strip_tags($_POST['alamat']));

    // validasi
    $sql = "SELECT * FROM siswa WHERE nisn='$nisn' OR nama_siswa='$nama_siswa'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Data siswa sudah ada')
                    document.location = 'editdatasiswa.php';
                </script>";
    } else {
        //proses simpan
        $query = "INSERT INTO siswa (nisn, nama_siswa, id_angkatan, id_jurusan, id_kelas, alamat) 
                VALUES ('$nisn', '$nama_siswa', '$id_angkatan', '$id_jurusan', '$id_kelas', '$alamat')";
        $result = mysqli_query($conn, $query);
        if ($result) {

            $bulanIndo = [
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember'
            ];

            $query = "SELECT siswa.*, angkatan.* FROM siswa, angkatan 
                        WHERE siswa.id_angkatan = angkatan.id_angkatan
                        ORDER BY siswa.id_siswa DESC LIMIT 1";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            
            $biaya = $row['biaya'];
            $id_siswa = $row['id_siswa'];
            $awalTempo = date('Y-m-d');
            
            for ($i = 0; $i < 36; $i++){
                // tanggal jatuh tempo setiap tanggal 10
                $jatuhTempo = date("Y-m-d", strtotime("+$i month", strtotime($awalTempo)));
                $bulan = $bulanIndo[date('m', strtotime($jatuhTempo))]." ".date('Y', strtotime($jatuhTempo));
                
                //simpan data
                $tambah = mysqli_query($conn, "INSERT INTO pembayaran (id_siswa, jatuh_tempo, bulan, jumlah_bayar)
                                                VALUES ('$id_siswa', '$jatuhTempo', '$bulan', '$biaya')");
            }

            echo "<script>alert('Data siswa berhasil disimpan!')
                        document.location = 'editdatasiswa.php';
                    </script>";
        } else {
            echo "<script>alert('Data siswa gagal disimpan!')
                        document.location = 'editdatasiswa.php';
                    </script>";
        }
    }
}

if (isset($_POST['edit'])){
    // ambil data dari masing masing form
    $id_siswa = $_POST['id_siswa'];
    $nisn = $_POST['nisn'];
    $nama_siswa = htmlentities(strip_tags(ucwords($_POST['nama_siswa'])));
    $id_kelas = htmlentities(strip_tags($_POST['id_kelas']));
    $id_jurusan = htmlentities(strip_tags($_POST['id_jurusan']));
    $id_angkatan = htmlentities(strip_tags($_POST['id_angkatan']));
    $alamat = htmlentities(strip_tags($_POST['alamat']));

    // validasi
    $sql = "SELECT * FROM siswa WHERE nama_siswa='$nama_siswa'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        echo "<script>alert('Data siswa sudah ada')
                    document.location = 'editdatasiswa.php';
                </script>";
    } else {
        //proses simpan
        $query = "UPDATE siswa SET nisn = '$nisn', 
                                    nama_siswa = '$nama_siswa', 
                                    id_angkatan = '$id_angkatan', 
                                    id_jurusan = '$id_jurusan', 
                                    id_kelas = '$id_kelas', 
                                    alamat = '$alamat' WHERE id_siswa = '$id_siswa'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>alert('Data siswa berhasil diubah!')
                        document.location = 'editdatasiswa.php';
                    </script>";
        } else {
            echo "<script>alert('Data siswa gagal diubah!')
                        document.location = 'editdatasiswa.php';
                    </script>";
        }
    }
}

if (isset($_GET['id_siswa'])){
    $id_siswa = $_GET['id_siswa'];
    $query = mysqli_query($conn, "DELETE FROM siswa WHERE id_siswa = '$id_siswa'");
    if ($query){
        echo "<script>alert('Data siswa berhasil dihapus!')
                    document.location = 'editdatasiswa.php';
                </script>";
    } else {
        echo "<script>alert('Data siswa gagal dihapus!')
                    document.location = 'editdatasiswa.php';
                </script>";
    }
}

?>

<!-- button triger -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>
<!-- button triger -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tabel Siswa</h6>
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
                        <th>Aksi</th>
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
                while ($row = mysqli_fetch_assoc($result)) :
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
                            <td>
                                <a href="#" class="view_data btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" id="<?= $row['id_siswa'] ?>">Edit</a>
                                <a href="editdatasiswa.php?id_siswa=<?= $row['id_siswa'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah yakin ingin menghapus data?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Data Siswa-->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="text" name="nisn" placeholder="Nomor Induk Siswa Nasional" class="form-control mb-3">
                    <input type="text" name="nama_siswa" placeholder="Nama Siswa" class="form-control mb-3">
                    <select class="form-control mb-3" name="id_angkatan">
                        <option selected>-Pilih Angkatan-</option>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM angkatan ORDER BY id_angkatan");
                        while ($angkatan = mysqli_fetch_assoc($query)) :
                            echo "<option value=" . $angkatan['id_angkatan'] . ">" . $angkatan['nama_angkatan'] . "</option>";
                        endwhile;
                        ?>
                    </select>
                    <select class="form-control mb-3" name="id_kelas">
                        <option selected>-Pilih Kelas-</option>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM kelas ORDER BY id_kelas");
                        while ($kelas = mysqli_fetch_assoc($query)) :
                            echo "<option value=" . $kelas['id_kelas'] . ">" . $kelas['nama_kelas'] . "</option>";
                        endwhile;
                        ?>
                    </select>
                    <select class="form-control mb-3" name="id_jurusan">
                        <option selected>-Pilih jurusan-</option>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM jurusan ORDER BY id_jurusan");
                        while ($jurusan = mysqli_fetch_assoc($query)) :
                            echo "<option value=" . $jurusan['id_jurusan'] . ">" . $jurusan['nama_jurusan'] . "</option>";
                        endwhile;
                        ?>
                    </select>
                    <textarea class="form-control" name="alamat" placeholder="Alamat Siswa"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Data Siswa-->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body" id="datasiswa">
                

            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>

<script>
    $('.view_data').click(function(){
        var id_siswa = $(this).attr('id');
        $.ajax({
            url: "view.php",
            method: "POST",
            data: {id_siswa:id_siswa},
            success: function(data){
                $('#datasiswa').html(data)
                $('#editModal').modal('show');
            }
        })
    })
</script>