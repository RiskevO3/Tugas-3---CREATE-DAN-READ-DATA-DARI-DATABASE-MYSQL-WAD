<?php
// Latihan 1: Buatkan saya koneksi database menggunakan default mysql
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'todolist';
try {
    $conn = new PDO(
    "mysql:host=$host;dbname=$database;charset=utf8",
    $username,
    $password,
    array(PDO::ATTR_PERSISTENT => true));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e) {
    echo json_encode(['message' => "Koneksi database gagal: " . $e->getMessage(),'status' => false]);
}
// Latihan 4: Buatkan saya post endpoint untuk mengupdate data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->id) && (isset($data->nama_kegiatan) || isset($data->deskripsi_kegiatan))) {
        $id = $data->id;
        $nama_kegiatan = isset($data->nama_kegiatan) ? $data->nama_kegiatan : null;
        $deskripsi_kegiatan = isset($data->deskripsi_kegiatan) ? $data->deskripsi_kegiatan : null;
        try{
            if ($nama_kegiatan || $deskripsi_kegiatan) {
            $sql = "UPDATE todolist_table SET ";
            if ($nama_kegiatan) {
                $sql .= "title = :nama, ";
            }
            if ($deskripsi_kegiatan) {
                $sql .= "description = :deskripsi, ";
            }
            $sql = rtrim($sql, ", ");
            $sql .= " WHERE id = :id";

            $stmt = $conn->prepare($sql);

            if ($nama_kegiatan) {
                $stmt->bindParam(':nama', $nama_kegiatan);
            }
            if ($deskripsi_kegiatan) {
                $stmt->bindParam(':deskripsi', $deskripsi_kegiatan);
            }
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                echo json_encode(['message' => 'Data berhasil diupdate', 'status' => true]);
            } else {
                echo json_encode(['message' => 'Gagal mengupdate data', 'status' => false]);
            }
        } else {
            echo json_encode(['message' => 'Parameter kurang','status' => false]);
        }
        }catch (PDOException $e) {
            echo json_encode(['message' => 'Error: ' . $e->getMessage(),'status' => false]);
        }

    }
}
$conn=null;
?>