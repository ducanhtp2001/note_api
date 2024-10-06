<?php

include 'connect.php';
include 'model.php';

function getInfoAccount($idSinhVien)
{
    global $conn;

    $sql = "SELECT * FROM `thongtinsinhvien` WHERE id = $idSinhVien";

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $sinhVien = new SinhVien(
                $row['id'],
                $row['hoten'],
                $row['ngaysinh'],
                $row['gioitinh'],
                $row['quequan'],
                $row['gmail'],
                $row['sdt'],
                $row['khoa'],
                $row['nienkhoa'],
                $row['lop']
            );

            return $sinhVien;
        } else {
            return null;
        }
        return null;
    }
}

function getPostsByMaMonAndLopTinChi($maMon, $lopTinChi)
{
    global $conn;

    if ($maMon === null || $lopTinChi === null) {
        echo json_encode(['status' => false, 'message' => 'Thiếu mã môn hoặc lớp tín chỉ.']);
        return;
    }

    $sql = "SELECT * FROM post WHERE mamon = ? AND loptinchi = ?";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $maMon, $lopTinChi);
    $stmt->execute();
    $result = $stmt->get_result();

    $posts = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = [
                'id' => $row['id'],
                'idSinhVien' => $row['idsinhvien'],
                'thoiGian' => $row['thoigian'],
                'maMon' => $row['mamon'],
                'lopTinChi' => $row['loptinchi'],
                'noiDung' => $row['noidung'],
                'coImg' => $row['coimg'],
                'img' => $row['img']
            ];
        }

        return $posts;
    } else {
        return null;
    }

    echo json_encode($response);
}

function getMessagesByIdPost($idPost)
{
    global $conn;

    // Kiểm tra xem idPost có được cung cấp hay không
    if ($idPost === null) {
        echo json_encode(['status' => false, 'message' => 'Thiếu id bài viết.']);
        return;
    }

    $sql = "SELECT * FROM message WHERE idpost = ?";

    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPost);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];

    // Kiểm tra kết quả
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $messages[] = [
                'id' => $row['id'],
                'idPost' => $row['idpost'],
                'idSinhVien' => $row['idsinhvien'],
                'thoiGian' => $row['thoigian'],
                'noiDung' => $row['noidung'],
                'coImage' => $row['coimg'],
                'img' => $row['img']
            ];
        }

        return $messages;
    } else {
        return null;
    }
}

function extractSchedules($schedules)
{
    $result = [];

    if ($schedules) {
        foreach ($schedules as $schedule) {
            $lopTinChi = $schedule['lopTinChi'];
            $soTin = $schedule['soTin'];
            $tenMonHoc = $schedule['tenMonHoc'];

            foreach ($schedule['lichHoc'] as $lichHoc) {
                $caHoc = $lichHoc['caHoc'];
                $ngayHoc = $lichHoc['ngayHoc'];
                $phongHoc = $lichHoc['phongHoc'];

                // Lưu lại thông tin chi tiết cho mỗi lịch học
                $result[] = [
                    'lopTinChi' => $lopTinChi,
                    'soTin' => $soTin,
                    'tenMonHoc' => $tenMonHoc,
                    'caHoc' => $caHoc,
                    'ngayHoc' => $ngayHoc,
                    'phongHoc' => $phongHoc,
                ];
            }
        }
    }

    return $result;
}

function addSubjects($subjects, $idSinhVien)
{
    foreach ($subjects as $subject) {
        $result = addSubjectAndSchedule($subject, $idSinhVien);
        $response = json_decode($result, true);

        // Kiểm tra xem có lỗi không
        if (!$response['status']) {
            return json_encode(['status' => false, 'message' => $response['message']]);
        }
    }

    return json_encode(['status' => true, 'message' => 'Thêm tất cả môn học thành công']);
}



function addSubjectAndSchedule($subjectData, $idSinhVien)
{
    global $conn;

    $tenMonHoc = $subjectData['tenMonHoc'];
    $lopTinChi = $subjectData['lopTinChi'];
    $soTin = $subjectData['soTin'];
    $lichHoc = $subjectData['lichHoc'];
    
    if (!subjectExists($tenMonHoc)) {
        $mamon = insertSubject($tenMonHoc, $soTin);
    } else {
        $mamon = getSubject($tenMonHoc);
    }

    $scheduleInsertResult = insertSchedules($lichHoc, $mamon, $lopTinChi);
    if (!$scheduleInsertResult) {
        return json_encode(['status' => false, 'message' => 'Lỗi khi thêm lịch học']);
    }

    $registerResult = registerStudentForSubject($idSinhVien, $mamon, $lopTinChi);
    if (!$registerResult) {
        return json_encode(['status' => false, 'message' => 'Lỗi khi đăng ký môn học cho sinh viên']);
    }

    return json_encode(['status' => true, 'message' => 'Thêm môn học, lịch học và đăng ký thành công']);
}

function subjectExists($tenMonHoc)
{
    global $conn;
    $queryCheck = "SELECT COUNT(*) as count FROM danhsachmonhoc WHERE tenmon = ?";
    $stmtCheck = $conn->prepare($queryCheck);
    
    if (!$stmtCheck) {
        echo "Lỗi khi chuẩn bị câu lệnh: " . $conn->error . "\n";
        return false;
    }

    $stmtCheck->bind_param("s", $tenMonHoc);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    $row = $resultCheck->fetch_assoc();
    return $row['count'] > 0;
}


function getSubject($tenMonHoc)
{
    global $conn;
    $queryCheck = "SELECT id FROM danhsachmonhoc WHERE tenmon = ?";

    $stmtCheck = $conn->prepare($queryCheck);
    if (!$stmtCheck) {
        echo "Lỗi khi chuẩn bị câu lệnh: " . $conn->error . "\n";
        return false;
    }
    
    $stmtCheck->bind_param("s", $tenMonHoc);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($row = $resultCheck->fetch_assoc()) {
        return $row['id'];
    }

    return false;
}

function insertSubject($tenMonHoc, $soTin)
{
    global $conn;
    $queryInsert = "INSERT INTO danhsachmonhoc (tenmon, soTin) VALUES (?, ?)";
    $stmtInsert = $conn->prepare($queryInsert);
    $stmtInsert->bind_param("si", $tenMonHoc, $soTin);
    if ($stmtInsert->execute()) {
        return $conn->insert_id;
    }
    return null;
}

function insertSchedules($lichHoc, $mamon, $lopTinChi)
{
    global $conn;
    foreach ($lichHoc as $schedule) {
        $caHoc = $schedule['caHoc'];
        $ngayHoc = $schedule['ngayHoc'];
        $phongHoc = $schedule['phongHoc'];

        $queryScheduleInsert = "INSERT INTO lichhoc (mamon, loptinchi, ngayhoc, cahoc, phonghoc) VALUES (?, ?, ?, ?, ?)";
        $stmtScheduleInsert = $conn->prepare($queryScheduleInsert);
        $stmtScheduleInsert->bind_param("iisss", $mamon, $lopTinChi, $ngayHoc, $caHoc, $phongHoc);
        if (!$stmtScheduleInsert->execute()) {
            return false;
        }
    }
    return true;
}

function registerStudentForSubject($idSinhVien, $mamon, $lopTinChi)
{
    global $conn;
    $queryRegister = "INSERT INTO dangkimonhoc (idsinhvien, mamon, loptinchi) VALUES (?, ?, ?)";
    $stmtRegister = $conn->prepare($queryRegister);
    $stmtRegister->bind_param("iii", $idSinhVien, $mamon, $lopTinChi);
    return $stmtRegister->execute();
}
