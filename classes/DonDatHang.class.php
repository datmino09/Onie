<?php 
class DonDatHang extends Db{
    function addDDH($makh,$ngaydat,$trangthai,$tong){
        $sql = "INSERT INTO don_dat_hang(ma_khach_hang,ngay_dat,trang_thai,tongtien) values($makh,$ngaydat,'$trangthai',$tong)";
        $this->insert($sql);
        return $this->getLastInsertedId();
    }
    function addchitietDDH($madh,$masp,$sl,$thanhtien){
        $sql = "INSERT INTO chi_tiet_don_dat_hang(ma_don_hang,ma_san_pham,so_luong,thanhtien) values($madh,$masp,$sl,$thanhtien)";
        return $this->insert($sql);
    }
    function countOrder($makh){
        $sql = "SELECT COUNT(ma_don_hang)  as tongdon from don_dat_hang where ma_khach_hang = $makh and trang_thai = 0";
        return $this->selectOne($sql);
    }
    function countOrdered($makh){
        $sql = "SELECT COUNT(ma_don_hang)  as tongdon from don_dat_hang where ma_khach_hang = $makh and trang_thai = 1";
        return $this->selectOne($sql);
    }
    function getAllDDHChuaGiaoCuaKH($makh){
        $sql = "SELECT * from don_dat_hang where ma_khach_hang=$makh and trang_thai = 0";
        return $this->select($sql);
    }
    function getAllDDHDaGiaoCuaKH($makh){
        $sql = "SELECT * from don_dat_hang where ma_khach_hang=$makh and trang_thai = 1";
        return $this->select($sql);
    }
    public function getAllSPinDDH($madonhang){
        $sql = "select * from chi_tiet_don_dat_hang where ma_don_hang = $madonhang";
        return $this->select($sql);	
    }
}
?>