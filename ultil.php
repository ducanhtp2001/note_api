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

function getPostsByMaMonAndLopTinChi($maMon, $lopTinChi) {
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
                'thoigian' => $row['thoigian'],
                'mamon' => $row['mamon'],
                'loptinchi' => $row['loptinchi'],
                'noidung' => $row['noidung'],
                'coimg' => $row['coimg'],
                'img' => $row['img']
            ];
        }

        return $posts;
    } else {
        return null;
    }

    echo json_encode($response);
}

function getMessagesByIdPost($idPost) {
    global $conn;

    // Kiểm tra xem idPost có được cung cấp hay không
    if ($idPost === null) {
        echo json_encode(['status' => false, 'message' => 'Thiếu id bài viết.']);
        return;
    }

    // Câu lệnh SQL để lấy tin nhắn theo idPost
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
