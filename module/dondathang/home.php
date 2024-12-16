<div class="container my-5">
    <h1 class="text-center mb-4">Đặt hàng thành công</h1>
    <form action="index.php?mod=order&ac=confirm" method="POST">
        <!-- Danh Sách Sản Phẩm -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h5>Danh Sách Sản Phẩm</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Hình Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Đơn Giá</th>
                            <th>Số Lượng</th>
                            <th>Thành Tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $stt = 1; 
                        $total = 0; 
                        foreach ($cartItems as $item) { 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><img src="<?php echo $item['image']; ?>" alt="Hình <?php echo $item['name']; ?>" style="width: 70px; height: 70px;"></td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tổng Tiền và Nút Đặt Hàng -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4 class="text-danger">Tổng Cộng: <?php echo number_format($total, 0, ',', '.'); ?> đ</h4>
                    <button type="submit" class="btn btn-success">Xác Nhận Đặt Hàng</button>
                </div>
            </div>
        </div>
    </form>
</div>
