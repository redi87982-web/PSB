<?php
$api_url = "http://localhost/PSB/tiketApi.php"; // Sesuaikan dengan folder Anda

// --- LOGIKA PROSES FORM ---
if (isset($_POST['aksi'])) {
    $data = [
        'id_tiket'   => $_POST['id_tiket'] ?? null,
        'nama_event' => $_POST['nama_event'] ?? ''
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    if ($_POST['aksi'] == 'tambah') {
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    } 
    elseif ($_POST['aksi'] == 'update') {
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    curl_exec($ch);
    curl_close($ch);
    header("Location: index.php"); // Refresh halaman
}

// --- LOGIKA HAPUS ---
if (isset($_GET['hapus'])) {
    $ch = curl_init($api_url . "?id=" . $_GET['hapus']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    header("Location: index.php");
}

// --- AMBIL DATA DARI API (GET) ---
$json_data = file_get_contents($api_url);
$response = json_decode($json_data, true);
$list_tiket = $response['data'] ?? [];

// --- LOGIKA EDIT (MENGISI FORM) ---
$edit_id = "";
$edit_nama = "";
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_nama = $_GET['nama'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>e-TixPRO | PHP CRUD API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Manajemen Tiket (PHP via API)</h2>

    <div class="card p-4 mb-4 shadow-sm">
        <form method="POST">
            <input type="hidden" name="id_tiket" value="<?= $edit_id ?>">
            <div class="row g-3">
                <div class="col-md-8">
                    <input type="text" name="nama_event" class="form-control" placeholder="Nama Event" value="<?= $edit_nama ?>" required>
                </div>
                <div class="col-md-4">
                    <?php if ($edit_id): ?>
                        <button type="submit" name="aksi" value="update" class="btn btn-warning w-100">Update</button>
                        <a href="index.php" class="btn btn-secondary w-100 mt-2">Batal</a>
                    <?php else: ?>
                        <button type="submit" name="aksi" value="tambah" class="btn btn-primary w-100">Tambah</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <table class="table table-striped table-hover bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Event</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list_tiket as $tkt): ?>
            <tr>
                <td><?= $tkt['id'] ?></td>
                <td><?= $tkt['nama_event'] ?></td>
                <td>
                    <a href="?edit=<?= $tkt['id'] ?>&nama=<?= $tkt['nama_event'] ?>" class="btn btn-sm btn-info">Edit</a>
                    <a href="?hapus=<?= $tkt['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>