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
// Latihan 6: Buatkan saya post endpoint untuk menghapus data berdasarkan id
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->id)) {
        try{
            $id = $data->id;
            $sql = "DELETE FROM todolist_table WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                echo json_encode(['message' => 'Data berhasil dihapus','status' => true]);
            } else {
                echo json_encode(['message' => 'Gagal menghapus data','status' => false]);
            }
        }
        catch (PDOException $e) {
            echo json_encode(['message' => 'Error: ' . $e->getMessage(),'status' => false]);
        }
    } else {
        echo json_encode(['message' => 'Parameter kurang','status' => false]);
    }
}
mysqli_close($mysqli);
?>