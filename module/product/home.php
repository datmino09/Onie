
    <section class="product-list pt-4 container">
        <div class="row">
            <div class="col-12">
                <h5 class="fw-bold">Sản Phẩm</h5>
                <div class="btn-filter">
                    <i class="fa-solid fa-filter"></i>
                </div>
                <div class="row">
                    <?php 
                        $pageCurrent = getIndex("page",1);
                        $maloai = getIndex("maloai");
                        $keyword = getIndex("keyword");
                        $sanphams = $SanPham -> getAll($pageCurrent,8,$maloai,$keyword);
                        if(empty($sanphams)){
                            echo "Không tìm thấy sản phẩm";
                        }
                        foreach($sanphams as $sanpham){
                            include "./include/sanpham.php";
                        }
                    ?>  
                </div>
                <nav aria-label="Page navigation example" class="mt-3 <?php echo empty($sanphams)?'d-none':'' ?>">
                    <ul class="pagination justify-content-center">
                        <?php 
                            $totalPage = $SanPham -> getCountPage(8,$maloai,$keyword);
                            for($i=1;$i<=$totalPage;$i++){
                                $activeClass = ($i==$pageCurrent)?"active":"";
                                ?>
                                <li class="page-item <?php echo $activeClass?>"><a class="page-link" href="index.php?mod=product&ac=home&page=<?php echo $i; echo $maloai ? '&maloai=' . $maloai : '';echo $keyword ? '&keyword='.$keyword:'';?>"><?php echo $i ?></a></li>
                            <?php }
                        ?>
                    </ul>
                </nav>
            </div>
            </div>
        </div>
    </section>
    <div id="backTop">
        <i class="fa-solid fa-angles-up"></i>
    </div>