<?php 
    class KhachHang extends Db{
        function checkLogin($email,$password){
            $sql = "SELECT * FROM khach_hang WHERE email = :email AND mat_khau = :password";
            $arr = ['email' => $email, 'password' => $password];
            return $this->selectOne($sql, $arr);
        }
        function registerUser($name,$email,$phone,$password){
            $sql = "INSERT INTO khach_hang (ho_ten, email, sdt, mat_khau) values (:name, :email, :phone, :password)";
            $arr = ['name' => $name, 'email' => $email, 'phone' => $phone, 'password' => $password];
            $this->insert($sql,$arr);
            return $this->getLastInsertedId();
        }
        function checkIssetEmail($email){
            $sql = "SELECT * FROM khach_hang WHERE email = :email";
            $arr = ['email' => $email];
            $result = $this->selectOne($sql,$arr);
            return $result !== false;
        }
        function checkIssetSDT($sdt){
            $sql = "SELECT * FROM khach_hang WHERE sdt = $sdt";
            $result = $this->selectOne($sql);
            return $result !== false;
        }
        public function updateUser($makhachhang,$hoten,$sdt,$diachi){
            $sql = "UPDATE khach_hang 
                       SET ho_ten = '$hoten' , sdt = '$sdt', dia_chi = '$diachi'
                       WHERE ma_khach_hang = $makhachhang";
            return $this->update($sql);
        }
        public function getById($makhachhang){
            $sql = "SELECT * FROM khach_hang where ma_khach_hang = $makhachhang";
            return $this->selectOne($sql);
        }
    }
?>