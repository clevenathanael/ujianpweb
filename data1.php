<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web CRUD</title>
</head>
<body>

<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "ujian";

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi Gagal: " . $koneksi->connect_error);
}

// Fungsi Create (Tambah Data)
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $npm = $_POST['npm'];
    $kelas = $_POST['kelas'];

    $sql_tambah = "INSERT INTO data_mahasiswa(nama, npm, kelas) VALUES ('$nama', '$npm', '$kelas')";
    $result_tambah = $koneksi->query($sql_tambah);
}

// Fungsi Read (Baca Data)
$sql_baca = "SELECT * FROM data_mahasiswa";
$result_baca = $koneksi->query($sql_baca);

if ($result_baca->num_rows > 0) {
    echo "<h2>Data:</h2>";
    echo "<ul>";
    while ($row = $result_baca->fetch_assoc()) {
        echo "<li>" . $row["nama"] . " - " . $row["npm"] . " - " . $row["kelas"] . " <a href='?edit=" . $row["id"] . "'>Edit</a> | <a href='?hapus=" . $row["id"] . "'>Hapus</a></li>";
    }
    echo "</ul>";
} else {
    echo "Tidak ada data.";
}

// Fungsi Update (Edit Data)
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $sql_edit = "SELECT * FROM data_mahasiswa WHERE id=$id_edit";
    $result_edit = $koneksi->query($sql_edit);

    if ($result_edit->num_rows > 0) {
        $data_edit = $result_edit->fetch_assoc();
        echo "<h2>Edit Data:</h2>";
        echo "<form action='' method='post'>";
        echo "Nama: <input type='text' name='nama' value='" . $data_edit['nama'] . "'><br>";
        echo "NPM: <input type='text' name='npm' value='" . $data_edit['npm'] . "'><br>";
        echo "Kelas: <input type='text' name='kelas' value='" . $data_edit['kelas'] . "'><br>";
        echo "<input type='hidden' name='id_edit' value='$id_edit'>";
        echo "<input type='submit' name='simpan_edit' value='Simpan'>";
        echo "</form>";
    }
}

if (isset($_POST['simpan_edit'])) {
    $id_edit = $_POST['id_edit'];
    $nama_edit = $_POST['nama'];
    $npm_edit = $_POST['npm'];
    $kelas_edit = $_POST['kelas'];

    $sql_simpan_edit = "UPDATE data_mahasiswa SET nama='$nama_edit', npm='$npm_edit', kelas='$kelas_edit' WHERE id=$id_edit";
    $result_simpan_edit = $koneksi->query($sql_simpan_edit);
}

// Fungsi Delete (Hapus Data)
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    $sql_hapus = "DELETE FROM data_mahasiswa WHERE id=$id_hapus";
    $result_hapus = $koneksi->query($sql_hapus);
}

$koneksi->close();
?>

<h2>Tambah Data:</h2>
<form action="" method="post">
    Nama: <input type="text" name="nama" required><br>
    NPM: <input type="text" name="npm" required><br>
    Kelas: <input type="text" name="kelas" required><br>
    <input type="submit" name="tambah" value="Tambah">
</form>

</body>
</html>
