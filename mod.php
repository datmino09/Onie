<?php 
    $mod = getIndex("mod","home");
    if($mod=="home")
        include ROOT."/home.php";
    if($mod=="product")
        include "module/product/index.php";
    if($mod=="about")
        include "module/about/index.php";
    if($mod=="user")
        include "module/user/index.php";
    if($mod=="giohang")
        include "module/giohang/index.php";
    if($mod=="dondathang")
        include "module/dondathang/index.php";
?>