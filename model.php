<?php 

class Note {
    public $id;
    public $idSinhVien;
    public $tieuDe;
    public $ngayTao;
    public $ngayCapNhat;
    public $noiDung;
    public $noiDungCua;

    function __construct($id, $idSinhVien, $tieuDe, $ngayTao, $ngayCapNhat, $noiDung, $noiDungCua) {
        $this->id = $id;
        $this->idSinhVien = $idSinhVien;
        $this->tieuDe = $tieuDe;
        $this->ngayTao = $ngayTao;
        $this->ngayCapNhat = $ngayCapNhat;
        $this->noiDung = $noiDung;
        $this->noiDungCua = $noiDungCua;
    }
}

class SinhVien {
    public $id;
    public $hoTen;
    public $ngaySinh;
    public $gioiTinh;
    public $queQuan;
    public $gmail;
    public $sdt;
    public $khoa;
    public $nienKhoa;
    public $lop;

    function __construct($id, $hoTen, $ngaySinh, $gioiTinh, $queQuan, $gmail, $sdt, $khoa, $nienKhoa, $lop) {
        $this->id = $id;
        $this->hoTen = $hoTen;
        $this->ngaySinh = $ngaySinh;
        $this->gioiTinh = $gioiTinh;
        $this->queQuan = $queQuan;
        $this->gmail = $gmail;
        $this->sdt = $sdt;
        $this->khoa = $khoa;
        $this->nienKhoa = $nienKhoa;
        $this->lop = $lop;
    }
}

class Message {
    public $id;
    public $idPost;
    public $idSinhVien;
    public $thoiGian;
    public $noiDung;
    public $coImg;
    public $img;

    function __construct($id, $idPost, $idSinhVien, $thoiGian, $noiDung, $coImg, $img) {
        $this->id = $id;
        $this->idPost = $idPost;
        $this->idSinhVien = $idSinhVien;
        $this->thoiGian = $thoiGian;
        $this->noiDung = $noiDung;
        $this->coImg = $coImg;
        $this->img = $img;
    }
}

class Schedule {
    public $maMon;
    public $tenMon;
    public $soTinChi;
    public $lopTinChi;
    public $ngayHoc;
    public $caHoc;
    public $phongHoc;

    function __construct($maMon, $tenMon, $soTinChi, $lopTinChi, $ngayHoc, $caHoc, $phongHoc) {
        $this->maMon = $maMon;
        $this->tenMon = $tenMon;
        $this->soTinChi = $soTinChi;
        $this->lopTinChi = $lopTinChi;
        $this->ngayHoc = $ngayHoc;
        $this->caHoc = $caHoc;
        $this->phongHoc = $phongHoc;
    }
}

class Post {
    public $id;
    public $idSinhVien;
    public $thoiGian;
    public $maMon;
    public $lopTinChi;
    public $noiDung;
    public $coImg;
    public $img;

    function __construct($id, $idSinhVien, $thoiGian, $maMon, $lopTinChi, $noiDung, $coImg, $img) {
        $this->id = $id;
        $this->idSinhVien = $idSinhVien;
        $this->thoiGian = $thoiGian;
        $this->maMon = $maMon;
        $this->lopTinChi = $lopTinChi;
        $this->noiDung = $noiDung;
        $this->coImg = $coImg;
        $this->img = $img;
    }
}