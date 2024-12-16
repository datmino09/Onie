<?php 
    if (!defined("ROOT"))
    {
        echo "Err!"; exit;	
    }
    $ac = getIndex("ac","thongtin");
    if ($ac=="thongtin")
		  include ROOT."/module/user/thongtin.php";
    if ($ac=="logout")
        include ROOT."/module/user/logout.php";
    if ($ac=="edit")
        include ROOT."/module/user/edit.php";
?>