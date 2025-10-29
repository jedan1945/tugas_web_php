<?php
include 'db.php';
$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Mahasiswa</title>
</head>
<body>
<h2>Detail Mahasiswa</h2>
<p><b>ID:</b> <?= $data['id'] ?></p>
<p><b>Nama:</b> <?= htmlspecialchars($data['nama']) ?></p>
<p><b>Jurusan:</b> <?= htmlspecialchars($data['jurusan']) ?></p>
<p><b>Dibuat:</b> <?= $data['created_at'] ?></p>

<a href="index.php">Kembali</a>
</body>
</html>
