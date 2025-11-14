<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'testdb';

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$search_nama = isset($_GET['nama']) ? $_GET['nama'] : '';
$search_alamat = isset($_GET['alamat']) ? $_GET['alamat'] : '';

$sql = "
    SELECT 
        MIN(p.id) as id,
        p.nama, 
        p.alamat, 
        GROUP_CONCAT(DISTINCT h.hobi SEPARATOR ', ') AS daftar_hobi 
    FROM 
        person p
    LEFT JOIN 
        hobi h ON p.id = h.person_id
    WHERE 1
";

if (!empty($search_nama)) {
    $sql .= " AND p.nama LIKE '%" . $conn->real_escape_string($search_nama) . "%'";
}

if (!empty($search_alamat)) {
    $sql .= " AND p.alamat LIKE '%" . $conn->real_escape_string($search_alamat) . "%'";
}

$sql .= " GROUP BY p.nama, p.alamat ORDER BY MIN(p.id) ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        table { border-collapse: collapse;margin-bottom: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        .search-container { border: 1px solid black; padding: 20px; width: 300px; }
        .search-container label, .search-container input { display: block; margin-bottom: 10px; }
        .search-container input[type="submit"] { margin-top: 20px; padding: 8px 15px; cursor: pointer; }
        .input-group { display: flex; align-items: center; margin-bottom: 10px; }
        .input-group label { width: 80px; }
        .input-group input[type="text"] { flex-grow: 1; padding: 5px; }
    </style>
</head>
<body>

<table border="1">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Hobi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nama"] . "</td>";
                echo "<td>" . $row["alamat"] . "</td>";
                echo "<td>" . $row["daftar_hobi"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Data tidak ditemukan</td></tr>";
        }
        ?>
    </tbody>
</table>

<div class="search-container">
    <form method="GET" action="soal3.php">
        <div class="input-group">
            <label for="nama">Nama :</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($search_nama); ?>">
        </div>
        <div class="input-group">
            <label for="alamat">Alamat :</label>
            <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($search_alamat); ?>">
        </div>
        
        <input type="submit" value="SEARCH">
    </form>
</div>

<?php
$conn->close();
?>

</body>
</html>