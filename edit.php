<?php
include 'db.php';
$id = (int)$_GET['id'];
$error = $success = "";

// Ambil data lama
$stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) die("Data tidak ditemukan!");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $jurusan = trim($_POST['jurusan']);
    if (empty($nama) || empty($jurusan)) {
        $error = "Semua field wajib diisi!";
    } else {
        $stmt = $conn->prepare("UPDATE mahasiswa SET nama=?, jurusan=? WHERE id=?");
        $stmt->bind_param("ssi", $nama, $jurusan, $id);
        if ($stmt->execute()) {
            $success = "Data berhasil diubah!";
            $data['nama'] = $nama;
            $data['jurusan'] = $jurusan;
        } else {
            $error = "Gagal mengubah data.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Mahasiswa</title>
</head>
<body>
<h2>Edit Mahasiswa</h2>
<form method="POST">
    Nama: <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>"><br>
    Jurusan: <input type="text" name="jurusan" value="<?= htmlspecialchars($data['jurusan']) ?>"><br><br>
    <button type="submit">Simpan</button>
</form>

<p style="color:green"><?= $success ?></p>
<p style="color:red"><?= $error ?></p>
<a href="index.php">Kembali</a>
</body>
</html>
