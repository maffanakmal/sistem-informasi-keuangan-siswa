<?php
include 'header.php';
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    // ambil data dari masing masing form
    $nama_jurusan = htmlentities(strip_tags(strtoupper($_POST['nama_jurusan'])));

    // validasi
    $sql = "SELECT * FROM jurusan WHERE nama_jurusan ='$nama_jurusan'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Data jurusan sudah ada')
                    document.location = 'editdatajurusan.php';
                </script>";
    } else {
        //proses simpan
        $query = "INSERT INTO jurusan (nama_jurusan) VALUES ('$nama_jurusan')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>alert('Data jurusan berhasil disimpan!')
                        document.location = 'editdatajurusan.php';
                    </script>";
        } else {
            echo "<script>alert('Data jurusan gagal disimpan!')
                        document.location = 'editdatajurusan.php';
                    </script>";
        }
    }
}

if (isset($_POST['edit'])) {
    // ambil data dari masing masing form
    $id_jurusan = $_POST['id_jurusan'];
    $nama_jurusan = htmlentities(strip_tags(strtoupper($_POST['nama_jurusan'])));
    //proses simpan
    $query = "UPDATE jurusan SET nama_jurusan = '$nama_jurusan' WHERE id_jurusan = '$id_jurusan'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<script>alert('Data jurusan berhasil diubah!')
                        document.location = 'editdatajurusan.php';
                    </script>";
    } else {
        echo "<script>alert('Data jurusan gagal diubah!')
                        document.location = 'editdatajurusan.php';
                    </script>";
    }
}

if (isset($_GET['id_jurusan'])) {
    $id_jurusan = $_GET['id_jurusan'];
    $query = mysqli_query($conn, "DELETE FROM jurusan WHERE id_jurusan = '$id_jurusan'");
    if ($query) {
        echo "<script>alert('Data jurusan berhasil dihapus!')
                    document.location = 'editdatajurusan.php';
                </script>";
    } else {
        echo "<script>alert('Data jurusan gagal dihapus!')
                    document.location = 'editdatajurusan.php';
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
        <h6 class="m-0 font-weight-bold text-primary">Tabel Jurusan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
                $number = 1;
                $query = "SELECT * FROM jurusan";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) :
                ?>
                    <tbody>
                        <tr>
                            <td><?= $number++ ?></td>
                            <td><?= $row['nama_jurusan'] ?></td>
                            <td>
                                <a href="#" class="view_data btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" id="<?= $row['id_jurusan'] ?>">Edit</a>
                                <a href="editdatajurusan.php?id_jurusan=<?= $row['id_jurusan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah yakin ingin menghapus data?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Data Jurusan-->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Jurusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="text" name="nama_jurusan" placeholder="Nama Jurusan" class="form-control mb-3">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Data Jurusan-->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Jurusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body" id="datajurusan">

            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>

<script>
    $('.view_data').click(function() {
        var id_jurusan = $(this).attr('id');
        $.ajax({
            url: "view.php",
            method: "POST",
            data: {
                id_jurusan: id_jurusan
            },
            success: function(data) {
                $('#datajurusan').html(data)
                $('#editModal').modal('show');
            }
        })
    })
</script>