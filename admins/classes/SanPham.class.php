<?php 


class SanPham extends Db {
    
    // Lấy danh sách sản phẩm ngẫu nhiên cùng với thông tin loại sản phẩm
    public function getRand($n = 8) {
        $sql = "SELECT sp.*, ls.ten_loai FROM san_pham sp
                JOIN loai_san_pham ls ON sp.ma_loai = ls.ma_loai
                ORDER BY RAND() LIMIT $n";
        return $this->query($sql);  
    }

    // Lấy tất cả sản phẩm với phân trang và lọc theo loại sản phẩm, cùng với thông tin loại sản phẩm
    public function getAll($page, $n = 8, $maloai = null) {
        $trang = ($page - 1) * $n;
        $params = array();

        if ($maloai) {
            $sql = "SELECT sp.*, ls.ten_loai FROM san_pham sp
                    JOIN loai_san_pham ls ON sp.ma_loai = ls.ma_loai
                    WHERE sp.ma_loai = :maloai LIMIT $trang, $n";
            $params[':maloai'] = $maloai;
        } else {
            $sql = "SELECT sp.*, ls.ten_loai FROM san_pham sp
                    JOIN loai_san_pham ls ON sp.ma_loai = ls.ma_loai
                    LIMIT $trang, $n";
        }
        return $this->query($sql, $params);
    }

    // Đếm số lượng trang cần thiết cho phân trang, tính cả loại sản phẩm
    public function getCountPage($n = 8, $maloai = null) {
        $params = [];
        if ($maloai) {
            $sql = "SELECT COUNT(*) AS total FROM san_pham sp
                    JOIN loai_san_pham ls ON sp.ma_loai = ls.ma_loai
                    WHERE sp.ma_loai = :maloai";
            $params[':maloai'] = $maloai;
        } else {
            $sql = "SELECT COUNT(*) AS total FROM san_pham sp
                    JOIN loai_san_pham ls ON sp.ma_loai = ls.ma_loai";
        }
        $result = $this->query($sql, $params);
        $totalProducts = $result[0]['total'];
        return ceil($totalProducts / $n);
    }

    public function searchProduct($keyword, $page = 1, $pageSize = 5) {
        $keyword = '%' . trim($keyword) . '%';
        $offset = ($page - 1) * $pageSize;

        $sql = "SELECT sp.*, ls.ten_loai FROM san_pham sp
                JOIN loai_san_pham ls ON sp.ma_loai = ls.ma_loai
                WHERE sp.ten_san_pham LIKE :keyword OR ls.ten_loai LIKE :keyword
                LIMIT $offset, $pageSize";

        return $this->query($sql, [
            ':keyword' => $keyword
        ]);
    }

    public function getSearchCount($keyword) {
        $keyword = '%' . trim($keyword) . '%';

        $sql = "SELECT COUNT(*) AS total FROM san_pham sp
                JOIN loai_san_pham ls ON sp.ma_loai = ls.ma_loai
                WHERE sp.ten_san_pham LIKE :keyword OR ls.ten_loai LIKE :keyword";

        $result = $this->selectOne($sql, [':keyword' => $keyword]);
        return $result['total'];
    }

    public function getSearchPageCount($keyword, $pageSize = 8) {
        $totalProducts = $this->getSearchCount($keyword);
        return ceil($totalProducts / $pageSize);
    }


    // Thêm sản phẩm mới
    public function addProduct($ten_san_pham, $mo_ta, $image, $gia, $ma_loai) {
        $sql = "INSERT INTO san_pham (ten_san_pham, mo_ta, image, gia, ma_loai) 
                VALUES (:ten_san_pham, :mo_ta, :image, :gia, :ma_loai)";
        return $this->insert($sql, [
            ':ten_san_pham' => $ten_san_pham,
            ':mo_ta' => $mo_ta,
            ':image' => $image,
            ':gia' => $gia,
            ':ma_loai' => $ma_loai
        ]);
    }

    // Cập nhật thông tin sản phẩm
    public function updateProduct($ma_san_pham, $ten_san_pham, $mo_ta, $image, $gia, $ma_loai) {
        $sql = "UPDATE san_pham SET 
                ten_san_pham = :ten_san_pham, 
                mo_ta = :mo_ta, 
                image = :image, 
                gia = :gia, 
                ma_loai = :ma_loai
                WHERE ma_san_pham = :ma_san_pham";
        return $this->update($sql, [
            ':ma_san_pham' => $ma_san_pham,
            ':ten_san_pham' => $ten_san_pham,
            ':mo_ta' => $mo_ta,
            ':image' => $image,
            ':gia' => $gia,
            ':ma_loai' => $ma_loai
        ]);
    }

    public function isProductInOrder($ma_san_pham) {
    $sql = "SELECT COUNT(*) AS total FROM chi_tiet_don_dat_hang WHERE ma_san_pham = :ma_san_pham";
    $result = $this->selectOne($sql, [':ma_san_pham' => $ma_san_pham]);

    return $result['total'] > 0; // Trả về true nếu sản phẩm tồn tại
    }
    
    // Xóa sản phẩm theo mã sản phẩm
    public function deleteProduct($ma_san_pham) {
        $sql = "DELETE FROM san_pham WHERE ma_san_pham = :ma_san_pham";
        return $this->delete($sql, [':ma_san_pham' => $ma_san_pham]);
    }
    
    // Xóa nhiều sản phẩm theo mảng mã sản phẩm
    public function deleteMultipleProducts($ids) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "DELETE FROM san_pham WHERE ma_san_pham IN ($placeholders)";
        return $this->query($sql, $ids);
    }

    public function getProductById($ma_san_pham) {
        $sql = "SELECT sp.*, ls.ten_loai FROM san_pham sp
                JOIN loai_san_pham ls ON sp.ma_loai = ls.ma_loai
                WHERE sp.ma_san_pham = :ma_san_pham";
        return $this->selectOne($sql, [':ma_san_pham' => $ma_san_pham]);
    }
}