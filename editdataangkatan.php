<?php
include 'header.php';
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    // ambil data dari masing masing form
    $nama_angkatan = htmlentities(strip_tags(strtoupper($_POST['nama_angkatan'])));
    $biaya_spp = htmlentities(strip_tags(strtoupper($_POST['biaya_spp'])));

    // validasi
    $sql = "SELECT * FROM angkatan WHERE nama_angkatan ='$nama_angkatan'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Data angkatan sudah ada')
                    document.location = 'editdataangkatan.php';
                </script>";
    } else {
        //proses simpan
        $query = "INSERT INTO angkatan (nama_angkatan, biaya) VALUES ('$nama_angkatan', '$biaya_spp')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>alert('Data angkatan berhasil disimpan!')
                        document.location = 'editdataangkatan.php';
                    </script>";
        } else {
            echo "<script>alert('Data angkatan gagal disimpan!')
                        document.location = 'editdataangkatan.php';
                    </script>";
        }
    }
}

if (isset($_POST['edit'])) {
    // ambil data dari masing masing form
    $id_angkatan = $_POST['id_angkatan'];
    $nama_angkatan = htmlentities(strip_tags(strtoupper($_POST['nama_angkatan'])));
    $biaya_spp = htmlentities(strip_tags(strtoupper($_POST['biaya_spp'])));
    //proses simpan
    $query = "UPDATE angkatan SET nama_angkatan = '$nama_angkatan', biaya = '$biaya_spp' WHERE id_angkatan = '$id_angkatan'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<script>alert('Data angkatan berhasil diubah!')
                        document.location = 'editdataangkatan.php';
                    </script>";
    } else {
        echo "<script>alert('Data angkatan gagal diubah!')
                        document.location = 'editdataangkatan.php';
                    </script>";
    }
}

if (isset($_GET['id_angkatan'])) {
    $id_angkatan = $_GET['id_angkatan'];
    $query = mysqli_query($conn, "DELETE FROM angkatan WHERE id_angkatan = '$id_angkatan'");
    if ($query) {
        echo "<script>alert('Data angkatan berhasil dihapus!')
                    document.location = 'editdataangkatan.php';
                </script>";
    } else {
        echo "<script>alert('Data angkatan gagal dihapus!')
                    document.location = 'editdataangkatan.php';
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
        <h6 class="m-0 font-weight-bold text-primary">Tabel Angkatan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Angkatan</th>
                        <th>Biaya SPP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
                $number = 1;
                $query = "SELECT * FROM angkatan";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) :
                ?>
                    <tbody>
                        <tr>
                            <td><?= $number++ ?></td>
                            <td><?= $row['nama_angkatan'] ?></td>
                            <td><?= $row['biaya'] ?></td>
                            <td>
                                <a href="#" class="view_data btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" id="<?= $row['id_angkatan'] ?>">Edit</a>
                                <a href="editdataangkatan.php?id_angkatan=<?= $row['id_angkatan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah yakin ingin menghapus data?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Data angkatan-->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data angkatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="text" name="nama_angkatan" placeholder="Nama angkatan" class="form-control mb-3">
                    <input type="text" name="biaya_spp" placeholder="Biaya SPP" class="form-control mb-3">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Data angkatan-->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data angkatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body" id="dataangkatan">

            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>

<script>
    $('.view_data').click(function() {
        var id_angkatan = $(this).attr('id');
        $.ajax({
            url: "view.php",
            method: "POST",
            data: {
                id_angkatan: id_angkatan
            },
            success: function(data) {
                $('#dataangkatan').html(data)
                $('#editModal').modal('show');
            }
        })
    })
</script>