<?php
include 'connect.php';
include 'ultil.php';

$data = json_decode(file_get_contents('php://input'), true);

$idSinhVien = isset($data['idSinhVien']) ? $data['idSinhVien'] : null;
$schedules = isset($data['schedules']) ? $data['schedules'] : null;

$result = addSubjects($schedules, $idSinhVien);

echo $result;

$conn->close();
?>
