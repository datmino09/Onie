<?php 
class LoaiSanPham extends Db {
    public function getAll() {
        $sql = "SELECT * FROM loai_san_pham";
        return $this->select($sql);	
    }

    public function getByPage($page = 1, $pageSize = 5) {
        $offset = ($page - 1) * $pageSize;
        $sql = "SELECT * FROM loai_san_pham LIMIT $offset, $pageSize";
        return $this->select($sql);
    }

    public function save($ten_loai) {
        $sql = "INSERT INTO loai_san_pham (ten_loai) VALUES (:ten_loai)";
        return $this->insert($sql, [
            ':ten_loai' => $ten_loai
        ]);
    }
    public function hasProducts($id) {
        $sql = "SELECT COUNT(*) AS product_count FROM san_pham WHERE ma_loai = ?";
        $result = $this->selectOne($sql, [$id]);
        return $result['product_count'] > 0;
    }
    
    public function deleteByIds($ids = []) {
        if (empty($ids)) {
            return 0; 
        }
        $placeholder = implode(',', array_fill(0, count($ids), '?'));
        $sql = "DELETE FROM loai_san_pham WHERE ma_loai IN ($placeholder)";
        return $this->delete($sql, $ids);
    }

    public function updateById($ma_loai, $ten_loai) {
        $sql = "UPDATE loai_san_pham SET ten_loai = :ten_loai WHERE ma_loai = :ma_loai";
        return $this->update($sql, [
            ':ten_loai' => $ten_loai,
            ':ma_loai' => $ma_loai
        ]);
    }

    public function getById($ma_loai) {
        $sql = "SELECT * FROM loai_san_pham WHERE ma_loai = :ma_loai";
        return $this->selectOne($sql, [
            ':ma_loai' => $ma_loai
        ]);
    }

    public function getTotalPages($pageSize = 5) {
        $sql = "SELECT COUNT(*) AS total FROM loai_san_pham";
        $result = $this->selectOne($sql);
        $totalItems = $result['total'];

        return ceil($totalItems / $pageSize);
    }

    public function search($keyword, $page = 1, $pageSize = 5) {
        $keyword = "%" . $keyword . "%";
        $offset = ($page - 1) * $pageSize;
        $sql = "SELECT * FROM loai_san_pham 
                WHERE ten_loai LIKE :keyword 
                OR ma_loai LIKE :keyword
                LIMIT $offset, $pageSize";
        return $this->select($sql, [
            ':keyword' => $keyword
        ]);
    }

    public function getSearchCount($keyword) {
        $keyword = "%" . $keyword . "%";
        $sql = "SELECT COUNT(*) AS total FROM loai_san_pham 
                WHERE ten_loai LIKE :keyword 
                OR ma_loai LIKE :keyword";
        $result = $this->selectOne($sql, [
            ':keyword' => $keyword
        ]);
        return $result['total'];
    }
    public function getSearchPageCount($keyword, $pageSize = 5) {
        $totalResults = $this->getSearchCount($keyword);
        return ceil($totalResults / $pageSize);
    }
}
?>