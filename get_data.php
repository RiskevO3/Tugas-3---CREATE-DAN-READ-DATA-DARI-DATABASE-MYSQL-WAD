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

// Latihan 2: Buatkan saya get endpoint untuk mengambil data
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $sql = "SELECT * FROM todolist_table";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (PDOException $e) {
        echo json_encode(['message' => 'Error: ' . $e->getMessage(),'status' => false]);
    }
}
$conn=null;
?>