<?php 
    if (!defined("ROOT"))
    {
        echo "Err!"; exit;	
    }
    $ac = getIndex("ac","home");
    if ($ac=="home")
		include ROOT."/module/giohang/home.php";
?>