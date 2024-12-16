<?php 
    if (!defined("ROOT"))
    {
        echo "Err!"; exit;	
    }
    $ac = getIndex("ac","home");
    if ($ac=="home")
		  include ROOT."/module/dondathang/home.php";
    if($ac=="xuly")
      include ROOT."/module/dondathang/xuly.php";
    if($ac=="donhangchuagiao")
      include ROOT."/module/dondathang/donhangchuagiao.php";
    if($ac=="donhangdagiao")
      include ROOT."/module/dondathang/donhangdagiao.php";
    if($ac=="donrong")
      include ROOT."/module/dondathang/donrong.php";
?>