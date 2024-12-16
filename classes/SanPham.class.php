<?php 
    class SanPham extends Db{
        public function getRand($n=8){
            $sql = "select * from san_pham order by rand() limit 0 , $n";
            return $this->select($sql);	
	    }
        public function getById($ma){
            $sql = "select * from san_pham where ma_san_pham = $ma";
            return $this->selectOne($sql);
        }
        public function getAll($page, $n = 8, $maloai = null, $keyword = null) {
            $trang = ($page - 1) * $n;
            $conditions = [];
            if (!empty($keyword)) {
                $keyword = trim($keyword); 
                $conditions[] = "ten_san_pham LIKE '%$keyword%'";
            }
            if (!empty($maloai)) {
                $conditions[] = "ma_loai = $maloai";
            }
            $where = "";
            if (!empty($conditions)) {
                $where = "WHERE " . implode(" AND ", $conditions);
            }
            $sql = "SELECT * FROM san_pham $where LIMIT $trang, $n";
            return $this->select($sql);
        }
        
        public function getCountPage($n = 8, $maloai = null, $keyword = null) {
            $conditions = [];
            if (!empty($keyword)) {
                $keyword = trim($keyword); 
                $conditions[] = "ten_san_pham LIKE '%$keyword%'";
            }
            if (!empty($maloai)) {
                $conditions[] = "ma_loai = $maloai";
            }
            $where = "";
            if (!empty($conditions)) {
                $where = "WHERE " . implode(" AND ", $conditions);
            }
            $sql = "SELECT COUNT(*) AS total FROM san_pham $where";
            $result = $this->select($sql);
            $totalProducts = $result[0]['total'];
            return ceil($totalProducts / $n);
        }
        
    }
?>