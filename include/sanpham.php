<div class="col-xl-3 col-6 col-md-4">
                        <div class="product-item card">
                                        <a href="index.php?mod=product&ac=detail&masanpham=<?php echo $sanpham["ma_san_pham"] ?>">
                                        <span class="flag">30% off</span>
                                    <div class="product-item-img">
                                        <img src="./images/<?php echo $sanpham["image"] ?>" class="card-img-top" alt="...">
                                    </div>
                                    <div class="card-body">
                                      <h6 class="card-title fw-bold"><?php echo $sanpham["ten_san_pham"] ?></h6>
                                      <p class="card-text"><?php echo number_format($sanpham['gia'], 0, ',', '.') . " đ";   ?></p>
                                      <div class="icon-add">
                                        <i class="fa-solid fa-plus"></i>
                                      </div>
                                    </div>
                                        </a>
                                </div>
</div> 