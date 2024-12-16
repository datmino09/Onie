<?php
class KhachHang extends Db {

// Lấy danh sách tất cả khách hàng với phân trang
public function getAll($page, $n = 5) {
    $trang = ($page - 1) * $n;
    $sql = "SELECT * FROM khach_hang LIMIT $trang, $n";
    return $this->query($sql);
}

// Đếm số lượng trang cần thiết cho phân trang
public function getCountPage($pageSize = 5) {
    $sql = "SELECT COUNT(*) AS total FROM khach_hang";
    $result = $this->query($sql);
    $totalCustomers = $result[0]['total'];
    return ceil($totalCustomers / $pageSize);
}

public function searchCustomer($keyword, $page, $pageSize = 5) {
    $keyword = '%' . trim($keyword) . '%';
    $offset = ($page - 1) *  $pageSize;
    $sql = "SELECT * FROM khach_hang 
            WHERE ho_ten LIKE :keyword 
            OR email LIKE :keyword 
            OR sdt LIKE :keyword
            LIMIT $offset, $pageSize";
    return $this->query($sql, [
        ':keyword' => $keyword
    ]);
}

public function getSearchCount($keyword) {
    $keyword = '%' . trim($keyword) . '%';
    $sql = "SELECT COUNT(*) AS total FROM khach_hang 
            WHERE ho_ten LIKE :keyword 
            OR email LIKE :keyword 
            OR sdt LIKE :keyword";
    $result = $this->selectOne($sql, [':keyword' => $keyword]);
    return $result['total'];
}
public function getSearchPageCount($keyword, $pageSize = 5) {
    $totalResults = $this->getSearchCount($keyword);
    return ceil($totalResults / $pageSize);
}

// Thêm khách hàng mới
public function addCustomer($ho_ten, $email, $sdt, $dia_chi, $mat_khau) {
    $sql = "INSERT INTO khach_hang (ho_ten, email, sdt, dia_chi, mat_khau) 
            VALUES (:ho_ten, :email, :sdt, :dia_chi, :mat_khau)";
    return $this->insert($sql, [
        ':ho_ten' => $ho_ten,
        ':email' => $email,
        ':sdt' => $sdt,
        ':dia_chi' => $dia_chi,
        ':mat_khau' => $mat_khau
    ]);
}

// Cập nhật thông tin khách hàng
public function updateCustomer($ma_khach_hang, $ho_ten, $email, $sdt, $dia_chi, $mat_khau) {
    $sql = "UPDATE khach_hang SET 
            ho_ten = :ho_ten, 
            email = :email, 
            sdt = :sdt, 
            dia_chi = :dia_chi, 
            mat_khau = :mat_khau
            WHERE ma_khach_hang = :ma_khach_hang";
    return $this->update($sql, [
        ':ma_khach_hang' => $ma_khach_hang,
        ':ho_ten' => $ho_ten,
        ':email' => $email,
        ':sdt' => $sdt,
        ':dia_chi' => $dia_chi,
        ':mat_khau' => $mat_khau
    ]);
}

// Xóa khách hàng theo mã khách hàng
public function deleteCustomer($ma_khach_hang) {
    $sql = "DELETE FROM khach_hang WHERE ma_khach_hang = :ma_khach_hang";
    return $this->delete($sql, [':ma_khach_hang' => $ma_khach_hang]);
}

// Lấy thông tin khách hàng theo mã khách hàng
public function getCustomerById($ma_khach_hang) {
    $sql = "SELECT * FROM khach_hang WHERE ma_khach_hang = :ma_khach_hang";
    return $this->selectOne($sql, [':ma_khach_hang' => $ma_khach_hang]);
}

// Xóa nhiều khách hàng theo mảng mã khách hàng
public function deleteMultipleCustomers($ids) {
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "DELETE FROM khach_hang WHERE ma_khach_hang IN ($placeholders)";
    return $this->query($sql, $ids);
}

// Kiểm tra email hoặc số điện thoại đã tồn tại trong hệ thống
public function checkExistEmailOrPhone($email, $sdt) {
    $sql = "SELECT * FROM khach_hang WHERE email = :email OR sdt = :sdt";
    return $this->query($sql, [':email' => $email, ':sdt' => $sdt]);
}
}
?>