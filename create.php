<?php
include 'db.php';

$nama = $jurusan = "";
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $jurusan = trim($_POST['jurusan']);

    if (empty($nama) || empty($jurusan)) {
        $error = "Semua field wajib diisi!";
    } else {
        $stmt = $conn->prepare("INSERT INTO mahasiswa (nama, jurusan) VALUES (?, ?)");
        $stmt->bind_param("ss", $nama, $jurusan);
        if ($stmt->execute()) {
            $success = "Data berhasil ditambahkan!";
            $nama = $jurusan = "";
        } else {
            $error = "Gagal menambahkan data.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Mahasiswa</title>
</head>
<body>
<h2>Tambah Mahasiswa</h2>

<form method="POST">
    <label>Nama:</label><br>
    <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>"><br>
    <label>Jurusan:</label><br>
    <input type="text" name="jurusan" value="<?= htmlspecialchars($jurusan) ?>"><br><br>
    <button type="submit">Simpan</button>
</form>

<p style="color:green"><?= $success ?></p>
<p style="color:red"><?= $error ?></p>
<a href="index.php">Kembali</a>
</body>
</html>
