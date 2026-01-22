<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

include 'tiketcontroller.php';

$method = $_SERVER['REQUEST_METHOD'];
$response = [];

// Inisialisasi Object dari Class Tiket
$tkt = new tiket();

switch ($method) {
    case 'GET':
        // Menampilkan Semua Data
        $result = $tiketCtrl->tampilkanSemua();
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        echo json_encode(["status" => "success", "data" => $data]);
        break;

    case 'POST':
        // Menambah Data (Input JSON)
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['nama_event'])) {
            $tkt->nama_event = $input['nama_event'];
            if ($tiketCtrl->tambah($tkt)) {
                echo json_encode(["message" => "Tiket berhasil ditambahkan"]);
            }
        }
        break;

    case 'PUT':
        // Update Data (Input JSON)
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['id_tiket']) && isset($input['nama_event'])) {
            $tkt->id_tiket = $input['id_tiket'];
            $tkt->nama_event = $input['nama_event'];
            if ($tiketCtrl->update($tkt)) {
                echo json_encode(["message" => "Tiket berhasil diperbarui"]);
            }
        }
        break;

    case 'DELETE':
        // Hapus Data (Mengambil ID dari Parameter URL)
        if (isset($_GET['id'])) {
            $tkt->id_tiket = $_GET['id'];
            if ($tiketCtrl->hapus($tkt)) {
                echo json_encode(["message" => "Tiket berhasil dihapus"]);
            }
        }
        break;

    default:
        echo json_encode(["message" => "Metode Tidak Dikenal"]);
        break;
}
?>