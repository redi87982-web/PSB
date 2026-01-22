<?php
include 'koneksi.php';
include 'tiket.php';


class TiketController {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    // 1. CREATE: Mengambil nama_event dari object
    public function tambah(tiket $obj) {
        $query = "INSERT INTO tiket (nama_event) VALUES ('$obj->nama_event')";
        return mysqli_query($this->db, $query);
    }

    // 2. READ: Mengambil semua data
    public function tampilkanSemua() {
        $query = "SELECT * FROM tiket";
        return mysqli_query($this->db, $query);
    }

    // 3. UPDATE: Mengupdate nama_event berdasarkan id_tiket dari object
    public function update(tiket $obj) {
        $query = "UPDATE tiket SET nama_event = '$obj->nama_event' WHERE id = '$obj->id_tiket'";
        return mysqli_query($this->db, $query);
    }

    // 4. DELETE: Menghapus berdasarkan id_tiket dari object
    public function hapus(tiket $obj) {
        $query = "DELETE FROM tiket WHERE id = '$obj->id_tiket'";
        return mysqli_query($this->db, $query);
    }
}

// Inisialisasi Controller
$tiketCtrl = new TiketController($conn);
?>