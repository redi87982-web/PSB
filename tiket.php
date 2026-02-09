<?php

class Tiket {
    // Properti harus memiliki nama yang jelas
    public $id_tiket;
    public $nama_event;
    public $harga; // Contoh penambahan properti yang benar

    // Tambahkan constructor jika diperlukan untuk inisialisasi data
    public function __construct($id, $event) {
        $this->id_tiket = $id;
        $this->nama_event = $event;
    }
}