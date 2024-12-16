<?php 
    class LoaiSanPham extends Db{
        public function getAll(){
            $sql = "select * from loai_san_pham";
            return $this->select($sql);	
	    }
        public function getName($ma){
            $sql = "select ten_loai from loai_san_pham where ma_loai=$ma";
            return $this->selectOne($sql);
        }
    }
?>