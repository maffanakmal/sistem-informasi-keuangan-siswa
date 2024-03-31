<?php
include 'koneksi.php';

if (isset($_POST['id_siswa'])) {
    $id_siswa = $_POST['id_siswa'];
    $query = "SELECT siswa.*, angkatan.*, jurusan.*, kelas.* 
                    FROM siswa, angkatan, jurusan, kelas 
                    WHERE siswa.id_angkatan = angkatan.id_angkatan
                    AND siswa.id_jurusan = jurusan.id_jurusan
                    AND siswa.id_kelas = kelas.id_kelas 
                    AND siswa.id_siswa = $id_siswa";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
?>

    <form action="editdatasiswa.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_siswa" value="<?= $row['id_siswa'] ?>">
        <input type="hidden" name="nisn" value="<?= $row['nisn'] ?>">
        <input type="text" class="form-control mb-3" name="" disabled="" value="<?= $row['nisn'] ?>">
        <input type="text" class="form-control mb-3" name="nama_siswa" value="<?= $row['nama_siswa'] ?>">
        <select class="form-control mb-3" name="id_angkatan">
            <option selected>-- Pilih Angkatan --</option>
            <?php
            $selected = "";
            $query = mysqli_query($conn, "SELECT * FROM angkatan ORDER BY id_angkatan");
            while ($angkatan = mysqli_fetch_assoc($query)) :
                if ($row['id_angkatan'] == $angkatan['id_angkatan']) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                echo "<option $selected value=" . $angkatan['id_angkatan'] . ">" . $angkatan['nama_angkatan'] . "</option>";
            endwhile;
            ?>
        </select>

        <select class="form-control mb-3" name="id_kelas">
            <option selected>-- Pilih Kelas --</option>
            <?php
            $selected = "";
            $query = mysqli_query($conn, "SELECT * FROM kelas ORDER BY id_kelas");
            while ($kelas = mysqli_fetch_assoc($query)) :
                if ($row['id_kelas'] == $kelas['id_kelas']) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                echo "<option $selected value=" . $kelas['id_kelas'] . ">" . $kelas['nama_kelas'] . "</option>";
            endwhile;
            ?>
        </select>

        <select class="form-control mb-3" name="id_jurusan">
            <option selected>-- Pilih Jurusan --</option>
            <?php
            $selected = "";
            $query = mysqli_query($conn, "SELECT * FROM jurusan ORDER BY id_jurusan");
            while ($jurusan = mysqli_fetch_assoc($query)) :
                if ($row['id_jurusan'] == $jurusan['id_jurusan']) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                echo "<option $selected value=" . $jurusan['id_jurusan'] . ">" . $jurusan['nama_jurusan'] . "</option>";
            endwhile;
            ?>
        </select>

        <textarea class="form-control" name="alamat" placeholder="Alamat Siswa"><?= $row['alamat'] ?></textarea>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="Submit" name="edit" class="btn btn-primary">Simpan</button>
        </div>

    </form>
<?php } ?>

<?php
if (isset($_POST['id_kelas'])) {
    $id_kelas = $_POST['id_kelas'];
    $query = mysqli_query($conn, "SELECT * FROM kelas WHERE id_kelas = '$id_kelas'");
    $row = mysqli_fetch_assoc($query);
?>
    <form action="editdatakelas.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_kelas" value="<?= $row['id_kelas'] ?>">
        <input type="text" class="form-control mb-3" name="nama_kelas" value="<?= $row['nama_kelas'] ?>">
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="Submit" name="edit" class="btn btn-primary">Simpan</button>
        </div>

    <?php } ?>

    <?php
    if (isset($_POST['id_jurusan'])) {
        $id_jurusan = $_POST['id_jurusan'];
        $query = mysqli_query($conn, "SELECT * FROM jurusan WHERE id_jurusan = '$id_jurusan'");
        $row = mysqli_fetch_assoc($query);
    ?>
        <form action="editdatajurusan.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_jurusan" value="<?= $row['id_jurusan'] ?>">
            <input type="text" class="form-control mb-3" name="nama_jurusan" value="<?= $row['nama_jurusan'] ?>">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="Submit" name="edit" class="btn btn-primary">Simpan</button>
            </div>

        <?php } ?>

        <?php
        if (isset($_POST['id_angkatan'])) {
            $id_angkatan = $_POST['id_angkatan'];
            $query = mysqli_query($conn, "SELECT * FROM angkatan WHERE id_angkatan = '$id_angkatan'");
            $row = mysqli_fetch_assoc($query);
        ?>
            <form action="editdataangkatan.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_angkatan" value="<?= $row['id_angkatan'] ?>">
                <input type="text" class="form-control mb-3" name="nama_angkatan" value="<?= $row['nama_angkatan'] ?>">
                <input type="text" class="form-control mb-3" name="biaya_spp" value="<?= $row['biaya'] ?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="Submit" name="edit" class="btn btn-primary">Simpan</button>
                </div>

            <?php } ?>