<?php
include 'header.php';
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    // ambil data dari masing masing form
    $nama_kelas = htmlentities(strip_tags(strtoupper($_POST['nama_kelas'])));

    // validasi
    $sql = "SELECT * FROM kelas WHERE nama_kelas ='$nama_kelas'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Data kelas sudah ada')
                    document.location = 'editdatakelas.php';
                </script>";
    } else {
        //proses simpan
        $query = "INSERT INTO kelas (nama_kelas) VALUES ('$nama_kelas')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>alert('Data kelas berhasil disimpan!')
                        document.location = 'editdatakelas.php';
                    </script>";
        } else {
            echo "<script>alert('Data kelas gagal disimpan!')
                        document.location = 'editdatakelas.php';
                    </script>";
        }
    }
}

if (isset($_POST['edit'])) {
    // ambil data dari masing masing form
    $id_kelas = $_POST['id_kelas'];
    $nama_kelas = htmlentities(strip_tags(strtoupper($_POST['nama_kelas'])));

    // validasi
    $sql = "SELECT * FROM kelas WHERE nama_kelas='$nama_kelas'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        echo "<script>alert('Data kelas sudah ada')
                    document.location = 'editdatakelas.php';
                </script>";
    } else {
        //proses simpan
        $query = "UPDATE kelas SET nama_kelas = '$nama_kelas' WHERE id_kelas = '$id_kelas'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>alert('Data kelas berhasil diubah!')
                        document.location = 'editdatakelas.php';
                    </script>";
        } else {
            echo "<script>alert('Data kelas gagal diubah!')
                        document.location = 'editdatakelas.php';
                    </script>";
        }
    }
}

if (isset($_GET['id_kelas'])) {
    $id_kelas = $_GET['id_kelas'];
    $query = mysqli_query($conn, "DELETE FROM kelas WHERE id_kelas = '$id_kelas'");
    if ($query) {
        echo "<script>alert('Data kelas berhasil dihapus!')
                    document.location = 'editdatakelas.php';
                </script>";
    } else {
        echo "<script>alert('Data kelas gagal dihapus!')
                    document.location = 'editdatakelas.php';
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
        <h6 class="m-0 font-weight-bold text-primary">Tabel Kelas</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
                $number = 1;
                $query = "SELECT * FROM kelas";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) :
                ?>
                    <tbody>
                        <tr>
                            <td><?= $number++ ?></td>
                            <td><?= $row['nama_kelas'] ?></td>
                            <td>
                                <a href="#" class="view_data btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" id="<?= $row['id_kelas'] ?>">Edit</a>
                                <a href="editdatakelas.php?id_kelas=<?= $row['id_kelas'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah yakin ingin menghapus data?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Data Kelas-->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="text" name="nama_kelas" placeholder="Nama Kelas" class="form-control mb-3">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Data Kelas-->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body" id="datakelas">
                
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>

<script>
    $('.view_data').click(function() {
        var id_kelas = $(this).attr('id');
        $.ajax({
            url: "view.php",
            method: "POST",
            data: {
                id_kelas: id_kelas
            },
            success: function(data) {
                $('#datakelas').html(data)
                $('#editModal').modal('show');
            }
        })
    })
</script>