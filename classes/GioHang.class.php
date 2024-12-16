<?php 
    class GioHang extends Db{
        public function create($makhachhang){
            $sql = "INSERT INTO gio_hang (ma_khach_hang) values (:makhachhang)";
            $arr = ["makhachhang"=>$makhachhang];
            return $this->insert($sql, $arr);
        }
        public function getAllGioHang($magiohang){
            $sql = "select * from chi_tiet_gio_hang where ma_gio_hang = $magiohang";
            return $this->select($sql);	
	    }
        public function getMaGioHang($makhachhang){
            $sql = "SELECT ma_gio_hang FROM gio_hang where ma_khach_hang = $makhachhang";
            return $this->selectOne($sql);
        }
        public function addGioHang($magiohang,$masanpham,$soluong,$thanhtien){
            $sql = "INSERT INTO chi_tiet_gio_hang(ma_gio_hang,ma_san_pham,so_luong,thanhtien) values ($magiohang,$masanpham,$soluong,$thanhtien)";
            return $this->insert($sql);
        }
        public function checkSPinGioHang($magiohang,$masanpham){
            $sql = "SELECT * from chi_tiet_gio_hang where ma_gio_hang = $magiohang and ma_san_pham = $masanpham";
            $result = $this->selectOne($sql);
            return $result !== false;
        }
        public function updateGioGang($magiohang,$masanpham,$soluong,$thanhtien){
            $sql = "UPDATE chi_tiet_gio_hang 
                       SET so_luong = $soluong, thanhtien = $thanhtien 
                       WHERE ma_gio_hang = $magiohang AND ma_san_pham = $masanpham";
            return $this->update($sql);
        }
        public function getSoLuong($magiohang,$masanpham){
            $sql = "SELECT so_luong FROM chi_tiet_gio_hang where ma_gio_hang = $magiohang and ma_san_pham = $masanpham";
            return $this->selectOne($sql);
        }
        public function deleteSPinGioHang($magh,$masp){
            $sql = "DELETE FROM chi_tiet_gio_hang where ma_gio_hang = $magh and ma_san_pham = $masp";
            return $this->delete($sql);
        }
        public function countSPinGioHang($magh){
            $sql = "SELECT COUNT(ma_san_pham)  as tongsoluong from chi_tiet_gio_hang where ma_gio_hang = $magh";
            return $this->selectOne($sql);
        }
        public function deleteAllSPinGioHang($magh){
            $sql = "DELETE FROM chi_tiet_gio_hang where ma_gio_hang = $magh";
            return $this->delete($sql);
        }
    }
?>