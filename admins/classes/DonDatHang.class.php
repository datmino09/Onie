<?php
class DonDatHang extends Db {
    // Lấy danh sách tất cả đơn hàng (có thể phân trang)
    public function getAll($page = 1, $pageSize = 5) {
        $offset = ($page - 1) * $pageSize;
        $sql = "SELECT dh.*, kh.ho_ten, kh.email, kh.sdt, kh.dia_chi
                FROM don_dat_hang dh
                INNER JOIN khach_hang kh ON dh.ma_khach_hang = kh.ma_khach_hang
                LIMIT $offset, $pageSize";
        return $this->select($sql);
    }

    public function getDetail($ma_don_hang) {
        $sql = "SELECT dh.*, kh.ho_ten, kh.email, kh.sdt, kh.dia_chi
                FROM don_dat_hang dh
                INNER JOIN khach_hang kh ON dh.ma_khach_hang = kh.ma_khach_hang
                WHERE dh.ma_don_hang = :ma_don_hang";
        $don_hang = $this->selectOne($sql, [':ma_don_hang' => $ma_don_hang]);

        if ($don_hang) {
            $sql_ct = "SELECT ctddh.ma_san_pham, sp.ten_san_pham, sp.image, ctddh.so_luong, ctddh.thanhtien, 
                            lsp.ten_loai AS ten_loai_san_pham
                    FROM chi_tiet_don_dat_hang ctddh
                    INNER JOIN san_pham sp ON ctddh.ma_san_pham = sp.ma_san_pham
                    INNER JOIN loai_san_pham lsp ON sp.ma_loai = lsp.ma_loai
                    WHERE ctddh.ma_don_hang = :ma_don_hang";
            $don_hang['chi_tiet'] = $this->select($sql_ct, [':ma_don_hang' => $ma_don_hang]);
        }

        return $don_hang;
    }

    public function deleteDonHang($ma_don_hang) {
        $sql_ct = "DELETE FROM chi_tiet_don_dat_hang WHERE ma_don_hang = :ma_don_hang";
        $this->delete($sql_ct, [':ma_don_hang' => $ma_don_hang]);
        $sql = "DELETE FROM don_dat_hang WHERE ma_don_hang = :ma_don_hang";
        return $this->delete($sql, [':ma_don_hang' => $ma_don_hang]);
    }

    // Đếm tổng số đơn hàng
    public function getTotalOrders() {
        $sql = "SELECT COUNT(*) AS total FROM don_dat_hang";
        $result = $this->selectOne($sql);
        return $result['total'];
    }

    public function search($keyword, $page = 1, $pageSize = 10) {
    $offset = ($page - 1) * $pageSize;

    $sql = "SELECT dh.*, kh.ho_ten, kh.email, kh.sdt, kh.dia_chi
            FROM don_dat_hang dh
            INNER JOIN khach_hang kh ON dh.ma_khach_hang = kh.ma_khach_hang
            WHERE dh.ma_don_hang LIKE :keyword
               OR kh.ho_ten LIKE :keyword
               OR kh.ma_khach_hang LIKE :keyword
               OR kh.sdt LIKE :keyword
            LIMIT $offset, $pageSize";
        return $this->select($sql, [':keyword' => "%$keyword%"]);
    }

    public function countSearchResults($keyword) {
    $sql = "SELECT COUNT(*) AS total 
            FROM don_dat_hang dh
            INNER JOIN khach_hang kh ON dh.ma_khach_hang = kh.ma_khach_hang
            WHERE dh.ma_don_hang LIKE :keyword
               OR kh.ho_ten LIKE :keyword
               OR kh.ma_khach_hang LIKE :keyword
               OR kh.sdt LIKE :keyword";
    $result = $this->selectOne($sql, [':keyword' => "%$keyword%"]);
    return $result['total'];
    }

    public function getCountPages($pageSize = 10) {
        $totalOrders = $this->getTotalOrders();  
        return ceil($totalOrders / $pageSize);  
    }

    public function getCountPagesForSearch($keyword, $pageSize = 5) {
        $totalSearchResults = $this->countSearchResults($keyword);  
        return ceil($totalSearchResults / $pageSize);  
    }  
}