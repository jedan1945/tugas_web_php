<?php
include 'db.php';

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Pencarian
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : "";
$where = "";
if (!empty($keyword)) {
    $where = "WHERE nama LIKE ?";
}

// Hitung total data
if ($where) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM mahasiswa $where");
    $param = "%$keyword%";
    $stmt->bind_param("s", $param);
} else {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM mahasiswa");
}
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

$pages = ceil($total / $limit);

// Ambil data
if ($where) {
    $stmt = $conn->prepare("SELECT * FROM mahasiswa $where ORDER BY created_at DESC LIMIT ?, ?");
    $stmt->bind_param("sii", $param, $start, $limit);
} else {
    $stmt = $conn->prepare("SELECT * FROM mahasiswa ORDER BY created_at DESC LIMIT ?, ?");
    $stmt->bind_param("ii", $start, $limit);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Daftar Mahasiswa</h2>

<form method="GET">
    <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari nama...">
    <button type="submit">Cari</button>
</form>

<a href="create.php">+ Tambah Data</a>

<table border="1" cellpadding="8" cellspacing="0">
    <tr style="background:#ddd;">
        <th>ID</th>
        <th>Nama</th>
        <th>Jurusan</th>
        <th>Dibuat</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= htmlspecialchars($row['jurusan']) ?></td>
        <td><?= $row['created_at'] ?></td>
        <td>
            <a href="detail.php?id=<?= $row['id'] ?>">Detail</a> |
            <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin hapus data ini?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- Pagination -->
<div style="margin-top:10px;">
<?php for ($i = 1; $i <= $pages; $i++): ?>
    <a href="?page=<?= $i ?>&keyword=<?= urlencode($keyword) ?>" 
       style="margin-right:5px; <?= ($i == $page) ? 'font-weight:bold;' : '' ?>">
       <?= $i ?>
    </a>
<?php endfor; ?>
</div>

</body>
</html>
