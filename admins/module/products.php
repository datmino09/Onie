<?php

$sanPham = new SanPham();
$loaiSanPham = new LoaiSanPham();

// Lấy trang hiện tại (mặc định là 1 nếu không có tham số page)
$page = getIndex('page', 1); 
$pageSize = 5; // Số sản phẩm trên mỗi trang

// Kiểm tra nếu có từ khóa tìm kiếm
$keyword = getIndex('search_keyword');
if ($keyword != '') {
    $products = $sanPham->searchProduct($keyword,$page,$pageSize); // Tìm kiếm sản phẩm
    $totalPages = $sanPham->getSearchPageCount($keyword, $pageSize); // Với tìm kiếm, chỉ cần hiển thị kết quả trong 1 trang
} else {
    // Lấy danh sách sản phẩm theo trang
    $products = $sanPham->getAll($page, $pageSize);
    $totalPages = $sanPham->getCountPage($pageSize); // Tổng số trang
}

if (isset($_POST['add_product'])) {
    $tenSanPham = postIndex('ten_san_pham');
    $moTa = postIndex('mo_ta');
    $gia = postIndex('gia');
    $maLoai = postIndex('ma_loai');

    $image = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];

    $allowTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if ( !in_array(mime_content_type($imageTmp), $allowTypes)) {
        $_SESSION['message'] = ['type' => 'danger', 'content' => 'File ảnh không hợp lệ. Vui lòng chọn file JPG, PNG, GIF.'];
    } else {
        $targetFile = ROOT . "/images/" . basename($image);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $added = $sanPham->addProduct($tenSanPham, $moTa, $image, $gia, $maLoai);
            if ($added) {
                $_SESSION['message'] = ['type' => 'success', 'content' => 'Thêm sản phẩm thành công!'];
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'content' => 'Thêm sản phẩm thất bại.'];
            }
        }
    }

    header("Location: index.php?mod=products");
    exit;
}
if (getIndex('action') === 'delete' && getIndex('id')) {
    $id = intval(getIndex('id'));
    $product = $sanPham->isProductInOrder($id);
    if ($product) {
        $_SESSION['message'] = ['type' => 'danger', 'content' => 'Không thể xoá sản phẩm đã từng được đặt!'];
        header("Location: index.php?mod=products&page=". $page);
        exit;
    }
    $deleted = $sanPham->deleteProduct($id);

    if ($deleted) {
        $_SESSION['message'] = ['type' => 'success', 'content' => 'Xóa sản phẩm thành công!'];
    } else {
        $_SESSION['message'] = ['type' => 'danger', 'content' => 'Xóa sản phẩm thất bại!'];
    }
    header("Location: index.php?mod=products&page=" . $page);
    exit;
}

if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['selected_ids'])) {
        $selectedIds = $_POST['selected_ids'];
        $deletedCount = $sanPham->deleteMultipleProducts($selectedIds);

        $_SESSION['message'] = $deletedCount > 0
            ? ['type' => 'success', 'content' => "Xóa $deletedCount sản phẩm thành công!"]
            : ['type' => 'danger', 'content' => 'Không thể xóa các sản phẩm đã chọn.'];

        header("Location: index.php?mod=products&page=" . $page);
        exit;
    } else {
        $_SESSION['message'] = ['type' => 'warning', 'content' => 'Không có mục nào được chọn!'];
    }
}

// Cập nhật sản phẩm
if (isset($_POST['update_product'])) {
    $maSanPham = postIndex('ma_san_pham');
    $tenSanPham = postIndex('ten_san_pham');
    $moTa = postIndex('mo_ta');
    $gia = postIndex('gia');
    $maLoai = postIndex('ma_loai');
    $image = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];

    $product = $sanPham->getProductById($maSanPham);
        if (!empty($image)) {
            $imageType = pathinfo($image, PATHINFO_EXTENSION);
            $imageNewName = uniqid() . '.' . $imageType;
            $targetFile = ROOT . "/images/" . basename($imageNewName);
            if (move_uploaded_file($imageTmp, $targetFile)) {
                // Cập nhật sản phẩm với ảnh mới
                $updated = $sanPham->updateProduct($maSanPham, $tenSanPham, $moTa, $imageNewName, $gia, $maLoai);
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'content' => 'Lỗi khi tải lên file ảnh.'];
            }
        } else {
            // Nếu không có ảnh mới, chỉ cập nhật thông tin sản phẩm với ảnh cũ
            $updated = $sanPham->updateProduct($maSanPham, $tenSanPham, $moTa, $product['image'], $gia, $maLoai);
        }

        if ($updated) {
            $_SESSION['message'] = ['type' => 'success', 'content' => 'Cập nhật sản phẩm thành công!'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'content' => "Cập nhật sản phẩm $maSanPham thất bại. Vui lòng thử lại."];
        }

        header("Location: index.php?mod=products&page=" . $page);
        exit;
}
if (getIndex('action') === 'edit' && getIndex('id')) {
    $id = intval(getIndex('id'));
    $product = $sanPham->getProductById($id); // Lấy sản phẩm theo ID

    if (!$product) {
        $_SESSION['message'] = ['type' => 'danger', 'content' => 'Sản phẩm không tồn tại!'];
        header("Location: index.php?mod=products&page=" . $page);
        exit;
    } else {
        ?>
<div class="container p-4">
    <h3 class="text-center">Chỉnh sửa sản phẩm</h3>
    <form class="form" action="" method="post" enctype="multipart/form-data">
        <label for="ma_san_pham" class="form-label">Mã sản phẩm</label>
        <input type="text" class="form-control" name="ma_san_pham" value="<?= $product['ma_san_pham'] ?>" readonly>

        <div class="mb-3">
            <label for="ten_san_pham" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" name="ten_san_pham" value="<?= $product['ten_san_pham'] ?>"
                required>
        </div>

        <div class="mb-3">
            <label for="mo_ta" class="form-label">Mô tả</label>
            <textarea class="form-control" name="mo_ta" required><?= $product['mo_ta'] ?></textarea>
        </div>

        <div class="mb-3">
            <label for="gia" class="form-label">Giá</label>
            <input type="number" class="form-control" name="gia" value="<?= $product['gia'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="ma_loai" class="form-label">Loại sản phẩm</label>
            <select class="form-select" id="ma_loai" name="ma_loai" required>
                <?php foreach ($loaiSanPham->getAll() as $category): ?>
                <option value="<?= $category['ma_loai'] ?>"
                    <?= $category['ma_loai'] == $product['ma_loai'] ? 'selected' : '' ?>>
                    <?= $category['ten_loai'] ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh (Chọn ảnh mới nếu muốn thay đổi)</label>
            <input type="file" class="form-control" name="image">
        </div>

        <button type="submit" class="btn btn-primary" name="update_product">Cập nhật</button>
        <a href="index.php?mod=products&page=<?= $page ?>" class="btn btn-secondary">Trở lại</a>
    </form>
</div>
<?php 
        exit;
    }
}
?>
<div class="container p-4">
    <h3 class="text-center">Danh sách sản phẩm</h3>

    <!-- Form tìm kiếm -->
    <form method="get" class="mb-3 d-flex align-items-center" action="index.php">
        <input type="hidden" name="mod" value="products"> <!-- Tham số mod để chỉ định module -->
        <input type="text" name="search_keyword" class="form-control me-2" style="flex: 1;"
            placeholder="Tìm kiếm sản phẩm" value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>

    <?php
    if (isset($_SESSION['message'])):
        $messageType = $_SESSION['message']['type'];
        $messageContent = $_SESSION['message']['content'];
    ?>
    <div class="alert alert-<?= $messageType ?> alert-dismissible fade show" role="alert">
        <?= $messageContent ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
        Thêm sản phẩm
    </button>

    <div class="card">
        <div class="card-body">
            <form method="post" action="">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width:60px;"> </th>
                            <th style="width:70px;">Mã</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Loại sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th style="width:200px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                        <?php foreach ($products as $index => $product): ?>
                        <tr>
                            <td><input type="checkbox" name="selected_ids[]" value="<?= $product['ma_san_pham'] ?>">
                            </td> <!-- Checkbox cho mỗi sản phẩm -->
                            <td><?= $product['ma_san_pham'] ?></td>
                            <td><?=$product['ten_san_pham']?></td>
                            <td><?= number_format($product['gia'], 0, ',', '.') ?> đ</td>
                            <td><?= htmlspecialchars($product['ten_loai']) ?></td>
                            <td>
                                <img src="../images/<?= $product['image']?>"
                                    alt="<?= htmlspecialchars($product['ten_san_pham']) ?>" style="width: 80px;">
                            </td>
                            <td>
                                <a href="index.php?mod=products&action=edit&id=<?= $product['ma_san_pham'] ?>"
                                    class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Sửa</a>
                                <a href="index.php?mod=products&action=delete&id=<?= $product['ma_san_pham'] ?>"
                                    class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Không có sản phẩm nào.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <button type="submit" name="delete_selected" class="btn btn-danger">Xóa đã chọn</button>
            </form>
        </div>
    </div>


    <!-- Phân trang -->
    <nav class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?mod=products&page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ten_san_pham">Tên sản phẩm</label>
                        <input type="text" class="form-control" id="ten_san_pham" name="ten_san_pham" required>
                    </div>
                    <div class="mb-3">
                        <label for="mo_ta">Mô tả</label>
                        <textarea class="form-control" id="mo_ta" name="mo_ta" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image">Ảnh sản phẩm</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>
                    <div class="mb-3">
                        <label for="gia">Giá</label>
                        <input type="number" class="form-control" id="gia" name="gia" required>
                    </div>
                    <div class="mb-3">
                        <label for="ma_loai">Loại sản phẩm</label>
                        <select class="form-select" id="ma_loai" name="ma_loai" required>
                            <?php foreach ($loaiSanPham->getAll() as $category): ?>
                            <option value="<?= $category['ma_loai'] ?>"><?= $category['ten_loai'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_product" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>